@extends('layouts.app')

@section('title', 'Paiement - Tickets')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Finaliser votre commande</h1>
            <p class="text-gray-600">Veuillez procéder au paiement pour confirmer vos tickets</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Résumé de la commande -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Résumé de votre commande</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-medium text-gray-900">{{ $ticket->representation->show->title }}</h3>
                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($ticket->representation->schedule)->format('d/m/Y à H:i') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ $ticket->representation->location->designation ?? 'Lieu non spécifié' }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm text-gray-600">{{ $ticket->price->type }}</span>
                    </div>
                </div>
                
                <hr>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Quantité :</span>
                    <span class="font-medium">{{ $ticket->quantity }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Prix unitaire :</span>
                    <span class="font-medium">{{ number_format($ticket->price->price, 2) }}€</span>
                </div>
                
                <hr>
                
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900">Total à payer :</span>
                    <span class="text-2xl font-bold text-blue-600">{{ number_format($ticket->total_price, 2) }}€</span>
                </div>
            </div>
        </div>

        <!-- Formulaire de paiement -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Méthode de paiement</h2>

            <form action="{{ route('tickets.payment.process', $ticket->id) }}" method="POST">
                @csrf
                
                <div class="space-y-4 mb-6">
                    <div class="flex items-center">
                        <input type="radio" id="card" name="payment_method" value="card" class="mr-3" checked>
                        <label for="card" class="flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Carte bancaire
                        </label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="radio" id="paypal" name="payment_method" value="paypal" class="mr-3">
                        <label for="paypal" class="flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.067 8.478c.492.315.844.825.844 1.478 0 .653-.352 1.163-.844 1.478-.492.315-1.163.478-1.844.478H5.777c-.681 0-1.352-.163-1.844-.478-.492-.315-.844-.825-.844-1.478 0-.653.352-1.163.844-1.478.492-.315 1.163-.478 1.844-.478h12.446c.681 0 1.352.163 1.844.478z"/>
                            </svg>
                            PayPal
                        </label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="radio" id="transfer" name="payment_method" value="transfer" class="mr-3">
                        <label for="transfer" class="flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Virement bancaire
                        </label>
                    </div>
                </div>

                <!-- Informations de sécurité -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium">Paiement sécurisé</p>
                            <p>Vos informations de paiement sont protégées par un chiffrement SSL de niveau bancaire.</p>
                        </div>
                    </div>
                </div>

                <!-- Bouton de paiement -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-green-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Payer {{ number_format($ticket->total_price, 2) }}€
                    </button>
                </div>
            </form>
        </div>

        <!-- Informations supplémentaires -->
        <div class="mt-8 text-center text-sm text-gray-600">
            <p>En cas de problème, contactez notre service client</p>
            <p class="mt-1">Vos tickets vous seront envoyés par email après confirmation du paiement</p>
        </div>
    </div>
</div>
@endsection
