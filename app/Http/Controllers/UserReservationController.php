<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReservationController extends Controller
{
    /**
     * Afficher toutes les réservations de l'utilisateur connecté avec filtres
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Reservation::with([
            'representationReservations.representation.show',
            'representationReservations.representation.location',
            'representationReservations.price'
        ])
        ->where('user_id', $user->id);

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtre par date de réservation
        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }

        // Filtre par nom de spectacle
        if ($request->filled('show_search')) {
            $query->whereHas('representationReservations.representation.show', function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->show_search . '%');
            });
        }

        // Filtre par date de spectacle
        if ($request->filled('show_date_from')) {
            $query->whereHas('representationReservations.representation', function($q) use ($request) {
                $q->whereDate('schedule', '>=', $request->show_date_from);
            });
        }

        if ($request->filled('show_date_to')) {
            $query->whereHas('representationReservations.representation', function($q) use ($request) {
                $q->whereDate('schedule', '<=', $request->show_date_to);
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'booking_date');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if ($sortBy === 'show_date') {
            $query->join('representation_reservation', 'reservations.id', '=', 'representation_reservation.reservation_id')
                  ->join('representations', 'representation_reservation.representation_id', '=', 'representations.id')
                  ->orderBy('representations.schedule', $sortOrder)
                  ->select('reservations.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $reservations = $query->get();

        // Statistiques pour les filtres
        $stats = [
            'total' => Reservation::where('user_id', $user->id)->count(),
            'pending' => Reservation::where('user_id', $user->id)->where('status', 'pending')->count(),
            'paid' => Reservation::where('user_id', $user->id)->where('status', 'paid')->count(),
            'cancelled' => Reservation::where('user_id', $user->id)->where('status', 'cancelled')->count(),
        ];

        return view('user-reservations.index', compact('reservations', 'user', 'stats'));
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
