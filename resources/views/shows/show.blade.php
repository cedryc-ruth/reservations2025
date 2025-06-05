@extends('layouts/app')

@section('content')
    <div class="container">
        <h1>{{ $show->title }}</h1>

        <p><strong>Description :</strong> {{ $show->description }}</p>

        <h4>Lieu du spectacle :</h4>
        <p>
            {{ $show->location->designation }}<br>
            {{ $show->location->address }}<br>
            {{ $show->location->locality->postal_code }} {{ $show->location->locality->locality }}<br>
            <a href="{{ $show->location->website }}" target="_blank">{{ $show->location->website }}</a><br>
            {{ $show->location->phone }}
        </p>

        <h4>Mots-clés associés :</h4>
        @forelse ($show->tags as $tag)
            <span class="badge bg-secondary">{{ $tag->tag }}</span>
        @empty
            <p>Aucun mot-clé associé à ce spectacle.</p>
        @endforelse

        <!-- @auth
            @if (Auth::user()->role === 'admin')
                <form method="POST" action="{{ route('shows.addTags', $show->id) }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="tags">Ajouter des mots-clés (séparés par des virgules) :</label>
                        <input type="text" name="tags" class="form-control" placeholder="Drame, Comédie, Enfants" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            @endif
        @endauth -->
    </div>

<p><a href="{{ route('shows.index') }}">Retour à la liste</a></p>
@endsection