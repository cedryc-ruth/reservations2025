@extends('layouts.app')
@section('title', 'Catalogue des spectacles')

@section('content')

<style>
    .search-button {
        margin-top: 10px;
        background-color: rgb(181, 208, 238);
        color: white;
        border: none;
        border-radius: 15px;
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
<form method="GET" action="{{ route('show.index') }}" style="margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">

    <!-- Recherche par titre -->
    <input type="text" name="search"
           placeholder="Rechercher un spectacle..."
           value="{{ request('search') }}"
           style="padding: 8px; width: 600px; border-radius: 5px;">

    <!-- Filtre lieu-->
    <select name="location" style="padding: 8px; border-radius: 5px; width: 200px;">
        <option value="">Tous les lieux</option>
        @foreach ($locations as $location)
            <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                {{ $location->designation }}
            </option>
        @endforeach
    </select>

    <!-- Filtre date -->
    <input type="date" name="date"
           value="{{ request('date') }}"
           style="padding: 8px; border-radius: 5px;">

    <!-- Filtre durée maximum -->
    <input type="number" name="duration"
           placeholder="Durée maximum)"
           value="{{ request('duration') }}"
           style="padding: 8px; width: 150px; border-radius: 5px;">

    <!-- bouton rechercher -->
    <button type="submit" class="search-button">
        Rechercher
    </button>
</form>


    <section class="tiles">
    @foreach($shows as $show)
        <article class="style{{ $loop->iteration % 6 + 1}}">
            <span class="image">
                <img src="{{ asset('images/'.$show->poster_url) }}" alt="{{ $show->title }}" />
            </span>
            <a href="{{ route('show.show',[$show->id]) }}">
                <h2>{{ $show->title }}</h2>
                <div class="content">
                    <p>{{ $show->description }}</p>
                </div>
            </a>
        </article>
    @endforeach
    </section>
</div>
@endsection
