@extends('layouts.app')
@section('title', 'Catalogue des spectacles')

@section('content')

<style>
    .search-button {
        margin-top: 10px;
        background-color: rgb(181, 208, 238);
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        outline: none;
        box-shadow: none;
    }

    .search-button:hover {
        background-color: rgb(28, 79, 136);
        color: white !important;
        outline: none;
        box-shadow: none;
    }
</style>


<div class="inner">
    <header>
        <h1>Catalogue des spectacles</h1>
        <p>Découvrez notre catalogue 2024-2025.</p>
    </header>
    
<!-- Formulaire de recherche -->
<form method="GET" action="{{ route('show.index') }}" style="margin-bottom: 20px;">
    <input type="text" name="search"
           placeholder="Rechercher un spectacle..."
           value="{{ request('search') }}"
           style="padding-top: 8px; width: 600px; border-radius: 5px;">
    
    <button type="submit" class="search-button">
        Rechercher
    </button>
</form>


    <section class="tiles">
    @foreach($shows as $show)
        <article class="style{{ $loop->iteration % 6 + 1}}">
            <span class="image">
                <img src="{{ asset('images/' . $show->poster_url) }}" alt="{{ $show->title }}" />
            </span>
            <a href="{{ route('show.show',[$show->id]) }}">
                <h2>{{ strtoupper($show->title) }}</h2>
                <div class="content">
                    <p>{{ Str::limit($show->description, 120, '...') }}</p>
                </div>
            </a>
        </article>
    @endforeach
    </section>
</div>
@endsection