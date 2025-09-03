@extends('layouts.app')

@section('title', 'Acheter des tickets - ' . $show->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Acheter des tickets</h1>
            <h2 class="text-xl text-gray-600">{{ $show->title }}</h2>
        </div>

        <!-- Informations du spectacle -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-start space-x-6">
                @if($show->poster_url)
                    <img src="{{ asset('images/' . $show->poster_url) }}" alt="{{ $show->title }}" class="w-32 h-48 object-cover rounded-lg">
                @else
                    <div class="w-32 h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400">Aucune image</span>
                    </div>
                @endif
                
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Informations du spectacle</h3>
                    <p class="text-gray-600 mb-4">{{ $show->description }}</p>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Durée :</span>
                            <span class="text-gray-600">{{ $show->duration }} minutes</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Lieu :</span>
                            <span class="text-gray-600">{{ $show->location->designation ?? 'Non spécifié' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire d'achat -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Sélectionner vos tickets</h3>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('tickets.purchase') }}" method="POST">
                @csrf
                
                <!-- Sélection de la représentation -->
                <div class="mb-6">
                    <label for="representation_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Choisir une date et heure *
                    </label>
                    <select name="representation_id" id="representation_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner une représentation</option>
                        @foreach($representations as $representation)
                            <option value="{{ $representation->id }}">
                                {{ \Carbon\Carbon::parse($representation->schedule)->format('d/m/Y à H:i') }} 
                                - {{ $representation->location->designation ?? 'Lieu non spécifié' }}
                            </option>
                        @endforeach
                    </select>
                    @error('representation_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sélection du tarif -->
                <div class="mb-6">
                    <label for="price_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Choisir un tarif *
                    </label>
                    <select name="price_id" id="price_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner un tarif</option>
                        @foreach($prices as $price)
                            <option value="{{ $price->id }}" data-price="{{ $price->price }}">
                                {{ $price->type }} - {{ number_format($price->price, 2) }}€
                            </option>
                        @endforeach
                    </select>
                    @error('price_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantité -->
                <div class="mb-6">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de tickets *
                    </label>
                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="decrementQuantity()" 
                                class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                            -
                        </button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="10" required
                               class="w-20 text-center border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="button" onclick="incrementQuantity()" 
                                class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                            +
                        </button>
                    </div>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Résumé du prix -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Prix unitaire :</span>
                        <span id="unit-price" class="font-medium">0,00€</span>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-gray-700">Quantité :</span>
                        <span id="display-quantity" class="font-medium">1</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Total :</span>
                        <span id="total-price" class="text-lg font-bold text-blue-600">0,00€</span>
                    </div>
                </div>

                <!-- Bouton d'achat -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Ajouter au panier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
@endsection
