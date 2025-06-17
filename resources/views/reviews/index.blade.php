@extends('layouts.app')

@section('content')
    <h1>Avis pour : {{ $show->title }}</h1>

    @if ($show->reviews->isEmpty())
        <p>Aucun avis disponible pour ce spectacle.</p>
    @else
        <ul>
            @foreach ($show->reviews as $review)
                <li style="margin-bottom: 20px;">
                    <strong>{{ $review->user->name }}</strong> — 
                    <em> {{ $review->created_at ? $review->created_at->format('d/m/Y') : 'Date inconnue' }}</em>
                    <div>
                        Note :
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->stars)
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                    <p>{{ $review->review }}</p>
                </li>
            @endforeach
        </ul>
    @endif
@endsection