<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Show;
use App\Models\Representation;
use App\Models\Price;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

            // Rediriger vers la page de paiement
            return redirect()->route('tickets.payment', $ticket->id)
                ->with('success', 'Tickets ajoutés au panier. Veuillez procéder au paiement.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de l\'achat des tickets.');
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
