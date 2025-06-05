@extends('layouts.app')

@section('title', "Spectacles sans le mot-clé : $tag")

@section('content')

    <h1>Spectacles sans le mot-clé « {{ $tag }} »</h1>

    @if(count($shows) > 0)
        <ul>
            @foreach($shows as $show)
                <li>
                    <a href="{{ route('shows.show', $show->id) }}">{{ $show->title }}</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun spectacle ne correspond à ce critère.</p>
    @endif

@endsection