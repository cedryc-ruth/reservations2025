@extends('layouts/app')

@section('title','Modification d\'un artiste')

@section('content')
<h2>Modification d'un artiste</h2>

<form action="{{ route('artist.update',[$artist->id]) }}" method="post">
    @csrf
    @method('PUT')
    <div>
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" id="firstname" required 
    @if(old('firstname'))
        value="{{ old('firstname') }}"
    @else
        value="{{ $artist->firstname }}"
    @endif >
    @error('firstname')
        <div>{{ $message }}</div>
    @enderror
    </div>

    <div>
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" id="lastname" required
    @if(old('lastname'))
        value="{{ old('lastname') }}"
    @else
        value="{{ $artist->lastname }}"
    @endif >
    @error('lastname')
        <div>{{ $message }}</div>
    @enderror
    </div>
    <button>Modifier</button>
    <p><a href="{{ route('artist.show',[$artist->id]) }}">Annuler</a></p>
</form>
@endsection()