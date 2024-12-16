@extends('layouts.app')

@section('content')
<h1>Управление бронированиями</h1>
<form action="{{ route('welcome') }}" method="GET" id="date-filter-form">
    <select name="club" onchange="this.form.submit()">
        @foreach($clubs as $clubOption)
            <option value="{{ $clubOption->id }}" {{ $clubOption->id == $selectedClub->id ? 'selected' : '' }}>
                {{ $clubOption->name }}
            </option>
        @endforeach
    </select>
    
    <div class="other-buttons">
        <button class="shift">На смене</button>
        <button class="booking-scheme">График броней</button>
        <button class="booking-scheme">
            <a href="{{ route('clubs.bookings.create', $selectedClub->id) }}">Создать запись</a>
        </button>
    </div>

    <div class="filter-by-date">
        <button type="submit" name="all-time" value="true" class="all-time" onclick="clearAllTime()">За все время</button>
        <div class="sort-by-period">
            <p>Период от</p>
            <input type="date" name="start_date" id="start-date" value="{{ request('start_date') }}" onchange="this.form.submit()">
            <p>до</p>
            <input type="date" name="finish_date" id="finish-date" value="{{ request('finish_date') }}" onchange="this.form.submit()">
        </div>
    </div>
</form>

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
                    <a href="{{ route('bookings.show', ['club' => $selectedClub->id, 'id' => $booking->id]) }}">
                        <img class="icon-watch" src="{{ asset('img/icon-watch.png') }}" alt="Просмотреть">
                    </a>

                    <a href="{{ route('bookings.edit', ['club' => $selectedClub->id, 'id' => $booking->id]) }}">
                        <img class="icon-edit" src="{{ asset('img/icon-edit.png') }}" alt="Редактировать">
                    </a>

                    <form action="{{ route('bookings.destroy', ['club' => $selectedClub->id, 'id' => $booking->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; cursor: pointer;">
                            <img class="icon-bin" src="{{ asset('img/icon-bin.png') }}" alt="Удалить">
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInputs = document.querySelectorAll('#start-date, #finish-date');

        dateInputs.forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('date-filter-form').submit();
            });
        });
    });

    function clearAllTime() {
        document.getElementById('start-date').value = '';
        document.getElementById('finish-date').value = '';
        document.getElementById('date-filter-form').submit();
    }
</script>
