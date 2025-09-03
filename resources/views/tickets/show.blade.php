@extends('layouts.app')

@section('title', 'Détails du ticket')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Détails de votre ticket</h1>
            <p class="text-gray-600">Informations complètes sur votre réservation</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Statut du ticket -->
        <div class="mb-6">
            @if($ticket->status === 'paid')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Ticket confirmé et payé</span>
                    </div>
                </div>
            @elseif($ticket->status === 'pending')
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">En attente de paiement</span>
                    </div>
                </div>
            @elseif($ticket->status === 'cancelled')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="font-medium">Ticket annulé</span>
                    </div>
                </div>
            @elseif($ticket->status === 'used')
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-medium">Ticket utilisé</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Informations du spectacle -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations du spectacle</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start space-x-4">
                    @if($ticket->representation->show->poster_url)
                        <img src="{{ asset('images/' . $ticket->representation->show->poster_url) }}" 
                             alt="{{ $ticket->representation->show->title }}" 
                             class="w-24 h-36 object-cover rounded-lg">
                    @else
                        <div class="w-24 h-36 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 text-xs">Aucune image</span>
                        </div>
                    @endif>
                    
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $ticket->representation->show->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $ticket->representation->show->description }}</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Date et heure :</span>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($ticket->representation->schedule)->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div>
                        <span class="font-medium text-gray-700">Lieu :</span>
                        <p class="text-gray-900">{{ $ticket->representation->location->designation ?? 'Non spécifié' }}</p>
                    </div>
                    
                    <div>
                        <span class="font-medium text-gray-700">Durée :</span>
                        <p class="text-gray-900">{{ $ticket->representation->show->duration }} minutes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails de la commande -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Détails de la commande</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Numéro de commande :</span>
                    <span class="font-mono text-gray-900">#{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Date d'achat :</span>
                    <span class="text-gray-900">{{ $ticket->purchased_at ? $ticket->purchased_at->format('d/m/Y à H:i') : 'Non spécifiée' }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Tarif :</span>
                    <span class="text-gray-900">{{ $ticket->price->type }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Prix unitaire :</span>
                    <span class="text-gray-900">{{ number_format($ticket->price->price, 2) }}€</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Quantité :</span>
                    <span class="text-gray-900">{{ $ticket->quantity }}</span>
                </div>
                
                <hr>
                
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900">Total payé :</span>
                    <span class="text-2xl font-bold text-green-600">{{ number_format($ticket->total_price, 2) }}€</span>
                </div>
            </div>
        </div>

        <!-- Informations de paiement -->
        @if($ticket->status === 'paid')
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations de paiement</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Méthode de paiement :</span>
                    <span class="text-gray-900 capitalize">{{ $ticket->payment_method }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Référence de paiement :</span>
                    <span class="font-mono text-gray-900">{{ $ticket->payment_reference }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="flex justify-between items-center">
            <a href="{{ route('tickets.index') }}" 
               class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Retour à mes tickets
            </a>
            
            @if($ticket->status === 'pending')
                <a href="{{ route('tickets.payment', $ticket->id) }}" 
                   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Procéder au paiement
                </a>
            @endif
            
            @if($ticket->status === 'pending' || $ticket->status === 'paid')
                <form action="{{ route('tickets.cancel', $ticket->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Êtes-vous sûr de vouloir annuler ce ticket ?')"
                            class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Annuler le ticket
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
