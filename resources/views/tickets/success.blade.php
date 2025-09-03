@extends('layouts.app')

@section('title', 'Paiement confirmé')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Message de succès -->
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Paiement confirmé !</h1>
            <p class="text-xl text-green-600 font-medium">Vos tickets ont été achetés avec succès</p>
        </div>

        <!-- Détails de la transaction -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Détails de votre commande</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Numéro de commande :</span>
                    <span class="font-mono text-gray-900">#{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Référence de paiement :</span>
                    <span class="font-mono text-gray-900">{{ $ticket->payment_reference ?? 'N/A' }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Date d'achat :</span>
                    <span class="text-gray-900">{{ $ticket->purchased_at ? $ticket->purchased_at->format('d/m/Y à H:i') : 'Maintenant' }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Méthode de paiement :</span>
                    <span class="text-gray-900 capitalize">{{ $ticket->payment_method ?? 'Stripe' }}</span>
                </div>
            </div>
        </div>

        <!-- Informations du spectacle -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Vos tickets</h2>
            
            <div class="flex items-start space-x-4">
                @if($ticket->representation->show->poster_url)
                    <img src="{{ asset('images/' . $ticket->representation->show->poster_url) }}" 
                         alt="{{ $ticket->representation->show->title }}" 
                         class="w-24 h-36 object-cover rounded-lg">
                @else
                    <div class="w-24 h-36 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 text-xs">Aucune image</span>
                    </div>
                @endif
                
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 text-lg">{{ $ticket->representation->show->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $ticket->representation->show->description }}</p>
                    
                    <div class="grid grid-cols-2 gap-4 mt-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Date et heure :</span>
                            <p class="text-gray-900">{{ \Carbon\Carbon::parse($ticket->representation->schedule)->format('d/m/Y à H:i') }}</p>
                        </div>
                        
                        <div>
                            <span class="font-medium text-gray-700">Lieu :</span>
                            <p class="text-gray-900">{{ $ticket->representation->location->designation ?? 'Non spécifié' }}</p>
                        </div>
                        
                        <div>
                            <span class="font-medium text-gray-700">Tarif :</span>
                            <p class="text-gray-900">{{ $ticket->price->type }}</p>
                        </div>
                        
                        <div>
                            <span class="font-medium text-gray-700">Quantité :</span>
                            <p class="text-gray-900">{{ $ticket->quantity }} ticket(s)</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-gray-900">Total payé :</span>
                <span class="text-2xl font-bold text-green-600">{{ number_format($ticket->total_price, 2) }}€</span>
            </div>
        </div>

        <!-- Informations importantes -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">Informations importantes</h3>
            <ul class="space-y-2 text-blue-800">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Vos tickets vous seront envoyés par email dans les prochaines minutes</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Présentez vos tickets à l'entrée du spectacle</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Vous pouvez annuler vos tickets jusqu'à 24h avant le spectacle</span>
                </li>
            </ul>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center">
            <a href="{{ route('tickets.show', $ticket->id) }}" 
               class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Voir mes tickets
            </a>
            
            <a href="{{ route('show.index') }}" 
               class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Découvrir d'autres spectacles
            </a>
        </div>

        <!-- Remerciements -->
        <div class="text-center mt-8 text-gray-600">
            <p>Merci de votre confiance !</p>
            <p class="mt-1">Nous vous souhaitons un excellent spectacle.</p>
        </div>
    </div>
</div>
@endsection
