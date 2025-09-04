@extends('layouts.app')

@section('title', 'Mes Réservations')

@section('content')
<div class="inner">
    <header>
        <h1>🎫 Mes Réservations</h1>
        <p>Retrouvez ici toutes vos réservations et tickets</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error" style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info" style="background: #d1ecf1; color: #0c5460; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
            {{ session('info') }}
        </div>
    @endif

    @if($reservations->count() > 0)
        <div class="reservations-list">
            @foreach($reservations as $reservation)
                <div class="reservation-card">
                    <div class="reservation-header">
                        <div class="reservation-info">
                            <h3>Réservation #{{ $reservation->id }}</h3>
                            <p class="reservation-date">
                                Réservé le {{ $reservation->booking_date->format('d/m/Y à H:i') }}
                            </p>
                            <span class="status-badge status-{{ $reservation->status }}">
                                @switch($reservation->status)
                                    @case('pending')
                                        ⏳ En attente de paiement
                                        @break
                                    @case('paid')
                                        ✅ Payé
                                        @break
                                    @case('cancelled')
                                        ❌ Annulé
                                        @break
                                    @default
                                        {{ ucfirst($reservation->status) }}
                                @endswitch
                            </span>
                        </div>
                        <div class="reservation-amount">
                            <strong>€{{ number_format($reservation->total_amount, 2) }}</strong>
                        </div>
                    </div>

                    <div class="reservation-details">
                        @foreach($reservation->representationReservations as $repReservation)
                            <div class="show-details">
                                <div class="show-info">
                                    <h4>{{ $repReservation->representation->show->title }}</h4>
                                    <p class="show-date">
                                        📅 {{ \Carbon\Carbon::parse($repReservation->representation->schedule)->format('d/m/Y à H:i') }}
                                    </p>
                                    <p class="show-location">
                                        📍 {{ $repReservation->representation->location->designation }}
                                    </p>
                                </div>
                                <div class="tickets-info">
                                    @foreach($reservation->representationReservations as $ticket)
                                        @if($ticket->representation_id == $repReservation->representation_id)
                                            <div class="ticket-item">
                                                <span class="ticket-type">{{ ucfirst($ticket->price->type) }}</span>
                                                <span class="ticket-quantity">x{{ $ticket->quantity }}</span>
                                                <span class="ticket-price">€{{ number_format($ticket->price->price * $ticket->quantity, 2) }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="reservation-actions">
                        <a href="{{ route('user-reservations.show', $reservation->id) }}" class="btn btn-primary">
                            Voir les détails
                        </a>
                        
                        @if($reservation->status === 'paid')
                            <button class="btn btn-secondary" onclick="downloadTicket({{ $reservation->id }})">
                                📄 Télécharger le ticket
                            </button>
                        @endif
                        
                        @if($reservation->status === 'pending')
                            <form method="POST" action="{{ route('user-reservations.cancel', $reservation->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                    ❌ Annuler
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-reservations">
            <div class="no-reservations-content">
                <h3>🎭 Aucune réservation trouvée</h3>
                <p>Vous n'avez pas encore de réservations. Découvrez nos spectacles et réservez vos places !</p>
                <a href="{{ route('show.index') }}" class="btn btn-primary">
                    Voir les spectacles
                </a>
            </div>
        </div>
    @endif
</div>

<style>
.reservations-list {
    display: grid;
    gap: 1.5rem;
    margin-top: 2rem;
}

.reservation-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s ease;
}

.reservation-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.reservation-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.reservation-info h3 {
    margin: 0 0 0.5rem 0;
    color: #333;
}

.reservation-date {
    color: #666;
    margin: 0 0 0.5rem 0;
    font-size: 0.9em;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8em;
    font-weight: bold;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-paid {
    background: #d4edda;
    color: #155724;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.reservation-amount {
    font-size: 1.2em;
    font-weight: bold;
    color: #007cba;
}

.reservation-details {
    margin-bottom: 1rem;
}

.show-details {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.show-info h4 {
    margin: 0 0 0.5rem 0;
    color: #333;
}

.show-date, .show-location {
    margin: 0.25rem 0;
    color: #666;
    font-size: 0.9em;
}

.tickets-info {
    text-align: right;
}

.ticket-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
    padding: 0.5rem;
    background: white;
    border-radius: 4px;
    min-width: 200px;
}

.ticket-type {
    font-weight: bold;
    color: #333;
}

.ticket-quantity {
    color: #666;
}

.ticket-price {
    font-weight: bold;
    color: #007cba;
}

.reservation-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-block;
    text-align: center;
}

.btn-primary {
    background: #007cba;
    color: white;
}

.btn-primary:hover {
    background: #005a87;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #545b62;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

.no-reservations {
    text-align: center;
    padding: 3rem 1rem;
}

.no-reservations-content {
    max-width: 400px;
    margin: 0 auto;
}

.no-reservations-content h3 {
    color: #333;
    margin-bottom: 1rem;
}

.no-reservations-content p {
    color: #666;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .reservation-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .show-details {
        flex-direction: column;
        gap: 1rem;
    }
    
    .tickets-info {
        text-align: left;
    }
    
    .reservation-actions {
        flex-direction: column;
    }
}
</style>

<script>
function downloadTicket(reservationId) {
    // Rediriger vers la route de téléchargement
    window.location.href = `/user-reservations/${reservationId}/download-ticket`;
}
</script>
@endsection
