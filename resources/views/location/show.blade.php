@extends('layouts.app')

@section('content')
    <h1>{{ $location->designation }}</h1>
    <p><strong>Adresse :</strong> {{ $location->address }}</p>
    <p><strong>Site web :</strong> <a href="{{ $location->website }}">{{ $location->website }}</a></p>

    <h3>Spectacles dans ce lieu</h3>
    <ul>
        @foreach($location->shows as $show)
            <li>{{ $show->title }}</li>
        @endforeach
    </ul>

    <h3>Représentations</h3>
    <ul>
        @foreach($location->representations as $representation)
            <li>{{ $representation->schedule }}</li>
        @endforeach
    </ul>
@endsection
