@extends('layouts.app')

@section('content')
<h1>Создать новую запись</h1>

<form action="{{ route('clubs.bookings.store', $club->id) }}" method="POST">
    @csrf
    <label>Имя посетителя:</label>
    <input type="text" name="visitor_name" required>

    <label>Телефон:</label>
    <input type="text" name="phone" required>

    <label>Дата бронирования:</label>
    <input type="datetime-local" name="booking_date" required>

    <label>Количество:</label>
    <input type="number" name="quantity" required>

    <label>Продолжительность (часы):</label>
    <input type="number" name="duration" required>

    <button type="submit">Создать запись</button>
</form>

@endsection
