@extends('layouts.main')

@section('title', 'Fiche artiste')

@section('content')

<p>{{ $artist->firstname }} {{ $artist->lastname }}</p>

@if($artist->types->count()!=0)
<ul>
@foreach($artist->types as $type)
    <li>{{ $type->type }}</li>
@endforeach
</ul>
@else
<p>Aucun type pour cet artiste.</p>
@endif

<p><a href="{{ route('artist.edit',[$artist->id]) }}">Modifier</a></p>

<form method="post" action="{{ route('artist.delete', $artist->id) }}">
    @csrf
    @method('DELETE')
    <button>Supprimer</button>
</form>

<p><a href="{{ route('artist.index') }}">Retour à la liste</a></p>
@endsection