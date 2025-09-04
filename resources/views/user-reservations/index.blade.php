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

    <!-- Statistiques rapides -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number">{{ $stats['total'] }}</span>
                <span class="stat-label">Total</span>
            </div>
            <div class="stat-item pending">
                <span class="stat-number">{{ $stats['pending'] }}</span>
                <span class="stat-label">En attente</span>
            </div>
            <div class="stat-item paid">
                <span class="stat-number">{{ $stats['paid'] }}</span>
                <span class="stat-label">Payées</span>
            </div>
            <div class="stat-item cancelled">
                <span class="stat-number">{{ $stats['cancelled'] }}</span>
                <span class="stat-label">Annulées</span>
            </div>
        </div>
    </div>

    <!-- Filtres de recherche -->
    <div class="filters-section">
        <h3>🔍 Rechercher et filtrer</h3>
        <form method="GET" action="{{ route('user-reservations.index') }}" class="filters-form">
            <div class="filters-grid">
                <!-- Recherche par spectacle -->
                <div class="filter-group">
                    <label for="show_search">Spectacle :</label>
                    <input type="text" 
                           name="show_search" 
                           id="show_search" 
                           value="{{ request('show_search') }}"
                           placeholder="Nom du spectacle...">
                </div>

                <!-- Filtre par statut -->
                <div class="filter-group">
                    <label for="status">Statut :</label>
                    <select name="status" id="status">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payé</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>

                <!-- Date de réservation -->
                <div class="filter-group">
                    <label for="date_from">Réservé du :</label>
                    <input type="date" 
                           name="date_from" 
                           id="date_from" 
                           value="{{ request('date_from') }}">
                </div>

                <div class="filter-group">
                    <label for="date_to">Réservé au :</label>
                    <input type="date" 
                           name="date_to" 
                           id="date_to" 
                           value="{{ request('date_to') }}">
                </div>

                <!-- Date de spectacle -->
                <div class="filter-group">
                    <label for="show_date_from">Spectacle du :</label>
                    <input type="date" 
                           name="show_date_from" 
                           id="show_date_from" 
                           value="{{ request('show_date_from') }}">
                </div>

                <div class="filter-group">
                    <label for="show_date_to">Spectacle au :</label>
                    <input type="date" 
                           name="show_date_to" 
                           id="show_date_to" 
                           value="{{ request('show_date_to') }}">
                </div>

                <!-- Tri -->
                <div class="filter-group">
                    <label for="sort_by">Trier par :</label>
                    <select name="sort_by" id="sort_by">
                        <option value="booking_date" {{ request('sort_by') == 'booking_date' ? 'selected' : '' }}>Date de réservation</option>
                        <option value="show_date" {{ request('sort_by') == 'show_date' ? 'selected' : '' }}>Date du spectacle</option>
                        <option value="total_amount" {{ request('sort_by') == 'total_amount' ? 'selected' : '' }}>Montant</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort_order">Ordre :</label>
                    <select name="sort_order" id="sort_order">
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Croissant</option>
                    </select>
                </div>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    🔍 Rechercher
                </button>
                <a href="{{ route('user-reservations.index') }}" class="btn btn-secondary">
                    🗑️ Effacer les filtres
                </a>
            </div>
        </form>
    </div>

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
                        @if($reservation->representationReservations->count() > 0)
                            @php
                                // Récupérer les informations du spectacle depuis la première représentation
                                $firstRepReservation = $reservation->representationReservations->first();
                                $show = $firstRepReservation->representation->show;
                                $representation = $firstRepReservation->representation;
                                $location = $representation->location;
                                
                                // Grouper les tickets par type de prix pour éviter la répétition
                                $ticketsByPrice = $reservation->representationReservations->groupBy('price_id');
                            @endphp
                            
                            <div class="show-details">
                                <div class="show-info">
                                    <h4>{{ $show->title }}</h4>
                                    <p class="show-date">
                                        📅 {{ \Carbon\Carbon::parse($representation->schedule)->format('d/m/Y à H:i') }}
                                    </p>
                                    <p class="show-location">
                                        📍 {{ $location->designation }}
                                    </p>
                                </div>
                                <div class="tickets-info">
                                    @foreach($ticketsByPrice as $priceId => $repReservations)
                                        @php
                                            $firstRepReservation = $repReservations->first();
                                            $price = $firstRepReservation->price;
                                            $totalQuantity = $repReservations->sum('quantity');
                                            $subtotal = $price->price * $totalQuantity;
                                        @endphp
                                        <div class="ticket-item">
                                            <span class="ticket-type">{{ ucfirst($price->type) }}</span>
                                            <span class="ticket-quantity">x{{ $totalQuantity }}</span>
                                            <span class="ticket-price">€{{ number_format($subtotal, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="show-details">
                                <div class="show-info">
                                    <h4>⚠️ Aucune représentation trouvée</h4>
                                    <p class="show-date">Cette réservation n'a pas de représentations associées.</p>
                                </div>
                            </div>
                        @endif
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
/* Statistiques */
.stats-section {
    margin: 2rem 0;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.stat-item.pending {
    border-color: #ffc107;
}

.stat-item.paid {
    border-color: #28a745;
}

.stat-item.cancelled {
    border-color: #dc3545;
}

.stat-number {
    display: block;
    font-size: 2em;
    font-weight: bold;
    color: #333;
    margin-bottom: 0.5rem;
}

.stat-item.pending .stat-number {
    color: #856404;
}

.stat-item.paid .stat-number {
    color: #155724;
}

.stat-item.cancelled .stat-number {
    color: #721c24;
}

.stat-label {
    font-size: 0.9em;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Filtres */
.filters-section {
    margin: 2rem 0;
    padding: 1.5rem;
    background: white;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filters-section h3 {
    margin-top: 0;
    margin-bottom: 1.5rem;
    color: #333;
    border-bottom: 2px solid #007cba;
    padding-bottom: 0.5rem;
}

.filters-form {
    width: 100%;
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-weight: bold;
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 0.9em;
}

.filter-group input,
.filter-group select {
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 0.9em;
    transition: border-color 0.3s ease;
}

.filter-group input:focus,
.filter-group select:focus {
    outline: none;
    border-color: #007cba;
    box-shadow: 0 0 0 2px rgba(0, 124, 186, 0.2);
}

.filter-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

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

// Amélioration de l'expérience utilisateur
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit du formulaire lors du changement des filtres
    const filterInputs = document.querySelectorAll('#status, #sort_by, #sort_order');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Délai pour éviter trop de requêtes
            setTimeout(() => {
                this.form.submit();
            }, 300);
        });
    });

    // Validation des dates
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');
    const showDateFrom = document.getElementById('show_date_from');
    const showDateTo = document.getElementById('show_date_to');

    function validateDateRange(fromInput, toInput) {
        if (fromInput.value && toInput.value) {
            if (new Date(fromInput.value) > new Date(toInput.value)) {
                toInput.setCustomValidity('La date de fin doit être après la date de début');
            } else {
                toInput.setCustomValidity('');
            }
        }
    }

    if (dateFrom && dateTo) {
        dateFrom.addEventListener('change', () => validateDateRange(dateFrom, dateTo));
        dateTo.addEventListener('change', () => validateDateRange(dateFrom, dateTo));
    }

    if (showDateFrom && showDateTo) {
        showDateFrom.addEventListener('change', () => validateDateRange(showDateFrom, showDateTo));
        showDateTo.addEventListener('change', () => validateDateRange(showDateFrom, showDateTo));
    }

    // Animation des statistiques
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const finalValue = parseInt(stat.textContent);
        let currentValue = 0;
        const increment = finalValue / 20;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                stat.textContent = finalValue;
                clearInterval(timer);
            } else {
                stat.textContent = Math.floor(currentValue);
            }
        }, 50);
    });

    // Recherche en temps réel pour le nom du spectacle
    const showSearchInput = document.getElementById('show_search');
    if (showSearchInput) {
        let searchTimeout;
        showSearchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
        });
    }
});
</script>
@endsection
