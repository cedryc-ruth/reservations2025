@extends('layouts.app')

@section('title', 'Nos artistes')

@section('content')
    <h1>Liste des artistes</h1>

    @if($artists->count())
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Types</th>
                </tr>
            </thead>
            <tbody>
                @foreach($artists as $artist)
                    <tr>
                        <td>{{ $artist->firstname }}</td>
                        <td>{{ $artist->lastname }}</td>
                        <td>
                            @if($artist->types && $artist->types->count())
                                {{ $artist->types->pluck('type')->implode(', ') }}
                            @else
                                <em>Aucun type</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun artiste.</p>
    @endif

    <p><a href="{{ route('show.index') }}">← Retour au catalogue</a></p>
@endsection

@section('sidebar')
    @parent
    SIDEBAR FILLE
@endsection
