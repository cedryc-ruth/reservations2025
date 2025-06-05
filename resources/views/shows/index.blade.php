@extends('layouts.app')
    <form method="GET" action="{{ route('shows.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="tag" class="form-control" placeholder="Rechercher par mot-clé"
                value="{{ request('tag') }}">
            <button class="btn btn-outline-primary" type="submit">Rechercher</button>
        </div>
    </form>
@section('title', 'Liste des spectacles')

    @if($tagQuery)
        <p><strong>{{ $shows->count() }}</strong> spectacle(s) trouvé(s) pour le mot-clé : <em>{{ $tagQuery }}</em></p>
    @endif

@section('content')

    @if(count($shows)>0)
        <ul>
        @foreach($shows as $show)
            <li><a href="{{ route('shows.show',[$show->id]) }}">{{ $show->title }}</a></li>
        @endforeach
        </ul>
    @else
        <p>Aucun spectacle.</p>
    @endif

<p><a href="{{ route('shows.create') }}">Ajouter</a></p>

@endsection

@section('sidebar')
    @parent

    <p>Sidebar personnalisée pour les spectacles</p>
@endsection