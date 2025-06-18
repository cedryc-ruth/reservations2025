@extends('layouts.app')

@section('title', 'Les métiers')

@section('content')

@if(count($types)>0)
    <h1>Liste des métiers</h1>
    <ul>
    @foreach($types as $type)
        <li>
            <a href="{{ route('type.show',[$type->id]) }}">{{ $type->type }}</a>
        </li>
    @endforeach
    </ul>
@else
    <p>Aucun métier.</p>
@endif
<p><a href="{{ route('show.index') }}">← Retour au catalogue</a></p>
@endsection