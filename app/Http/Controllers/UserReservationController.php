<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReservationController extends Controller
{
    /**
     * Afficher toutes les réservations de l'utilisateur connecté
     */
    public function index()
    {
        $user = Auth::user();
        
        $reservations = Reservation::with([
            'representationReservations.representation.show',
            'representationReservations.representation.location',
            'representationReservations.price'
        ])
        ->where('user_id', $user->id)
        ->orderBy('booking_date', 'desc')
        ->get();

        return view('user-reservations.index', compact('reservations', 'user'));
    }

    /**
     * Afficher les détails d'une réservation spécifique
     */
    public function show($id)
    {
        $reservation = Reservation::with([
            'user',
            'representationReservations.representation.show',
            'representationReservations.representation.location',
            'representationReservations.price'
        ])->findOrFail($id);

        // Vérifier que l'utilisateur peut voir cette réservation
        if ($reservation->user_id != Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('user-reservations.show', compact('reservation'));
    }

    /**
     * Annuler une réservation (si elle n'est pas encore payée)
     */
    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Vérifier que l'utilisateur peut annuler cette réservation
        if ($reservation->user_id != Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifier que la réservation peut être annulée
        if ($reservation->status === 'paid') {
            return back()->with('error', 'Impossible d\'annuler une réservation déjà payée.');
        }

        if ($reservation->status === 'cancelled') {
            return back()->with('error', 'Cette réservation est déjà annulée.');
        }

        // Annuler la réservation
        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Réservation annulée avec succès.');
    }

    /**
     * Télécharger le ticket (PDF) - fonctionnalité future
     */
    public function downloadTicket($id)
    {
        $reservation = Reservation::with([
            'representationReservations.representation.show',
            'representationReservations.representation.location',
            'representationReservations.price'
        ])->findOrFail($id);

        // Vérifier que l'utilisateur peut télécharger ce ticket
        if ($reservation->user_id != Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifier que la réservation est payée
        if ($reservation->status !== 'paid') {
            return back()->with('error', 'Impossible de télécharger le ticket d\'une réservation non payée.');
        }

        // TODO: Implémenter la génération de PDF
        return back()->with('info', 'Fonctionnalité de téléchargement de ticket en cours de développement.');
    }
}
