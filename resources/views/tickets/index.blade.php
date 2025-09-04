@extends('layouts.app')

@section('title', 'Mes Tickets')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête de la page -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Mes Tickets</h1>
        <p class="text-lg text-gray-600">Gérez et consultez tous vos billets de spectacle</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $tickets->where('status', 'paid')->count() }}</div>
            <div class="text-sm text-gray-600">Tickets payés</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $tickets->where('status', 'pending')->count() }}</div>
            <div class="text-sm text-gray-600">En attente</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $tickets->where('status', 'used')->count() }}</div>
            <div class="text-sm text-gray-600">Utilisés</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-red-600">{{ $tickets->where('status', 'cancelled')->count() }}</div>
            <div class="text-sm text-gray-600">Annulés</div>
        </div>
    </div>

    @if($tickets->count() > 0)
        <!-- Filtres et recherche -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex-1">
                    <input type="text" 
                           id="searchInput" 
                           placeholder="Rechercher un spectacle..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex gap-2">
                    <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="pending">En attente</option>
                        <option value="paid">Payé</option>
                        <option value="used">Utilisé</option>
                        <option value="cancelled">Annulé</option>
                    </select>
                    <button onclick="clearFilters()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Réinitialiser
                    </button>
                </div>
            </div>
        </div>

        <!-- Liste des tickets -->
        <div class="space-y-4">
            @foreach($tickets as $ticket)
                <div class="ticket-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                     data-show-title="{{ strtolower($ticket->representation->show->title) }}"
                     data-status="{{ $ticket->status }}">
                    
                    <!-- En-tête de la carte -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-semibold text-white">{{ $ticket->representation->show->title }}</h3>
                                <p class="text-blue-100">{{ \Carbon\Carbon::parse($ticket->representation->schedule)->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($ticket->status === 'paid') bg-green-100 text-green-800
                                    @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($ticket->status === 'used') bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @switch($ticket->status)
                                        @case('pending')
                                            ⏳ En attente
                                            @break
                                        @case('paid')
                                            ✅ Payé
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

                    <!-- Contenu de la carte -->
                    <div class="p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Informations du spectacle -->
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-3">Informations du spectacle</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Lieu:</span>
                                        <span class="font-medium">{{ $ticket->representation->location->designation }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Tarif:</span>
                                        <span class="font-medium">{{ $ticket->price->type }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Quantité:</span>
                                        <span class="font-medium">{{ $ticket->quantity }} ticket(s)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations de paiement -->
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-3">Informations de paiement</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Prix unitaire:</span>
                                        <span class="font-medium">{{ number_format($ticket->price->price, 2) }} €</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Total payé:</span>
                                        <span class="font-bold text-lg text-green-600">{{ number_format($ticket->total_price, 2) }} €</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Acheté le:</span>
                                        <span class="font-medium">{{ $ticket->created_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-3 mt-6 pt-4 border-t border-gray-200">
                            <a href="{{ route('tickets.show', $ticket->id) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                📋 Voir le détail
                            </a>
                            
                            @if($ticket->status === 'pending')
                                <a href="{{ route('tickets.payment', $ticket->id) }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                    💳 Payer maintenant
                                </a>
                            @endif
                            
                            @if($ticket->status === 'paid' && \Carbon\Carbon::parse($ticket->representation->schedule)->isFuture())
                                <form action="{{ route('tickets.cancel', $ticket->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir annuler ce ticket ?')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                        ❌ Annuler
                                    </button>
                                </form>
                            @endif
                            
                            @if($ticket->status === 'paid')
                                <a href="{{ route('show.show', $ticket->representation->show->id) }}" 
                                   class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                    🎭 Voir le spectacle
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($tickets->hasPages())
            <div class="mt-8">
                {{ $tickets->links() }}
            </div>
        @endif

    @else
        <!-- Message si aucun ticket -->
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun ticket trouvé</h3>
            <p class="text-gray-600 mb-6">Vous n'avez pas encore acheté de tickets de spectacle.</p>
            <a href="{{ route('show.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                Découvrir des spectacles
            </a>
        </div>
    @endif
</div>

<script>
// Filtrage des tickets
function filterTickets() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const tickets = document.querySelectorAll('.ticket-card');
    
    tickets.forEach(ticket => {
        const showTitle = ticket.dataset.showTitle;
        const status = ticket.dataset.status;
        
        const matchesSearch = showTitle.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;
        
        if (matchesSearch && matchesStatus) {
            ticket.style.display = 'block';
        } else {
            ticket.style.display = 'none';
        }
    });
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    filterTickets();
}

// Événements
document.getElementById('searchInput').addEventListener('input', filterTickets);
document.getElementById('statusFilter').addEventListener('change', filterTickets);

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    filterTickets();
});
</script>

<style>
.container {
    max-width: 1200px;
}

.bg-gradient-to-r {
    background: linear-gradient(to right, #2563eb, #7c3aed);
}

.ticket-card {
    transition: all 0.3s ease;
}

.ticket-card:hover {
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .grid {
        grid-template-columns: 1fr;
    }
    
    .flex-wrap {
        flex-wrap: wrap;
    }
}
</style>
@endsection
