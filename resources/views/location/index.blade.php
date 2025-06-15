@extends('layouts.app')

@section('content')
    <h1>Liste des lieux</h1>
    <ul>
        @foreach($locations as $location)
            <li>
                <a href="{{ route('location.show', $location->id) }}">{{ $location->designation }}</a>
            </li>
        @endforeach
    </ul>
@endsection
