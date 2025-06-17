@extends('layouts.app')

@section('title', 'Nos salles')

@section('content')

@if(count($locations)>0)
    <h1>Liste des salles</h1>
    <ul>
    @foreach($locations as $location)
        <li>
            <a href="{{ route('location.show', $location->id) }}">{{ $location->designation }}</a>
        </li>
    @endforeach
    </ul>
@else
    <p>Aucune salle.</p>
@endif
<p><a href="{{ route('show.index') }}">← Retour au catalogue</a></p>
@endsection