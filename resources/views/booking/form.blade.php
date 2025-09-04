@extends('layouts.app')

@section('title', 'Réservation - ' . $show->title)

@section('content')
<div class="inner">
    <header>
        <h1>Réservation - {{ $show->title }}</h1>
        <p>Choisissez votre date et vos tickets</p>
    </header>

    <div class="booking-form">
        <form method="POST" action="{{ route('payment.create') }}" id="bookingForm">
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
                <p class="ticket-instructions">
                    <strong>💡 Instructions :</strong> Sélectionnez la quantité de tickets que vous souhaitez pour chaque type de prix. 
                    Vous pouvez choisir 0 ticket pour un type si vous n'en voulez pas, ou plusieurs tickets du même type.
                </p>
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
                                <div class="quantity-counter">
                                    <button type="button" 
                                            class="quantity-btn quantity-minus" 
                                            data-target="tickets_{{ $price->id }}_quantity"
                                            data-price="{{ $price->price }}"
                                            data-type="{{ $price->type }}">
                                        <span>-</span>
                                    </button>
                                    <input type="number" 
                                           name="tickets[{{ $price->id }}][quantity]" 
                                           id="tickets_{{ $price->id }}_quantity"
                                           class="quantity-input"
                                           value="0"
                                           min="0"
                                           max="10"
                                           data-price="{{ $price->price }}"
                                           data-type="{{ $price->type }}"
                                           readonly>
                                    <button type="button" 
                                            class="quantity-btn quantity-plus" 
                                            data-target="tickets_{{ $price->id }}_quantity"
                                            data-price="{{ $price->price }}"
                                            data-type="{{ $price->type }}">
                                        <span>+</span>
                                    </button>
                                </div>
                                <input type="hidden" name="tickets[{{ $price->id }}][price_id]" value="{{ $price->id }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Message d'aide -->
                <div class="help-message">
                    <p>🎯 <strong>Conseil :</strong> Vous devez sélectionner au moins <strong>1 ticket au total</strong> pour pouvoir procéder au paiement.</p>
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
                    💳 Payer avec Stripe
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

/* Instructions et messages d'aide */
.ticket-instructions {
    background: #e3f2fd;
    border: 1px solid #2196f3;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    color: #1565c0;
}

.help-message {
    background: #fff3e0;
    border: 1px solid #ff9800;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
    color: #e65100;
}

/* Résumé de commande amélioré */
.summary-header {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    border-bottom: 2px solid #007cba;
}

.summary-header h4 {
    margin: 0 0 0.5rem 0;
    color: #333;
}

.summary-header p {
    margin: 0;
    color: #666;
}

.no-tickets {
    color: #dc3545;
    font-style: italic;
    text-align: center;
    padding: 1rem;
}

/* Sélection de date améliorée */
.date-option.selected .date-label {
    background: #007cba;
    color: white;
    transform: scale(1.02);
}

.date-option.selected .date-info strong,
.date-option.selected .date-info span,
.date-option.selected .date-info small {
    color: white;
}

/* Bouton amélioré */
.btn-primary:not(:disabled) {
    background: linear-gradient(135deg, #007cba, #005a87);
    box-shadow: 0 4px 8px rgba(0, 124, 186, 0.3);
}

.btn-primary:not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 124, 186, 0.4);
}

