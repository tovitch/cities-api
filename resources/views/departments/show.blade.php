@extends('layouts.app')

@section('content')
    <h1>{{ $department->name }}, {{ $department->code }}</h1>

    <h2>Cities ({{ count($department->cities) }})</h2>
    <table>
        <thead>
        <th>Nom</th>
        <th>CP</th>
        <th>Latitude</th>
        <th>Longitude</th>
        </thead>

        <tbody>
        @foreach($department->cities as $city)
            <tr>
                <td>{{ $city->name }}</td>
                <td>{{ $city->cp }}</td>
                <td>{{ $city->lat }}</td>
                <td>{{ $city->lng }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop