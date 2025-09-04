
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

    <!-- Bouton de réservation -->
    @if($show->bookable)
        <div class="booking-section" style="margin: 2rem 0; padding: 1.5rem; background: #e8f5e8; border-radius: 8px; text-align: center;">
            <h3>🎫 Réserver vos places</h3>
            <p>Choisissez votre date et vos tickets pour ce spectacle</p>
            <a href="{{ route('booking.form', $show->id) }}" class="btn btn-primary" style="display: inline-block; padding: 1rem 2rem; background: #007cba; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 1rem;">
                Réserver maintenant
            </a>
        </div>
    @else
        <div class="booking-section" style="margin: 2rem 0; padding: 1.5rem; background: #fff3cd; border-radius: 8px; text-align: center;">
            <h3>🚫 Réservation non disponible</h3>
            <p>Ce spectacle n'est actuellement pas réservable</p>
        </div>
    @endif

    <!-- Informations sur les artistes -->
    @if($show->artistTypes->count() > 0)
        <h3>Artistes</h3>
        <div class="artists-section">
            @php
                $artistsByType = [];
                foreach($show->artistTypes as $artistType) {
                    $typeName = $artistType->type->type;
                    if (!isset($artistsByType[$typeName])) {
                        $artistsByType[$typeName] = [];
                    }
                    $artistsByType[$typeName][] = $artistType->artist;
                }
            @endphp
            
            @foreach($artistsByType as $typeName => $artists)
                <div class="artist-type-group" style="margin-bottom: 15px;">
                    <h4 style="color: #666; margin-bottom: 5px;">{{ ucfirst($typeName) }}{{ count($artists) > 1 ? 's' : '' }}</h4>
                    <ul style="list-style: none; padding-left: 0;">
                        @foreach($artists as $artist)
                            <li style="margin-bottom: 5px; padding-left: 20px;">
                                <strong>{{ $artist->firstname }} {{ $artist->lastname }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif

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