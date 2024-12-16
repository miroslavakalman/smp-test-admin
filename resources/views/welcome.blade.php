@extends('layouts.app')

@section('content')
<h1>Управление бронированиями</h1>

<!-- Фильтр по клубам -->
<form action="{{ route('welcome') }}" method="GET">
    <select name="club" onchange="this.form.submit()">
        @foreach($clubs as $clubOption)
            <option value="{{ $clubOption->id }}" {{ $clubOption->id == $selectedClub->id ? 'selected' : '' }}>
                {{ $clubOption->name }}
            </option>
        @endforeach
    </select>
</form>

<div class="other-buttons">
    <button class="shift">На смене</button>
    <button class="booking-scheme">График броней</button>
    <button class="booking-scheme">
        <a href="{{ route('clubs.bookings.create', $selectedClub->id) }}">Создать запись</a>
    </button>
</div>

<div class="filter-by-date">
    <button class="all-time">За все время</button>
    <div class="sort-by-period">
        <p>Период от</p>
        <input type="date" name="start-date" id="start-date" placeholder="дд.мм.гг">
        <p>до</p>
        <input type="date" name="finish-date" id="finish-date" placeholder="дд.мм.гг">
    </div>
</div>

<!-- Таблица с бронированиями -->
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>ФИО посетителя</th>
            <th>Номер телефона</th>
            <th>Дата бронирования</th>
            <th>Количество</th>
            <th>Время</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->visitor_name }}</td>
                <td>{{ $booking->phone }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y, H:i') }}</td>
                <td>{{ $booking->quantity }}</td>
                <td>{{ $booking->duration }} часа</td>
                <td>
                    <!-- Ссылка на просмотр -->
                    <a href="{{ route('bookings.show', ['club' => $selectedClub->id, 'id' => $booking->id]) }}">
                        <img class="icon-watch" src="img/icon-watch.png" alt="Просмотреть">
                    </a>

                    <!-- Ссылка на редактирование -->
                    <a href="{{ route('bookings.edit', ['club' => $selectedClub->id, 'id' => $booking->id]) }}">
                        <img class="icon-edit" src="img/icon-edit.png" alt="Редактировать">
                    </a>

                    <!-- Форма для удаления -->
                    <form action="{{ route('bookings.destroy', ['club' => $selectedClub->id, 'id' => $booking->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; cursor: pointer;">
                            <img class="icon-bin" src="img/icon-bin.png" alt="Удалить">
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
