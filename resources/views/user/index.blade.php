@extends('layouts.app')

@section('title', 'Liste des utilisateurs')

@section('content')
    <h1>Liste des {{ $resource }}</h1>

    <table>
        <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->firstname }}</td>
                <td>
                    <a href="{{ route('user.show', $user->id) }}">{{ $user->lastname }}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
