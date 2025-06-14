@extends('layouts.app')

@section('title', 'Fiche utilisateur')

@section('content')

<p>{{ $user->firstname }} {{ $user->lastname }}</p>

<p>{{$user->langue}}</p>



<p><a href="{{ route('user.edit',[$user->id]) }}">Modifier</a></p>

<form method="post" action="{{ route('user.delete', $user->id) }}">
    @csrf
    @method('DELETE')
    <button>Supprimer</button>
</form>

<p><a href="{{ route('user.index') }}">Retour à la liste</a></p>
@endsection