@extends('layouts.app')

@section('title', '{{ $show->title }}')

@section('content')
<h1>{{ $show->title }}</h1>
<span class="image main"><img src="{{ asset('images/' . $show->poster_url) }}" alt="{{ $show->title }}" width="200" /></span>
<p>{{ $show->description }}</p>

<p><a href="{{ route('show.index') }}">Retour au catalogue</a></p>
@endsection