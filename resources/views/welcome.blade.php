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
            <th style="width: 80px;">ID
                <input style="width: 80px;" type="text" name="filter_id" placeholder="Поиск" value="{{ request('filter_id') }}" onkeyup="filterTable()">
            </th>
            <th>ФИО посетителя
                <input style="width: 100%;" type="text" name="filter_name" placeholder="Поиск" value="{{ request('filter_name') }}" onkeyup="filterTable()">
            </th>
            <th>Номер телефона
                <input type="text" name="filter_phone" placeholder="Поиск" value="{{ request('filter_phone') }}" onkeyup="filterTable()">
            </th>
            <th >Дата бронирования
                <input type="text" name="filter_date" placeholder="Поиск" value="{{ request('filter_date') }}" onkeyup="filterTable()">
            </th>
            <th style="width: 100px;">Количество
                <input style="width: 80px;" type="text" name="filter_quantity" placeholder="Поиск" value="{{ request('filter_quantity') }}" onkeyup="filterTable()">
            </th>
            <th style="width: 80px;">Время
                <input style="width: 80px;"type="text" name="filter_time" placeholder="Поиск" value="{{ request('filter_time') }}" onkeyup="filterTable()">
            </th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody id="booking-table">
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->visitor_name }}</td>
                <td>{{ $booking->phone }}</td>
                <td>{{ $booking->formatted_date }}</td>
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
    function filterTable() {
        const table = document.getElementById('booking-table');
        const rows = table.getElementsByTagName('tr');
        const filters = {
            id: document.querySelector('input[name="filter_id"]').value.toLowerCase(),
            name: document.querySelector('input[name="filter_name"]').value.toLowerCase(),
            phone: document.querySelector('input[name="filter_phone"]').value.toLowerCase(),
            date: document.querySelector('input[name="filter_date"]').value.toLowerCase(),
            quantity: document.querySelector('input[name="filter_quantity"]').value.toLowerCase(),
            time: document.querySelector('input[name="filter_time"]').value.toLowerCase(),
        };

        Array.from(rows).forEach(row => {
            const cells = row.getElementsByTagName('td');
            if (cells.length) {
                const id = cells[0].innerText.toLowerCase();
                const name = cells[1].innerText.toLowerCase();
                const phone = cells[2].innerText.toLowerCase();
                const date = cells[3].innerText.toLowerCase();
                const quantity = cells[4].innerText.toLowerCase();
                const time = cells[5].innerText.toLowerCase();

                if (
                    (filters.id && !id.includes(filters.id)) ||
                    (filters.name && !name.includes(filters.name)) ||
                    (filters.phone && !phone.includes(filters.phone)) ||
                    (filters.date && !date.includes(filters.date)) ||
                    (filters.quantity && !quantity.includes(filters.quantity)) ||
                    (filters.time && !time.includes(filters.time))
                ) {
                    row.style.display = 'none';
                } else {
                    row.style.display = '';
                }
            }
        });
    }
</script>
