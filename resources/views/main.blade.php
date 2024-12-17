@extends('layouts.client')

@section('content')
    <h1>Сделать бронирование в:</h1>
    <ul>
        @foreach ($clubs as $club)
            <li>
            <a href="{{ route('client.bookings.create', $club->id) }}">{{ $club->name }} </a>
            </li>
        @endforeach
    </ul>
@endsection
