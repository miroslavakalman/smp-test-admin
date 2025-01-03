@extends('layouts.client')

@section('content')
<h1>Сделать бронирование в клубе "{{ $club->name }}"</h1>

<form id="form" action="{{ route('client.bookings.store', $club->id) }}" method="POST">
    @csrf
    <div class="form-columns">
        <div class="form-column">
            <label for="visitor_name">Имя:</label>
            <input type="text" name="visitor_name" id="visitor_name" required>

            <label for="phone">Телефон:</label>
            <input type="text" name="phone" id="phone" required>

            <label for="in_club_status">Вы сейчас:</label>
            <select id="in_club_status" name="in_club_status" required>
                <option value="yes">В клубе</option>
                <option value="no" selected>Не в клубе</option>
            </select>

            <label for="sim_setup">КПП и ручник:</label>
            <select id="sim-setup" name="sim_setup" required>
                <option value="" disabled selected>Выберите опцию</option>
                <option value="yes">Да</option>
                <option value="no">Нет</option>
            </select>
        </div>

        <div class="form-column">
            <div id="booking-section">
                <h3>Выберите дату:</h3>
                <input type="date" id="calendar" name="booking_date" required>

                <h3>Выберите время:</h3>
                <div id="time-slots" class="time-slots-grid"></div>
                <input type="hidden" id="selected-time" name="booking_time" required>
            </div>

            <label for="booking-time">Тариф по времени:</label>
            <select id="booking-time" name="booking-time" required>
                <option value="" disabled selected>Выберите тариф</option>
                <option value="650">30 минут - 650 руб</option>
                <option value="1000">1 час - 1000 руб</option>
                <option value="1500">1.5 часа - 1500 руб</option>
                <option value="1800">2 часа - 1800 руб</option>
                <option value="2200">2.5 часа - 2200 руб</option>
                <option value="2600">3 часа - 2600 руб</option>
                <option value="3000">3.5 часа - 3000 руб</option>
                <option value="3400">4 часа - 3400 руб</option>
                <option value="3800">4.5 часа - 3800 руб</option>
                <option value="4200">5 часов - 4200 руб</option>
                <option value="4600">5.5 часов - 4600 руб</option>
                <option value="5000">6 часов - 5000 руб</option>
                <option value="5400">6.5 часов - 5400 руб</option>
                <option value="5800">7 часов - 5800 руб</option>
                <option value="6200">7.5 часа - 6200 руб</option>
                <option value="6600">8 часов - 6600 руб</option>
                <option value="7000">8.5 часа - 7000 руб</option>
                <option value="7400">9 часов - 7400 руб</option>
                <option value="7800">9.5 часов - 7800 руб</option>
            </select>

            <label for="quantity">Количество бронируемых симуляторов:</label>
            <input type="number" name="quantity" id="quantity" required>

            <label for="duration">Длительность (часы):</label>
            <input type="number" name="duration" id="duration" required>

            <br>
            <button class="shift" type="submit">Готово</button>
        </div>
    </div>
</form>

<script>
    const today = new Date().toISOString().split('T')[0];
    calendar.setAttribute('min', today);

    // Генерация плитки с временем
    const timeSlotsContainer = document.getElementById('time-slots');
    const selectedTimeInput = document.getElementById('selected-time');

    const timeSlots = [];
    for (let hour = 12; hour <= 21; hour++) {
        for (let minute = 0; minute < 60; minute += 30) {
            const formattedHour = String(hour).padStart(2, '0');
            const formattedMinute = String(minute).padStart(2, '0');
            timeSlots.push(`${formattedHour}:${formattedMinute}`);
        }
    }

    timeSlots.forEach((time) => {
        const tile = document.createElement('div');
        tile.className = 'time-slot';
        tile.textContent = time;
        tile.dataset.time = time;

        tile.addEventListener('click', function () {
            document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
            this.classList.add('selected');
            selectedTimeInput.value = this.dataset.time;
        });

        timeSlotsContainer.appendChild(tile);
    });

    // Управление состоянием блоков "в клубе/не в клубе"
    const inClubStatus = document.getElementById('in_club_status');
    inClubStatus.addEventListener('change', function () {
        const isInClub = this.value === 'yes';
        calendar.disabled = isInClub;
        document.getElementById('time-slots').style.display = isInClub ? 'none' : 'grid';
        if (isInClub) {
            calendar.value = '';
            selectedTimeInput.value = '';
        }
    });

    // Проверка условий перед отправкой формы
    document.querySelector('form').addEventListener('submit', function (e) {
        const quantity = document.getElementById('quantity').value;
        const simSetup = document.getElementById('sim-setup').value;

        if (simSetup === 'yes' && quantity > 2) {
            alert('Вы не можете выбрать больше 2 мест при использовании КПП и ручника. Пожалуйста, уменьшите количество.');
            e.preventDefault();
        }
    });
</script>

@endsection
