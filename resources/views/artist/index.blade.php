@extends('layouts.app')

@section('title', 'Liste des artistes')

@section('content')

@if(count($artists)>0)
    <ul>
    @foreach($artists as $artist)
        <li>{{ $artist->firstname }} {{ $artist->lastname }}</li>
    @endforeach
    </ul>
@else
    <p>Aucun artiste.</p>
@endif

@endsection

@section('sidebar')
    @parent

    SIDEBAR FILLE
@endsection