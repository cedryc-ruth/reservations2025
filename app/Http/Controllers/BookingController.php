<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Representation;
use App\Models\Price;
use App\Models\Reservation;
use App\Models\RepresentationReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Afficher le formulaire de réservation pour un spectacle
     */
    public function showBookingForm($showId)
    {
        $show = Show::with(['representations.location', 'prices'])->findOrFail($showId);
        
        // Vérifier si le spectacle est réservable
        if (!$show->bookable) {
            return redirect()->route('show.show', $showId)
                ->with('error', 'Ce spectacle n\'est pas réservable.');
        }
        
        // Récupérer les représentations futures uniquement
        $representations = $show->representations()
            ->where('schedule', '>', now())
            ->orderBy('schedule')
            ->get();
            
        if ($representations->isEmpty()) {
            return redirect()->route('show.show', $showId)
                ->with('error', 'Aucune représentation disponible pour ce spectacle.');
        }
        
        return view('booking.form', compact('show', 'representations'));
    }
    
    /**
     * Traiter la réservation
     */
    public function processBooking(Request $request)
    {
        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'representation_id' => 'required|exists:representations,id',
            'tickets' => 'required|array|min:1',
            'tickets.*.price_id' => 'required|exists:prices,id',
            'tickets.*.quantity' => 'required|integer|min:1|max:10',
        ]);
        
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour effectuer une réservation.');
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
        
        DB::beginTransaction();
        
        try {
            // Créer la réservation
            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'booking_date' => now(),
            ]);
            
            $totalAmount = 0;
            
            // Traiter chaque type de ticket
            foreach ($request->tickets as $ticket) {
                if ($ticket['quantity'] > 0) {
                    $price = Price::findOrFail($ticket['price_id']);
                    $subtotal = $price->price * $ticket['quantity'];
                    $totalAmount += $subtotal;
                    
                    // Créer la réservation de représentation
                    RepresentationReservation::create([
                        'reservation_id' => $reservation->id,
                        'representation_id' => $representation->id,
                        'price_id' => $price->id,
                        'quantity' => $ticket['quantity'],
                    ]);
                }
            }
            
            // Mettre à jour le montant total de la réservation
            $reservation->update(['total_amount' => $totalAmount]);
            
            DB::commit();
            
            return redirect()->route('booking.confirmation', $reservation->id)
                ->with('success', 'Réservation effectuée avec succès !');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Une erreur est survenue lors de la réservation.');
        }
    }
    
    /**
     * Afficher la confirmation de réservation
     */
    public function confirmation($reservationId)
    {
        $reservation = Reservation::with([
            'user',
            'representationReservations.representation.show',
            'representationReservations.representation.location',
            'representationReservations.price'
        ])->findOrFail($reservationId);
        
        // Vérifier que l'utilisateur peut voir cette réservation
        if ($reservation->user_id != Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        
        return view('booking.confirmation', compact('reservation'));
    }
}
