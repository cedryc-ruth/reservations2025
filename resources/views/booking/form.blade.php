@extends('layouts.app')

@section('title', 'Réservation - ' . $show->title)

@section('content')
<div class="inner">
    <header>
        <h1>Réservation - {{ $show->title }}</h1>
        <p>Choisissez votre date et vos tickets</p>
    </header>

    <div class="booking-form">
        <form method="POST" action="{{ route('booking.process') }}" id="bookingForm">
            @csrf
            <input type="hidden" name="show_id" value="{{ $show->id }}">

            <!-- Sélection de la date -->
            <div class="form-section">
                <h3>📅 Choisir la date</h3>
                <div class="date-selection">
                    @foreach($representations as $representation)
                        <div class="date-option">
                            <input type="radio" 
                                   name="representation_id" 
                                   value="{{ $representation->id }}" 
                                   id="rep_{{ $representation->id }}"
                                   class="date-radio"
                                   required>
                            <label for="rep_{{ $representation->id }}" class="date-label">
                                <div class="date-info">
                                    <strong>{{ \Carbon\Carbon::parse($representation->schedule)->format('d/m/Y') }}</strong>
                                    <span>{{ \Carbon\Carbon::parse($representation->schedule)->format('H:i') }}</span>
                                    <small>{{ $representation->location->designation }}</small>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Sélection des tickets -->
            <div class="form-section">
                <h3>🎫 Choisir vos tickets</h3>
                <div class="tickets-selection">
                    @foreach($show->prices as $price)
                        <div class="ticket-option">
                            <div class="ticket-info">
                                <h4>{{ ucfirst($price->type) }}</h4>
                                <p class="price">€{{ number_format($price->price, 2) }}</p>
                                <p class="description">{{ $price->description }}</p>
                            </div>
                            <div class="quantity-selector">
                                <label for="tickets_{{ $price->id }}_quantity">Quantité:</label>
                                <select name="tickets[{{ $price->id }}][quantity]" 
                                        id="tickets_{{ $price->id }}_quantity"
                                        class="quantity-select"
                                        data-price="{{ $price->price }}"
                                        data-type="{{ $price->type }}">
                                    <option value="0">0</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <input type="hidden" name="tickets[{{ $price->id }}][price_id]" value="{{ $price->id }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Résumé et total -->
            <div class="form-section">
                <h3>💰 Résumé de votre commande</h3>
                <div id="order-summary" class="order-summary">
                    <p>Aucun ticket sélectionné</p>
                </div>
                <div class="total-section">
                    <strong>Total: <span id="total-amount">€0.00</span></strong>
                </div>
            </div>

            <!-- Bouton de réservation -->
            <div class="form-actions">
                <a href="{{ route('show.show', $show->id) }}" class="btn btn-secondary">← Retour au spectacle</a>
                <button type="submit" class="btn btn-primary" id="book-button" disabled>
                    Réserver maintenant
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.booking-form {
    max-width: 800px;
    margin: 0 auto;
}

.form-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
}

.date-selection {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}

.date-option {
    position: relative;
}

.date-radio {
    position: absolute;
    opacity: 0;
}

.date-label {
    display: block;
    padding: 1rem;
    border: 2px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.date-radio:checked + .date-label {
    border-color: #007cba;
    background: #e3f2fd;
}

.date-info {
    text-align: center;
}

.date-info strong {
    display: block;
    font-size: 1.1em;
    margin-bottom: 0.5rem;
}

.date-info span {
    display: block;
    font-size: 1.2em;
    color: #007cba;
    margin-bottom: 0.5rem;
}

.date-info small {
    color: #666;
}

.tickets-selection {
    display: grid;
    gap: 1rem;
}

.ticket-option {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: white;
}

.ticket-info h4 {
    margin: 0 0 0.5rem 0;
    color: #333;
}

.price {
    font-size: 1.3em;
    font-weight: bold;
    color: #007cba;
    margin: 0 0 0.5rem 0;
}

.description {
    margin: 0;
    color: #666;
    font-size: 0.9em;
}

.quantity-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-select {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    min-width: 60px;
}

.order-summary {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #ddd;
    min-height: 100px;
}

.total-section {
    text-align: right;
    font-size: 1.2em;
    margin-top: 1rem;
    padding: 1rem;
    background: #e8f5e8;
    border-radius: 8px;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
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
}

.btn-primary {
    background: #007cba;
    color: white;
}

.btn-primary:hover:not(:disabled) {
    background: #005a87;
}

.btn-primary:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #545b62;
}

.ticket-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 4px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantitySelects = document.querySelectorAll('.quantity-select');
    const orderSummary = document.getElementById('order-summary');
    const totalAmount = document.getElementById('total-amount');
    const bookButton = document.getElementById('book-button');
    
    function updateOrderSummary() {
        let total = 0;
        let hasTickets = false;
        let summaryHTML = '';
        
        quantitySelects.forEach(select => {
            const quantity = parseInt(select.value);
            if (quantity > 0) {
                hasTickets = true;
                const price = parseFloat(select.dataset.price);
                const type = select.dataset.type;
                const subtotal = price * quantity;
                total += subtotal;
                
                summaryHTML += `
                    <div class="ticket-item">
                        <span>${type} x${quantity}</span>
                        <span>€${subtotal.toFixed(2)}</span>
                    </div>
                `;
            }
        });
        
        if (hasTickets) {
            orderSummary.innerHTML = summaryHTML;
            totalAmount.textContent = `€${total.toFixed(2)}`;
            bookButton.disabled = false;
        } else {
            orderSummary.innerHTML = '<p>Aucun ticket sélectionné</p>';
            totalAmount.textContent = '€0.00';
            bookButton.disabled = true;
        }
    }
    
    quantitySelects.forEach(select => {
        select.addEventListener('change', updateOrderSummary);
    });
    
    // Initialiser le résumé
    updateOrderSummary();
});
</script>
@endsection
