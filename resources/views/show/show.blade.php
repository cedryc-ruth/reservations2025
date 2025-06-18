
@extends('layouts.app')

@section('title', $show->title)

@section('content')
<div class="inner">
    <header>
        <h1>{{ $show->title }}</h1>
    </header>

    <div class="image-container">
        <img src="{{ asset('images/' . $show->poster_url) }}" alt="{{ $show->title }}">
    </div>

    <p>{{ $show->description }}</p>

    @if($show->reviews->count() > 0)
        <h3>Commentaires des spectateurs</h3>
        <ul>
            @foreach($show->reviews as $review)
                <li style="margin-bottom: 15px;">
                    <strong>{{ $review->user->firstname ?? 'Utilisateur inconnu' }}</strong>
                    ({{ $review->created_at->format('d/m/Y') }}) :
                    <br>
                    
                    <!--Etoiles notes / 5-->
                    @if(isset($review->stars))
                    <div style="color: gold;">
                        @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->stars)
                            ⭐
                        @else
                            ☆
                        @endif
                        @endfor
                        ({{ $review->stars }}/5)
                    </div>
                    @endif
                    <p>{{ $review->review }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun avis pour ce spectacle.</p>
    @endif

                    <!-- Ajouter un commentaire si le user est connecté et qu'il a assisté à une représentation passée-->
    @if($canReview)
        <h4>Ajouter un commentaire</h4>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('reviews.store') }}">
            @csrf
            <input type="hidden" name="show_id" value="{{ $show->id }}">

            <label for="stars">Note (1 à 5) :</label><br>
            <select name="stars" id="stars" required>
                <option value="">Choisir une note</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>

            <br><br>

            <label for="review">Commentaire :</label><br>
            <textarea name="review" id="review" rows="4" cols="50" required></textarea>

            <br><br>
            <button type="submit">Envoyer</button>
        </form>
    @elseif(Auth::check())
        <p style="color: grey;">Vous devez avoir assisté à ce spectacle pour laisser un commentaire.</p>
    @else
        <p><a href="{{ route('login') }}">Connectez-vous</a> pour laisser un commentaire.</p>
    @endif




    <p><a href="{{ route('show.index') }}">← Retour au catalogue</a></p>
</div>
@endsection