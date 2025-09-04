
@extends('layouts.app')

@section('title', $show->title)

@section('content')
<div class="inner">
    <header>
        <h1>{{ $show->title }}</h1>
    </header>

    <div class="image-container">
        <img src="{{ asset('images/' . $show->poster_url) }}" alt="{{ $show->title }}">
    </div>

    <p>{{ $show->description }}</p>

    <!-- Section d'achat de tickets -->
    <div class="ticket-purchase-section" style="margin: 20px 0; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
        <h3 style="margin-bottom: 15px; color: #333;">Acheter des tickets</h3>
        
        @if(Auth::check() && $show->representations->count() > 0 && $show->prices->count() > 0)
            <!-- Formulaire d'achat -->
            <form action="{{ route('tickets.purchase') }}" method="POST" id="ticket-form">
                @csrf
                
                <!-- Sélection de la représentation -->
                <div style="margin-bottom: 15px;">
                    <label for="representation_id" style="display: block; margin-bottom: 5px; font-weight: bold; color: #333;">
                        Choisir une date et heure :
                    </label>
                    <select name="representation_id" id="representation_id" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Sélectionner une représentation</option>
                        @foreach($show->representations->sortBy('schedule') as $representation)
                            <option value="{{ $representation->id }}">
                                {{ \Carbon\Carbon::parse($representation->schedule)->format('d/m/Y à H:i') }} 
                                - {{ $representation->location->designation ?? 'Lieu non spécifié' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sélection du tarif -->
                <div style="margin-bottom: 15px;">
                    <label for="price_id" style="display: block; margin-bottom: 5px; font-weight: bold; color: #333;">
                        Choisir un tarif :
                    </label>
                    <select name="price_id" id="price_id" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Sélectionner un tarif</option>
                        @foreach($show->prices as $price)
                            <option value="{{ $price->id }}" data-price="{{ $price->price }}">
                                {{ $price->type }} - {{ number_format($price->price, 2) }}€
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sélection de la quantité -->
                <div style="margin-bottom: 15px;">
                    <label for="quantity" style="display: block; margin-bottom: 5px; font-weight: bold; color: #333;">
                        Nombre de tickets :
                    </label>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button type="button" onclick="decrementQuantity()" 
                                style="width: 35px; height: 35px; border: 1px solid #ddd; background: white; border-radius: 4px; cursor: pointer;">
                            -
                        </button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="10" required
                               style="width: 60px; text-align: center; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <button type="button" onclick="incrementQuantity()" 
                                style="width: 35px; height: 35px; border: 1px solid #ddd; background: white; border-radius: 4px; cursor: pointer;">
                            +
                        </button>
                    </div>
                </div>

                <!-- Résumé du prix -->
                <div style="background-color: white; padding: 15px; border-radius: 6px; margin-bottom: 15px; border: 1px solid #ddd;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="color: #666;">Prix unitaire :</span>
                        <span id="unit-price" style="font-weight: bold;">0,00€</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="color: #666;">Quantité :</span>
                        <span id="display-quantity" style="font-weight: bold;">1</span>
                    </div>
                    <hr style="margin: 10px 0;">
                    <div style="display: flex; justify-content: space-between; font-size: 18px;">
                        <span style="font-weight: bold; color: #333;">Total :</span>
                        <span id="total-price" style="font-weight: bold; color: #007bff; font-size: 20px;">0,00€</span>
                    </div>
                </div>

                <!-- Bouton d'achat -->
                <button type="submit" 
                        style="display: inline-block; background-color: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%;">
                    Acheter des tickets avec Stripe
                </button>
            </form>

            <!-- JavaScript pour le calcul des prix -->
            <script>
                function updatePrices() {
                    const priceSelect = document.getElementById('price_id');
                    const quantityInput = document.getElementById('quantity');
                    const unitPriceSpan = document.getElementById('unit-price');
                    const totalPriceSpan = document.getElementById('total-price');
                    const displayQuantitySpan = document.getElementById('display-quantity');
                    
                    const selectedOption = priceSelect.options[priceSelect.selectedIndex];
                    const unitPrice = selectedOption.dataset.price || 0;
                    const quantity = parseInt(quantityInput.value) || 1;
                    
                    unitPriceSpan.textContent = parseFloat(unitPrice).toFixed(2) + '€';
                    displayQuantitySpan.textContent = quantity;
                    totalPriceSpan.textContent = (parseFloat(unitPrice) * quantity).toFixed(2) + '€';
                }

                function incrementQuantity() {
                    const input = document.getElementById('quantity');
                    const currentValue = parseInt(input.value) || 1;
                    if (currentValue < 10) {
                        input.value = currentValue + 1;
                        updatePrices();
                    }
                }

                function decrementQuantity() {
                    const input = document.getElementById('quantity');
                    const currentValue = parseInt(input.value) || 1;
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                        updatePrices();
                    }
                }

                // Événements
                document.getElementById('price_id').addEventListener('change', updatePrices);
                document.getElementById('quantity').addEventListener('input', updatePrices);

                // Initialisation
                updatePrices();
            </script>
        @elseif(Auth::check())
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px 24px; border-radius: 6px; border: 1px solid #f5c6cb;">
                <strong>Information :</strong> Ce spectacle n'a pas encore de représentations ou de tarifs disponibles pour l'achat de tickets.
            </div>
        @else
            <a href="{{ route('login') }}" 
               style="display: inline-block; background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; text-align: center; width: 100%;">
                Se connecter pour acheter des tickets
            </a>
        @endif
    </div>

    @if($show->reviews->count() > 0)
        <h3>Commentaires des spectateurs</h3>
        <ul>
            @foreach($show->reviews as $review)
                <li style="margin-bottom: 15px;">
                    <strong>{{ $review->user->firstname ?? 'Utilisateur inconnu' }}</strong>
                    ({{ $review->created_at->format('d/m/Y') }}) :
                    <br>
                    
                    <!--Etoiles notes / 5-->
                    @if(isset($review->stars))
                    <div style="color: gold;">
                        @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->stars)
                            ⭐
                        @else
                            ☆
                        @endif
                        @endfor
                        ({{ $review->stars }}/5)
                    </div>
                    @endif
                    <p>{{ $review->review }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun avis pour ce spectacle.</p>
    @endif

                    <!-- Ajouter un commentaire si le user est connecté et qu'il a assisté à une représentation passée-->
    @if($canReview)
        <h4>Ajouter un commentaire</h4>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('reviews.store') }}">
            @csrf
            <input type="hidden" name="show_id" value="{{ $show->id }}">

            <label for="stars">Note (1 à 5) :</label><br>
            <select name="stars" id="stars" required>
                <option value="">Choisir une note</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>

            <br><br>

            <label for="review">Commentaire :</label><br>
            <textarea name="review" id="review" rows="4" cols="50" required></textarea>

            <br><br>
            <button type="submit">Envoyer</button>
        </form>
    @elseif(Auth::check())
        <p style="color: grey;">Vous devez avoir assisté à ce spectacle pour laisser un commentaire.</p>
    @else
        <p><a href="{{ route('login') }}">Connectez-vous</a> pour laisser un commentaire.</p>
    @endif




    <p><a href="{{ route('show.index') }}">← Retour au catalogue</a></p>
</div>
@endsection