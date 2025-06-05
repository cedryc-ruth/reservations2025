@extends('layouts/app')

@section('title','Création d\'un spectacle')

@section('content')
<h2>Création d'un spectacle</h2>

<!-- <form action="{{ route('artist.store') }}" method="post" novalidate> -->
<form action="{{ route('shows.store') }}" method="post">
    @csrf
    <div>
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" required maxlength="100"
               value="{{ old('title') }}">
        @error('title')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" required maxlength="100"
               value="{{ old('slug') }}">
        @error('slug')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="poster_url">Affiche (URL)</label>
        <input type="url" name="poster_url" id="poster_url" value="{{ old('poster_url') }}">
        @error('poster_url')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="duration">Durée (en minutes)</label>
        <input type="number" name="duration" id="duration" value="{{ old('duration') }}">
        @error('duration')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="created_in">Année de création</label>
        <input type="number" name="created_in" id="created_in" value="{{ old('created_in') }}">
        @error('created_in')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="location_id">Lieu</label>
        <select name="location_id" id="location_id">
            @foreach ($locations as $location)
                <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>
                    {{ $location->designation }}
                </option>
            @endforeach
        </select>
        @error('location_id')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="bookable">Réservable ?</label>
        <input type="checkbox" name="bookable" id="bookable" value="1"
               {{ old('bookable') ? 'checked' : '' }}>
        @error('bookable')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Ajouter</button>
    <p><a href="{{ route('shows.index') }}">Annuler</a></p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h2>Liste des erreurs de validation</h2>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>
@endsection()