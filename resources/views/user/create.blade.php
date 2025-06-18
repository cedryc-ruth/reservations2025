@extends('layouts/app')

@section('title','Création d\'un utilisateur')

@section('content')
<h2>Création d'un utilisateur</h2>

<!-- <form action="{{ route('user.store') }}" method="post" novalidate> -->
<form action="{{ route('user.store') }}" method="post">
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

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required maxlength="60"
    @if(old('email'))
        value="{{ old('email') }}"
    @endif >
    @error('email')
        <div>{{ $message }}</div>
    @enderror
    </div>


    <div>
        <label for="password">Mot de passe</label>
        <input type="text" name="password" id="password" required maxlength="60"
    @if(old('password'))
        value="{{ old('password') }}"
    @endif >
    @error('password')
        <div>{{ $message }}</div>
    @enderror
    </div>


       <div>
        <label for="langue">Langue</label>
        <input type="text" name="langue" id="langue" 
    @if(old('langue'))
        value="{{ old('langue') }}"
    @endif >
    @error('langue')
        <div>{{ $message }}</div>
    @enderror
    </div>


    <button>Ajouter</button>
    <p><a href="{{ route('user.index') }}">Annuler</a></p>

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