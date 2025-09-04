@extends('layouts.app')

@section('title', 'Paiement confirmé - ' . $ticket->representation->show->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête de succès -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Paiement confirmé</h1>
        <p class="text-lg text-gray-600">Votre commande a été traitée avec succès</p>
    </div>

    <!-- Carte principale -->
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <!-- En-tête de la carte -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Détails de votre commande</h2>
                <p class="text-gray-600 text-sm">Référence: #{{ $ticket->id }}</p>
            </div>

            <!-- Contenu de la carte -->
            <div class="p-6">
                <!-- Informations du spectacle -->
                <div class="grid md:grid-cols-2 gap-8 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Spectacle</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-gray-600 text-sm">Titre</span>
                                <p class="font-medium text-gray-900">{{ $ticket->representation->show->title }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Date et heure</span>
                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($ticket->representation->schedule)->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Lieu</span>
                                <p class="font-medium text-gray-900">{{ $ticket->representation->location->designation }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Détails de l'achat</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-gray-600 text-sm">Tarif</span>
                                <p class="font-medium text-gray-900">{{ $ticket->price->type }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Quantité</span>
                                <p class="font-medium text-gray-900">{{ $ticket->quantity }} ticket(s)</p>
                            </div>
                            <div>
                                <span class="text-gray-600 text-sm">Prix unitaire</span>
                                <p class="font-medium text-gray-900">{{ number_format($ticket->price->price, 2) }} €</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Résumé du paiement -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-medium">Total payé</span>
                        <span class="text-2xl font-bold text-gray-900">{{ number_format($ticket->total_price, 2) }} €</span>
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        Paiement effectué via Stripe
                        @if(isset($session) && $session->payment_intent)
                            <br>Référence: {{ $session->payment_intent }}
                        @endif
                    </div>
                </div>

                <!-- Informations importantes -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-blue-900 mb-2">Informations importantes</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Conservez cette confirmation pour votre dossier</li>
                        <li>• Présentez votre billet à l'entrée du spectacle</li>
                        <li>• Arrivez 15 minutes avant le début du spectacle</li>
                        <li>• En cas de problème, contactez-nous au 01 23 45 67 89</li>
                    </ul>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('tickets.show', $ticket->id) }}" 
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded text-center transition duration-200">
                        Voir le détail du ticket
                    </a>
                    <a href="{{ route('tickets.index') }}" 
                       class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded text-center transition duration-200">
                        Mes tickets
                    </a>
                    <a href="{{ route('show.show', $ticket->representation->show->id) }}" 
                       class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded text-center transition duration-200">
                        Retour au spectacle
                    </a>
                </div>
            </div>
        </div>

        <!-- Message de remerciement -->
        <div class="text-center mt-8">
            <p class="text-gray-600">Merci de votre confiance ! Nous espérons que vous apprécierez le spectacle.</p>
            <p class="text-sm text-gray-500 mt-2">Un email de confirmation vous a été envoyé.</p>
        </div>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
}

@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .grid {
        grid-template-columns: 1fr;
    }
    
    .flex-col {
        flex-direction: column;
    }
}
</style>
@endsection
