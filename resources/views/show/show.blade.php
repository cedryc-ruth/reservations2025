
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

    <p><a href="{{ route('show.index') }}">← Retour au catalogue</a></p>
</div>
@endsection