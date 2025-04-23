<p>{{ $artist->firstname }} {{ $artist->lastname }}</p>

<p><a href="{{ route('artist.edit',[$artist->id]) }}">Modifier</a></p>

<p><a href="{{ route('artist.index') }}">Retour à la liste</a></p>
