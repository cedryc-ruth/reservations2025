@extends('layouts/main.blade.php')

@section('title','Création d\'un artiste')

@section('content')
<h2>Création d'un artiste</h2>

<!-- <form action="{{ route('artist.store') }}" method="post" novalidate> -->
<form action="{{ route('artist.store') }}" method="post">
    @csrf
    <div>
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" id="firstname" required maxlength="60"
    @if(old('firstname'))
        value="{{ old('firstname') }}"
    @endif >
    @error('firstname')
        <div>{{ $message }}</div>
    @enderror
    </div>

    <div>
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" id="lastname" required maxlength="60"
    @if(old('lastname'))
        value="{{ old('lastname') }}"
    @endif >
    @error('lastname')
        <div>{{ $message }}</div>
    @enderror
    </div>
    <button>Ajouter</button>
    <p><a href="{{ route('artist.index') }}">Annuler</a></p>

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
@endsection()