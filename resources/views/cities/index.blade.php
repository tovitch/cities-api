@extends('layouts.app')

@section('content')
    <h1>Cities</h1>

    <table>
        <thead>
        <th>Nom</th>
        <th>CP</th>
        <th>Département</th>
        </thead>

        <tbody>
        @foreach($cities as $city)
            <tr>
                <td>{{ $city->name }}</td>
                <td>{{ $city->cp }}</td>
                <td>{{ $city->department->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop