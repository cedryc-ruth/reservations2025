@extends('layouts.app')

@section('title', 'Fiche d\'un utilisateur')

@section('content')
    <h1>{{ $user->firstname }} {{ $user->lastname }}</h1>
    <nav><a href="{{ route('user.index') }}">Retour à l'index</a></nav>
@endsection
