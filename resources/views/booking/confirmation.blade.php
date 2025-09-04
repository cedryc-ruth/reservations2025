@extends('layouts.app')

@section('title', 'Confirmation de réservation')

@section('content')
<div class="inner">
    <header>
        <h1>✅ Réservation confirmée !</h1>
        <p>Votre réservation a été effectuée avec succès</p>
    </header>

    <div class="confirmation-details">
        <div class="reservation-info">
            <h3>📋 Détails de votre réservation</h3>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Numéro de réservation:</strong>
                    <span>#{{ $reservation->id }}</span>
                </div>
                <div class="info-item">
                    <strong>Date de réservation:</strong>
                    <span>{{ $reservation->booking_date->format('d/m/Y à H:i') }}</span>
                </div>
                <div class="info-item">
                    <strong>Spectacle:</strong>
                    <span>{{ $reservation->representationReservations->first()->representation->show->title }}</span>
                </div>
                <div class="info-item">
                    <strong>Date du spectacle:</strong>
                    <span>{{ \Carbon\Carbon::parse($reservation->representationReservations->first()->representation->schedule)->format('d/m/Y à H:i') }}</span>
                </div>
                <div class="info-item">
                    <strong>Lieu:</strong>
                    <span>{{ $reservation->representationReservations->first()->representation->location->designation }}</span>
                </div>
                <div class="info-item">
                    <strong>Adresse:</strong>
                    <span>{{ $reservation->representationReservations->first()->representation->location->address }}</span>
                </div>
            </div>
        </div>

        <div class="tickets-details">
            <h3>🎫 Vos tickets</h3>
            <div class="tickets-list">
                @foreach($reservation->representationReservations as $repReservation)
                    <div class="ticket-item">
                        <div class="ticket-type">
                            <strong>{{ ucfirst($repReservation->price->type) }}</strong>
                            <span class="quantity">x{{ $repReservation->quantity }}</span>
                        </div>
                        <div class="ticket-price">
                            <span class="unit-price">€{{ number_format($repReservation->price->price, 2) }} chacun</span>
                            <span class="subtotal">€{{ number_format($repReservation->price->price * $repReservation->quantity, 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="total-section">
                <div class="total-line">
                    <strong>Total payé:</strong>
                    <strong class="total-amount">€{{ number_format($reservation->total_amount, 2) }}</strong>
                </div>
            </div>
        </div>

        <div class="important-info">
            <h3>⚠️ Informations importantes</h3>
            <ul>
                <li>Présentez-vous au moins 15 minutes avant le début du spectacle</li>
                <li>Apportez une pièce d'identité pour les tarifs réduits</li>
                <li>Les tickets ne sont pas remboursables</li>
                <li>En cas d'annulation du spectacle, vous serez contacté par email</li>
            </ul>
        </div>

        <div class="actions">
            <a href="{{ route('show.index') }}" class="btn btn-primary">
                Voir d'autres spectacles
            </a>
            <a href="{{ route('reservation.show', $reservation->id) }}" class="btn btn-secondary">
                Voir mes réservations
            </a>
        </div>
    </div>
</div>

<style>
.confirmation-details {
    max-width: 800px;
    margin: 0 auto;
}

.reservation-info,
.tickets-details,
.important-info {
    margin-bottom: 2rem;
    padding: 1.5rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
}

.info-grid {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem;
    background: white;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
}

.info-item strong {
    color: #333;
}

.tickets-list {
    margin-bottom: 1rem;
}

.ticket-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    margin-bottom: 0.5rem;
    background: white;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
}

.ticket-type {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity {
    background: #007cba;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8em;
}

.ticket-price {
    text-align: right;
}

.unit-price {
    display: block;
    font-size: 0.9em;
    color: #666;
}

.subtotal {
    font-weight: bold;
    color: #007cba;
}

.total-section {
    border-top: 2px solid #007cba;
    padding-top: 1rem;
    margin-top: 1rem;
}

.total-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.2em;
    padding: 1rem;
    background: #e8f5e8;
    border-radius: 6px;
}

.total-amount {
    color: #007cba;
    font-size: 1.3em;
}

.important-info ul {
    margin: 0;
    padding-left: 1.5rem;
}

.important-info li {
    margin-bottom: 0.5rem;
    color: #666;
}

.actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #ddd;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-block;
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

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .actions {
        flex-direction: column;
    }
    
    .ticket-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .ticket-price {
        text-align: left;
    }
}
</style>
@endsection
