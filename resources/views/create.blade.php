@extends('layouts.app')

@section('content')
<h1>Создать новую запись</h1>

<form action="{{ route('bookings.store') }}" method="POST">
    @csrf
    <div>
        <label for="visitor_name">ФИО посетителя:</label>
        <input type="text" name="visitor_name" id="visitor_name" required>
    </div>
    <div>
        <label for="phone">Номер телефона:</label>
        <input type="text" name="phone" id="phone" required>
    </div>
    <div>
        <label for="email">Электронная почта:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="booking_date">Дата бронирования:</label>
        <input type="datetime-local" name="booking_date" id="booking_date" required>
    </div>
    <div>
        <label for="quantity">Количество человек:</label>
        <input type="number" name="quantity" id="quantity" required>
    </div>
    <div>
        <label for="duration">Продолжительность брони (в часах):</label>
        <input type="number" name="duration" id="duration" required>
    </div>
    <button type="submit">Создать запись</button>
</form>
@endsection
