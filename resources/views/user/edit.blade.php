@extends('layouts/app')

@section('title','Modification d\'un utilisateur')

@section('content')
<h2>Modification d'un utilisateur</h2>

<form action="{{ route('user.update',[$user->id]) }}" method="post">
    @csrf
    @method('PUT')
    <div>
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname" required 
    @if(old('firstname'))
        value="{{ old('firstname') }}"
    @else
        value="{{ $user->firstname }}"
    @endif >
    @error('firstname')
        <div>{{ $message }}</div>
    @enderror
    </div>

    <div>
        <label for="lastname">Nom de famille</label>
        <input type="text" name="lastname" id="lastname" required
    @if(old('lastname'))
        value="{{ old('lastname') }}"
    @else
        value="{{ $user->lastname }}"
    @endif >
    @error('lastname')
        <div>{{ $message }}</div>
    @enderror
    </div>
    <button>Modifier</button>
    <p><a href="{{ route('user.show',[$user->id]) }}">Annuler</a></p>

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
<nav><a href="{{ route('artist.index') }}">Retour à l'index</a></nav>
@endsection()