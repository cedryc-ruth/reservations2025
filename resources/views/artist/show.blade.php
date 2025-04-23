<p>{{ $artist->firstname }} {{ $artist->lastname }}</p>

<p><a href="{{ route('artist.edit',[$artist->id]) }}">Modifier</a></p>

<form method="post" action="{{ route('artist.delete', $artist->id) }}">
    @csrf
    @method('DELETE')
    <button>Supprimer</button>
</form>

<p><a href="{{ route('artist.index') }}">Retour à la liste</a></p>
