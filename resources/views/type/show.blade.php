@extends('layouts.main')

@section('title','Fiche d\'un type')

@section('content')
<p>{{ $type->type }}</p>

<a href="{{ route('type.index') }}">Retour à la liste</a>
@endsection