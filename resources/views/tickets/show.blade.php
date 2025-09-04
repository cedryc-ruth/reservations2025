@extends('layouts.app')

@section('title', 'Ticket - ' . $ticket->representation->show->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête de la page -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Détail du Ticket</h1>
        <p class="text-lg text-gray-600">Informations complètes de votre billet</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Carte principale du ticket -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <!-- En-tête avec statut -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ $ticket->representation->show->title }}</h2>
                        <p class="text-blue-100">Référence: #{{ $ticket->id }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold 
                            @if($ticket->status === 'paid') bg-green-100 text-green-800
                            @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($ticket->status === 'used') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @switch($ticket->status)
                                @case('pending')
                                    ⏳ En attente de paiement
                                    @break
                                @case('paid')
                                    ✅ Payé et confirmé
                                    @break
                                @case('used')
                                    🎭 Utilisé
                                    @break
                                @case('cancelled')
                                    ❌ Annulé
                                    @break
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="p-6">
                <!-- Informations du spectacle -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Informations du spectacle</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Titre:</span>
                                <span class="font-semibold">{{ $ticket->representation->show->title }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Date et heure:</span>
                                <span class="font-semibold">{{ \Carbon\Carbon::parse($ticket->representation->schedule)->format('d/m/Y à H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Lieu:</span>
                                <span class="font-semibold">{{ $ticket->representation->location->designation }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Détails de l'achat</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Tarif:</span>
                                <span class="font-semibold">{{ $ticket->price->type }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Quantité:</span>
                                <span class="font-semibold">{{ $ticket->quantity }} ticket(s)</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Total payé:</span>
                                <span class="text-2xl font-bold text-green-600">{{ number_format($ticket->total_price, 2) }} €</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap gap-4 pt-6 border-t border-gray-200">
                    @if($ticket->status === 'pending')
                        <a href="{{ route('tickets.payment', $ticket->id) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                            💳 Payer maintenant
                        </a>
                    @endif

                    @if($ticket->status === 'paid' && \Carbon\Carbon::parse($ticket->representation->schedule)->isFuture())
                        <form action="{{ route('tickets.cancel', $ticket->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir annuler ce ticket ?')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                                ❌ Annuler le ticket
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('tickets.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                        📋 Retour à mes tickets
                    </a>

                    <a href="{{ route('show.show', $ticket->representation->show->id) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                        🎭 Voir le spectacle
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
}

.bg-gradient-to-r {
    background: linear-gradient(to right, #2563eb, #7c3aed);
}

@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
