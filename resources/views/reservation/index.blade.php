@extends('layouts.app')

@section('content')
    <h1>Liste des réservations</h1>

    @if($reservations->isEmpty())
    <p>Aucune réservation enregistrée.</p>
    @else
    <ul class="list-group">
        @foreach($reservations as $reservation)
            <li class="list-group-item">
                <a href="{{ route('reservation.show', $reservation->id) }}">
                    Réservation #{{ $reservation->id }} de {{ $reservation->user->firstname }} {{ $reservation->user->lastname }}
                </a>
            </li>
        @endforeach
    </ul>
    @endif
@endsection
