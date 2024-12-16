@extends('layouts.app')

@section('content')
<h1>Просмотр бронирования</h1>
<form>
<p>ID: {{ $booking->id }}</p>
<p>ФИО: <input type="text" value="{{ $booking->visitor_name }}" readonly></p>
<p>Телефон: <input type="text" value="{{ $booking->phone }}" readonly></p>
<p>Дата: <input type="datetime-local" value="{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d\TH:i') }}" readonly></p>
<p>Количество: <input type="number" value="{{ $booking->quantity }}" readonly></p>
<p>Время: <input type="text" value="{{ $booking->duration }}" readonly></p>
<a class="href-back" href="{{ route('welcome') }}">Назад</a>
</form>
@endsection
