@extends('layouts.main')

@section('title','Liste des types')

@section('content')

@foreach($types as $type)
<p><a href="{{ route('type.show',[$type->id]) }}">{{ $type->type }}</a></p>
@endforeach

@endsection