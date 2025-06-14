@extends('layouts.main')

@section('title', 'Catalogue des spectacles')

@section('content')
<div class="inner">
    <header>
        <h1>Catalogue des spectacles</h1>
        <p>Découvrez notre catalogue 2024-2025.</p>
    </header>
    <section class="tiles">
    @foreach($shows as $show)
        <article class="style{{ $loop->iteration % 6 + 1}}">
            <span class="image">
                <img src="{{ asset('images/'.$show->poster_url) }}" alt="{{ $show->title }}" />
            </span>
            <a href="{{ route('show.show',[$show->id]) }}">
                <h2>{{ $show->title }}</h2>
                <div class="content">
                    <p>{{ $show->description }}</p>
                </div>
            </a>
        </article>
    @endforeach
    </section>
</div>
@endsection
