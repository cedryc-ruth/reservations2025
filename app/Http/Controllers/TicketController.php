<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Show;
use App\Models\Representation;
use App\Models\Price;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class TicketController extends Controller
{
    /**
     * Affiche le formulaire d'achat de tickets pour un spectacle
     */
    public function showPurchaseForm(string $showId)
    {
        $show = Show::with(['representations.location', 'prices'])->findOrFail($showId);
        
        // Filtrer les représentations futures
        $representations = $show->representations()
            ->where('schedule', '>', now())
            ->orderBy('schedule')
            ->get();
            
        $prices = $show->prices;
        
        return view('tickets.purchase', compact('show', 'representations', 'prices'));
    }

    /**
     * Traite l'achat de tickets
     */
    public function purchase(Request $request)
    {
        $request->validate([
            'representation_id' => 'required|exists:representations,id',
            'price_id' => 'required|exists:prices,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $representation = Representation::findOrFail($request->representation_id);
        $price = Price::findOrFail($request->price_id);
        $quantity = $request->quantity;
        $totalPrice = $price->price * $quantity;

        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour acheter des tickets.');
        }

        try {
            DB::beginTransaction();

            // Créer le ticket
            $ticket = Ticket::create([
                'user_id' => Auth::id(),
                'representation_id' => $representation->id,
                'price_id' => $price->id,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'purchased_at' => now(),
            ]);

            DB::commit();

            // Créer une session Stripe Checkout
            return $this->createStripeCheckoutSession($ticket);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de l\'achat des tickets.');
        }
    }

    /**
     * Crée une session Stripe Checkout
     */
    private function createStripeCheckoutSession(Ticket $ticket)
    {
        // Configuration Stripe
        Stripe::setApiKey(config('stripe.secret_key'));

        try {
            $session = Session::create([
                'payment_method_types' => config('stripe.payment_method_types', ['card']),
                'line_items' => [[
                    'price_data' => [
                        'currency' => config('stripe.currency', 'eur'),
                        'product_data' => [
                            'name' => config('stripe.product_name_prefix', 'Ticket - ') . $ticket->representation->show->title,
                            'description' => 'Ticket pour ' . $ticket->representation->show->title . 
                                           ' - ' . \Carbon\Carbon::parse($ticket->representation->schedule)->format('d/m/Y à H:i') .
                                           config('stripe.product_description_suffix', ' - Spectacle'),
                        ],
                    ],
                    'unit_amount' => (int)($ticket->total_price * 100), // Stripe utilise les centimes
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('tickets.success', $ticket->id) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('tickets.stripe.cancel', $ticket->id),
                'locale' => config('stripe.locale', 'fr'),
                'metadata' => [
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->user_id,
                ],
            ]);

            return redirect($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création de la session de paiement: ' . $e->getMessage());
        }
    }

    /**
     * Affiche la page de paiement
     */
    public function showPayment(string $ticketId)
    {
        $ticket = Ticket::with(['representation.show', 'price', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($ticketId);

        if ($ticket->status !== 'pending') {
            return redirect()->route('tickets.show', $ticket->id)
                ->with('error', 'Ce ticket ne peut plus être payé.');
        }

        return view('tickets.payment', compact('ticket'));
    }

    /**
     * Traite le paiement
     */
    public function processPayment(Request $request, string $ticketId)
    {
        $request->validate([
            'payment_method' => 'required|in:card,paypal,transfer',
        ]);

        $ticket = Ticket::where('user_id', Auth::id())
            ->findOrFail($ticketId);

        if ($ticket->status !== 'pending') {
            return back()->with('error', 'Ce ticket ne peut plus être payé.');
        }

        try {
            // Simuler le traitement du paiement
            // Dans un vrai projet, vous intégreriez Stripe, PayPal, etc.
            
            $ticket->update([
                'status' => 'paid',
                'payment_method' => $request->payment_method,
                'payment_reference' => 'PAY-' . strtoupper(uniqid()),
            ]);

            return redirect()->route('tickets.show', $ticket->id)
                ->with('success', 'Paiement effectué avec succès ! Vos tickets sont confirmés.');

        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors du paiement.');
        }
    }

    /**
     * Affiche les détails d'un ticket
     */
    public function show(string $ticketId)
    {
        $ticket = Ticket::with(['representation.show', 'price', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($ticketId);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Affiche la liste des tickets de l'utilisateur
     */
    public function index()
    {
        $tickets = Ticket::with(['representation.show', 'price'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Gère le succès du paiement Stripe
     */
    public function success(Request $request, string $ticketId)
    {
        $ticket = Ticket::where('user_id', Auth::id())
            ->findOrFail($ticketId);

        $sessionId = $request->get('session_id');

        if ($sessionId) {
            try {
                // Configuration Stripe
                Stripe::setApiKey(config('stripe.secret_key'));

                // Récupérer la session Stripe
                $session = Session::retrieve($sessionId);

                if ($session->payment_status === 'paid') {
                    // Mettre à jour le ticket
                    $ticket->update([
                        'status' => 'paid',
                        'payment_method' => 'stripe',
                        'payment_reference' => $session->payment_intent,
                    ]);

                    return view('tickets.success', compact('ticket', 'session'));
                }
            } catch (\Exception $e) {
                // En cas d'erreur, on continue quand même
            }
        }

        // Si pas de session Stripe ou erreur, on affiche quand même la page de succès
        return view('tickets.success', compact('ticket'));
    }

    /**
     * Gère l'annulation du paiement Stripe
     */
    public function stripeCancel(string $ticketId)
    {
        $ticket = Ticket::where('user_id', Auth::id())
            ->findOrFail($ticketId);

        // Si le ticket est encore en attente, on peut le supprimer
        if ($ticket->status === 'pending') {
            $ticket->delete();
            return redirect()->route('show.show', $ticket->representation->show->id)
                ->with('error', 'Paiement annulé. Votre commande a été supprimée.');
        }

        return redirect()->route('tickets.show', $ticket->id)
            ->with('error', 'Paiement annulé.');
    }

    /**
     * Annule un ticket
     */
    public function cancel(string $ticketId)
    {
        $ticket = Ticket::where('user_id', Auth::id())
            ->findOrFail($ticketId);

        if ($ticket->status !== 'pending' && $ticket->status !== 'paid') {
            return back()->with('error', 'Ce ticket ne peut plus être annulé.');
        }

        $ticket->update(['status' => 'cancelled']);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket annulé avec succès.');
    }
}
