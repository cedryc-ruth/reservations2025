<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Representation;
use App\Models\Price;
use App\Models\Reservation;
use App\Models\RepresentationReservation;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Créer une session de paiement Stripe
     */
    public function createPaymentSession(Request $request)
    {
        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'representation_id' => 'required|exists:representations,id',
            'tickets' => 'required|array|min:1',
            'tickets.*.price_id' => 'required|exists:prices,id',
            'tickets.*.quantity' => 'required|integer|min:0|max:10',
        ]);

        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour effectuer un paiement.');
        }

        $show = Show::findOrFail($request->show_id);
        $representation = Representation::findOrFail($request->representation_id);

        // Vérifier que la représentation appartient au spectacle
        if ($representation->show_id != $show->id) {
            return back()->with('error', 'Représentation invalide pour ce spectacle.');
        }

        // Vérifier que la représentation est dans le futur
        if ($representation->schedule <= now()) {
            return back()->with('error', 'Cette représentation a déjà eu lieu.');
        }

        // Préparer les données pour Stripe
        $tickets = [];
        $totalAmount = 0;

        foreach ($request->tickets as $ticket) {
            if ($ticket['quantity'] > 0) {
                $price = Price::findOrFail($ticket['price_id']);
                $subtotal = $price->price * $ticket['quantity'];
                $totalAmount += $subtotal;

                $tickets[] = [
                    'type' => $price->type,
                    'description' => $price->description,
                    'price' => $price->price,
                    'quantity' => $ticket['quantity'],
                    'price_id' => $price->id,
                ];
            }
        }

        if (empty($tickets)) {
            return back()->with('error', 'Aucun ticket sélectionné.');
        }

        // Créer une réservation temporaire
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'booking_date' => now(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Créer les réservations de représentation
        foreach ($tickets as $ticket) {
            RepresentationReservation::create([
                'reservation_id' => $reservation->id,
                'representation_id' => $representation->id,
                'price_id' => $ticket['price_id'],
                'quantity' => $ticket['quantity'],
            ]);
        }

        // Formater les items pour Stripe
        $lineItems = $this->stripeService->formatLineItems($tickets, $show->title);

        // URLs de redirection
        $successUrl = route('payment.success', ['reservation' => $reservation->id]);
        $cancelUrl = route('payment.cancel', ['reservation' => $reservation->id]);

        // Métadonnées
        $metadata = [
            'reservation_id' => $reservation->id,
            'show_id' => $show->id,
            'representation_id' => $representation->id,
            'user_id' => Auth::id(),
        ];

        try {
            // Créer la session Stripe
            $session = $this->stripeService->createCheckoutSession(
                $lineItems,
                $successUrl,
                $cancelUrl,
                $metadata
            );

            // Sauvegarder l'ID de session dans la réservation
            $reservation->update(['stripe_session_id' => $session->id]);

            // Rediriger vers Stripe Checkout
            return redirect($session->url);

        } catch (\Exception $e) {
            Log::error('Erreur Stripe: ' . $e->getMessage());
            
            // Supprimer la réservation en cas d'erreur
            $reservation->delete();
            
            return back()->with('error', 'Erreur lors de la création de la session de paiement.');
        }
    }

    /**
     * Gérer le succès du paiement
     */
    public function paymentSuccess(Request $request, $reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Vérifier que l'utilisateur peut voir cette réservation
        if ($reservation->user_id != Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Récupérer la session Stripe
        if ($reservation->stripe_session_id) {
            try {
                $session = $this->stripeService->retrieveSession($reservation->stripe_session_id);
                
                if ($session->payment_status === 'paid') {
                    // Marquer la réservation comme payée
                    $reservation->update([
                        'status' => 'paid',
                        'stripe_payment_intent_id' => $session->payment_intent,
                    ]);

                    return redirect()->route('booking.confirmation', $reservation->id)
                        ->with('success', 'Paiement effectué avec succès !');
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de la vérification du paiement: ' . $e->getMessage());
            }
        }

        return redirect()->route('booking.confirmation', $reservation->id)
            ->with('warning', 'Paiement en cours de traitement...');
    }

    /**
     * Gérer l'annulation du paiement
     */
    public function paymentCancel(Request $request, $reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Vérifier que l'utilisateur peut voir cette réservation
        if ($reservation->user_id != Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Marquer la réservation comme annulée
        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('show.show', $reservation->representationReservations->first()->representation->show_id)
            ->with('error', 'Paiement annulé. Votre réservation a été supprimée.');
    }

    /**
     * Webhook Stripe pour les événements
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload: ' . $e->getMessage());
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        // Gérer les événements
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
            default:
                Log::info('Unhandled event type: ' . $event->type);
        }

        return response('OK', 200);
    }

    /**
     * Gérer l'événement checkout.session.completed
     */
    private function handleCheckoutSessionCompleted($session)
    {
        $reservationId = $session->metadata->reservation_id ?? null;
        
        if ($reservationId) {
            $reservation = Reservation::find($reservationId);
            if ($reservation) {
                $reservation->update([
                    'status' => 'paid',
                    'stripe_payment_intent_id' => $session->payment_intent,
                ]);
            }
        }
    }

    /**
     * Gérer l'événement payment_intent.succeeded
     */
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        // Logique supplémentaire si nécessaire
        Log::info('Payment succeeded: ' . $paymentIntent->id);
    }
}
