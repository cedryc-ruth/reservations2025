@extends('layouts.app')

@section('title', 'Mes tickets')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mes tickets</h1>
            <p class="text-gray-600">Gérez tous vos tickets et réservations</p>
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

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total tickets</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $tickets->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Payés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $tickets->where('status', 'paid')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">En attente</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $tickets->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Annulés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $tickets->where('status', 'cancelled')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des tickets -->
        @if($tickets->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Historique des tickets</h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($tickets as $ticket)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    @if($ticket->representation->show->poster_url)
                                        <img src="{{ asset('images/' . $ticket->representation->show->poster_url) }}" 
                                             alt="{{ $ticket->representation->show->title }}" 
                                             class="w-16 h-24 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">Aucune image</span>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $ticket->representation->show->title }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($ticket->representation->schedule)->format('d/m/Y à H:i') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $ticket->representation->location->designation ?? 'Lieu non spécifié' }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2 text-sm">
                                            <span class="text-gray-600">{{ $ticket->price->type }}</span>
                                            <span class="text-gray-600">{{ $ticket->quantity }} ticket(s)</span>
                                            <span class="font-medium text-gray-900">{{ number_format($ticket->total_price, 2) }}€</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <!-- Statut -->
                                    <div class="text-right">
                                        @if($ticket->status === 'paid')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Payé
                                            </span>
                                        @elseif($ticket->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                        @elseif($ticket->status === 'cancelled')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Annulé
                                            </span>
                                        @elseif($ticket->status === 'used')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Utilisé
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('tickets.show', $ticket->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Voir détails
                                        </a>
                                        
                                        @if($ticket->status === 'pending')
                                            <a href="{{ route('tickets.payment', $ticket->id) }}" 
                                               class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                Payer
                                            </a>
                                        @endif
                                        
                                        @if($ticket->status === 'pending' || $ticket->status === 'paid')
                                            <form action="{{ route('tickets.cancel', $ticket->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler ce ticket ?')"
                                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Annuler
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($tickets->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun ticket</h3>
                <p class="mt-1 text-sm text-gray-500">Vous n'avez pas encore acheté de tickets.</p>
                <div class="mt-6">
                    <a href="{{ route('show.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Découvrir les spectacles
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
