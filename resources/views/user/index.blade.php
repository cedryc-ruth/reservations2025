@extends('layouts.main')

@section('title', 'Liste des utilisateurs')

@section('content')

@if(count($users)>0)
    <ul>
    @foreach($users as $user)
        <li><a href="{{ route('user.show',[$user->id]) }}">{{ $user->firstname }} {{ $user->lastname }}</a></li>
    @endforeach
    </ul>
@else
    <p>Aucun utilisateur.</p>
@endif

<p><a href="{{ route('user.create') }}">Ajouter</a></p>

@endsection

@section('sidebar')
    @parent

    SIDEBAR FILLE
@endsection