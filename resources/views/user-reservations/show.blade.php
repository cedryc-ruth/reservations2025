@extends('layouts.app')

@section('title', 'Détails de la réservation #' . $reservation->id)

@section('content')
<div class="inner">
    <header>
        <h1>🎫 Détails de la réservation #{{ $reservation->id }}</h1>
        <p>Informations complètes de votre réservation</p>
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

    <div class="reservation-details">
        <!-- Informations générales -->
        <div class="detail-section">
            <h3>📋 Informations générales</h3>
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
                    <strong>Statut:</strong>
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
                <div class="info-item">
                    <strong>Montant total:</strong>
                    <span class="total-amount">€{{ number_format($reservation->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Détails du spectacle -->
        <div class="detail-section">
            <h3>🎭 Détails du spectacle</h3>
            @if($reservation->representationReservations->count() > 0)
                @php
                    // Récupérer les informations du spectacle depuis la première représentation
                    $firstRepReservation = $reservation->representationReservations->first();
                    $show = $firstRepReservation->representation->show;
                    $representation = $firstRepReservation->representation;
                    $location = $representation->location;
                @endphp
                
                <div class="show-details">
                    <div class="show-poster">
                        <img src="{{ asset('images/' . $show->poster_url) }}" 
                             alt="{{ $show->title }}"
                             style="width: 150px; height: 200px; object-fit: cover; border-radius: 8px;">
                    </div>
                    <div class="show-info">
                        <h4>{{ $show->title }}</h4>
                        <p class="show-description">{{ $show->description }}</p>
                        
                        <div class="show-meta">
                            <p><strong>📅 Date du spectacle:</strong> 
                               {{ \Carbon\Carbon::parse($representation->schedule)->format('d/m/Y à H:i') }}</p>
                            <p><strong>📍 Lieu:</strong> {{ $location->designation }}</p>
                            <p><strong>🏠 Adresse:</strong> {{ $location->address }}</p>
                            <p><strong>⏱️ Durée:</strong> {{ $show->duration }} minutes</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="show-details">
                    <div class="show-info">
                        <h4>⚠️ Aucune représentation trouvée</h4>
                        <p>Cette réservation n'a pas de représentations associées.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Détails des tickets -->
        <div class="detail-section">
            <h3>🎫 Vos tickets</h3>
            @if($reservation->representationReservations->count() > 0)
                <div class="tickets-list">
                    @php
                        // Grouper les tickets par type de prix pour éviter la répétition
                        $ticketsByPrice = $reservation->representationReservations->groupBy('price_id');
                    @endphp
                    
                    @foreach($ticketsByPrice as $priceId => $repReservations)
                        @php
                            $firstRepReservation = $repReservations->first();
                            $price = $firstRepReservation->price;
                            $totalQuantity = $repReservations->sum('quantity');
                            $subtotal = $price->price * $totalQuantity;
                        @endphp
                        
                        <div class="ticket-card">
                            <div class="ticket-header">
                                <h4>{{ ucfirst($price->type) }}</h4>
                                <span class="ticket-quantity">x{{ $totalQuantity }}</span>
                            </div>
                            <div class="ticket-details">
                                <p><strong>Description:</strong> {{ $price->description }}</p>
                                <p><strong>Prix unitaire:</strong> €{{ number_format($price->price, 2) }}</p>
                                <p><strong>Sous-total:</strong> €{{ number_format($subtotal, 2) }}</p>
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
            @else
                <div class="tickets-list">
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <h4>⚠️ Aucun ticket trouvé</h4>
                        </div>
                        <div class="ticket-details">
                            <p>Cette réservation n'a pas de tickets associés.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Informations de paiement -->
        @if($reservation->status === 'paid')
            <div class="detail-section">
                <h3>💳 Informations de paiement</h3>
                <div class="payment-info">
                    <p><strong>Méthode de paiement:</strong> Stripe (Carte bancaire)</p>
                    @if($reservation->stripe_payment_intent_id)
                        <p><strong>ID de transaction:</strong> {{ $reservation->stripe_payment_intent_id }}</p>
                    @endif
                    <p><strong>Date de paiement:</strong> {{ $reservation->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="detail-section">
            <h3>🔧 Actions</h3>
            <div class="actions">
                <a href="{{ route('user-reservations.index') }}" class="btn btn-secondary">
                    ← Retour à mes réservations
                </a>
                
                @if($reservation->status === 'paid')
                    <button class="btn btn-primary" onclick="downloadTicket({{ $reservation->id }})">
                        📄 Télécharger le ticket
                    </button>
                @endif
                
                @if($reservation->status === 'pending')
                    <form method="POST" action="{{ route('user-reservations.cancel', $reservation->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                            ❌ Annuler la réservation
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.reservation-details {
    max-width: 800px;
    margin: 0 auto;
}

.detail-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
}

.detail-section h3 {
    margin-top: 0;
    color: #333;
    border-bottom: 2px solid #007cba;
    padding-bottom: 0.5rem;
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

.total-amount {
    color: #007cba;
    font-size: 1.2em;
}

.show-details {
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
}

.show-poster img {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.show-info h4 {
    margin-top: 0;
    color: #333;
}

.show-description {
    color: #666;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.show-meta p {
    margin: 0.5rem 0;
    color: #555;
}

.tickets-list {
    margin-bottom: 1rem;
}

.ticket-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.ticket-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.ticket-header h4 {
    margin: 0;
    color: #333;
}

.ticket-quantity {
    background: #007cba;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8em;
}

.ticket-details p {
    margin: 0.25rem 0;
    color: #666;
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

.payment-info {
    background: white;
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
}

.payment-info p {
    margin: 0.5rem 0;
    color: #555;
}

.actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
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

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .show-details {
        flex-direction: column;
    }
    
    .actions {
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
