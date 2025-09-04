@extends('layouts.app')

@section('title', 'Fiche artiste')

@section('content')

<div class="container">
    <h1>{{ $artist->firstname }} {{ $artist->lastname }}</h1>

    <!-- Types d'artiste -->
    @if($artist->types->count() != 0)
    <div class="mb-4">
        <h3>Types d'artiste :</h3>
        <ul>
            @foreach($artist->types as $type)
                <li>{{ $type->type }}</li>
            @endforeach
        </ul>
    </div>
    @else
    <p>Aucun type pour cet artiste.</p>
    @endif

    <!-- Spectacles -->
    <div class="mb-4">
        <h3>Spectacles :</h3>
        @if($shows->count() > 0)
            <div class="row">
                @foreach($shows as $show)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('show.show', $show->id) }}" class="text-decoration-none">
                                        {{ $show->title }}
                                    </a>
                                </h5>
                                @if($show->description)
                                    <p class="card-text">{{ Str::limit($show->description, 100) }}</p>
                                @endif
                                <a href="{{ route('show.show', $show->id) }}" class="btn btn-primary btn-sm">
                                    Voir le spectacle
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Aucun spectacle associé à cet artiste.</p>
        @endif
    </div>


    <div class="mt-4">
        <a href="{{ route('artist.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>

@endsection