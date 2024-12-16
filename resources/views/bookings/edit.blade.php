@extends('layouts.app')

@section('content')
<h1>Редактировать бронирование</h1>
<form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <label>ФИО: <input type="text" name="visitor_name" value="{{ $booking->visitor_name }}"></label><br>
    <label>Телефон: <input type="text" name="phone" value="{{ $booking->phone }}"></label><br>
    <label>Дата: <input type="datetime-local" name="booking_date" value="{{ $booking->booking_date }}"></label><br>
    <label>Количество: <input type="number" name="quantity" value="{{ $booking->quantity }}"></label><br>
    <label>Время: <input type="text" name="duration" value="{{ $booking->duration }}"></label><br>
    <button type="submit">Сохранить</button>
</form>
<a href="{{ route('welcome') }}">Назад</a>
@endsection