/* Compteur de quantités */
.quantity-counter {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.quantity-btn {
    width: 40px;
    height: 40px;
    border: 2px solid #007cba;
    background: white;
    color: #007cba;
    border-radius: 50%;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn:hover {
    background: #007cba;
    color: white;
    transform: scale(1.1);
}

.quantity-btn:active {
    transform: scale(0.95);
}

.quantity-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #ccc;
    border-color: #ccc;
    color: #666;
}

.quantity-input {
    width: 60px;
    height: 40px;
    text-align: center;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    background: #f8f9fa;
    color: #333;
}

.quantity-input:focus {
    outline: none;
    border-color: #007cba;
    box-shadow: 0 0 0 3px rgba(0, 124, 186, 0.1);
}

/* Animation pour les changements de quantité */
.quantity-input {
    transition: all 0.3s ease;
}

.quantity-input.changed {
    background: #e3f2fd;
    border-color: #2196f3;
    transform: scale(1.05);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const orderSummary = document.getElementById('order-summary');
    const totalAmount = document.getElementById('total-amount');
    const bookButton = document.getElementById('book-button');
    const form = document.getElementById('bookingForm');
    
    function updateOrderSummary() {
        let total = 0;
        let hasTickets = false;
        let summaryHTML = '';
        let totalTickets = 0;
        
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value);
            if (quantity > 0) {
                hasTickets = true;
                totalTickets += quantity;
                const price = parseFloat(input.dataset.price);
                const type = input.dataset.type;
                const subtotal = price * quantity;
                total += subtotal;
                
                summaryHTML += `
                    <div class="ticket-item">
                        <span><strong>${type}</strong> x${quantity}</span>
                        <span><strong>€${subtotal.toFixed(2)}</strong></span>
                    </div>
                `;
            }
        });
        
        if (hasTickets) {
            orderSummary.innerHTML = `
                <div class="summary-header">
                    <h4>🎫 Résumé de votre sélection</h4>
                    <p>Total des tickets : <strong>${totalTickets}</strong></p>
                </div>
                ${summaryHTML}
            `;
            totalAmount.textContent = `€${total.toFixed(2)}`;
            bookButton.disabled = false;
            bookButton.textContent = `💳 Payer €${total.toFixed(2)} avec Stripe`;
        } else {
            orderSummary.innerHTML = '<p class="no-tickets">❌ Aucun ticket sélectionné</p>';
            totalAmount.textContent = '€0.00';
            bookButton.disabled = true;
            bookButton.textContent = '💳 Payer avec Stripe';
        }
    }
    
    // Gestion des boutons + et -
    function setupQuantityButtons() {
        const minusButtons = document.querySelectorAll('.quantity-minus');
        const plusButtons = document.querySelectorAll('.quantity-plus');
        
        minusButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.dataset.target;
                const input = document.getElementById(targetId);
                const currentValue = parseInt(input.value);
                
                if (currentValue > 0) {
                    input.value = currentValue - 1;
                    updateButtonStates(input);
                    updateOrderSummary();
                    animateQuantityChange(input);
                }
            });
        });
        
        plusButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.dataset.target;
                const input = document.getElementById(targetId);
                const currentValue = parseInt(input.value);
                
                if (currentValue < 10) {
                    input.value = currentValue + 1;
                    updateButtonStates(input);
                    updateOrderSummary();
                    animateQuantityChange(input);
                }
            });
        });
    }
    
    // Mettre à jour l'état des boutons
    function updateButtonStates(input) {
        const value = parseInt(input.value);
        const minusBtn = input.parentElement.querySelector('.quantity-minus');
        const plusBtn = input.parentElement.querySelector('.quantity-plus');
        
        minusBtn.disabled = value <= 0;
        plusBtn.disabled = value >= 10;
    }
    
    // Animation lors du changement de quantité
    function animateQuantityChange(input) {
        input.classList.add('changed');
        setTimeout(() => {
            input.classList.remove('changed');
        }, 300);
    }
    
    // Validation du formulaire
    function validateForm() {
        let totalTickets = 0;
        let hasRepresentation = false;
        
        // Vérifier qu'une date est sélectionnée
        const selectedDate = document.querySelector('input[name="representation_id"]:checked');
        if (selectedDate) {
            hasRepresentation = true;
        }
        
        // Compter le total des tickets
        quantityInputs.forEach(input => {
            totalTickets += parseInt(input.value);
        });
        
        if (!hasRepresentation) {
            alert('⚠️ Veuillez sélectionner une date pour le spectacle.');
            return false;
        }
        
        if (totalTickets === 0) {
            alert('⚠️ Veuillez sélectionner au moins 1 ticket.');
            return false;
        }
        
        return true;
    }
    
    // Validation avant soumission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
    
    // Initialiser les boutons de quantité
    setupQuantityButtons();
    
    // Initialiser l'état des boutons
    quantityInputs.forEach(input => {
        updateButtonStates(input);
    });
    
    // Initialiser le résumé
    updateOrderSummary();
    
    // Améliorer l'expérience utilisateur
    const dateRadios = document.querySelectorAll('.date-radio');
    dateRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Mettre à jour le style de la date sélectionnée
            dateRadios.forEach(r => {
                r.closest('.date-option').classList.remove('selected');
            });
            this.closest('.date-option').classList.add('selected');
        });
    });
});
</script>
@endsection
