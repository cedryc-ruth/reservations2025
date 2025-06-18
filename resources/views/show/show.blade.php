@extends('layouts.app')

@section('title', '{{ $show->title }}')

@section('content')
<div class="inner">
    <header>
        <h1>{{ $show->title }}</h1>
    </header>

    <div class="image-container">
        <img src="{{ asset('images/' . $show->poster_url) }}" alt="{{ $show->title }}">
    </div>

    <p>{{ $show->description }}</p>

    <p><a href="{{ route('show.index') }}">← Retour au catalogue</a></p>
</div>
@endsection