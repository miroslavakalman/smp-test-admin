@extends('layouts.app')

@section('content')
<h1>Просмотр бронирования</h1>
<p>ID: {{ $booking->id }}</p>
<p>ФИО: {{ $booking->visitor_name }}</p>
<p>Телефон: {{ $booking->phone }}</p>
<p>Дата: {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y, H:i') }}</p>
<p>Количество: {{ $booking->quantity }}</p>
<p>Время: {{ $booking->duration }} часа</p>
<a href="{{ route('welcome') }}">Назад</a>
@endsection