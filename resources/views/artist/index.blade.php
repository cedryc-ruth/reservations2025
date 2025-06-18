@extends('layouts.app')

@section('title', 'Nos artistes')

@section('content')

@if(count($artists)>0)
    <h1>Liste des artistes</h1>
    <ul>
    @foreach($artists as $artist)
        <li>
            <a href="{{ route('artist.show',[$artist->id]) }}">{{ $artist->firstname }} {{ $artist->lastname }}</a>
        </li>
    @endforeach
    </ul>
@else
    <p>Aucun artiste.</p>
@endif
<p><a href="{{ route('show.index') }}">← Retour au catalogue</a></p>
@endsection

@section('sidebar')
    @parent

    SIDEBAR FILLE
@endsection