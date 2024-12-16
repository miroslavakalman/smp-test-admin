@extends('layouts.app')

@section('content')
<h1>Создать новую запись</h1>
<div class="form-wrapping">
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
    <br>
    <button class="shift" type="submit">Создать</button>
    <a class="href-back" href="{{ route('welcome') }}">Назад</a>

</form>

</div>
@endsection
