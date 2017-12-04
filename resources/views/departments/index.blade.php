@extends('layouts.app')

@section('content')
    <h1>Cities</h1>

    <table>
        <thead>
        <th>Nom</th>
        <th>Code</th>
        <th>Actions</th>
        </thead>

        <tbody>
        @foreach($departments as $department)
            <tr>
                <td>{{ $department->name }}</td>
                <td>{{ $department->code }}</td>
                <td><a href="{{ route('departments.show', $department) }}">Voir les villes</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop