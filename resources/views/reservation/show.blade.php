@extends('layouts.app')

@section('content')
    <h1>Détail de la réservation</h1>

    <p><strong>Nom :</strong> {{ $reservation->user->firstname }} {{ $reservation->user->lastname }}</p>
    <p><strong>Date :</strong> {{ $reservation->booking_date }}</p>
    <p><strong>Statut :</strong> {{ $reservation->status }}</p>

    <h3>Représentations réservées</h3>
    <ul class="list-group">
        @foreach($reservation->representationReservations as $item)
            <li class="list-group-item">
                {{ optional($item->representation)->schedule ?? 'Pas de date'}} <br>
                Spectacle : {{ $item->representation->show->title ?? 'Non lié' }}<br>
                Tarif : {{ $item->price->type }} ({{ $item->price->price }} €)<br>
                Quantité : {{ $item->quantity }}
            </li>
        @endforeach
    </ul>
@endsection
