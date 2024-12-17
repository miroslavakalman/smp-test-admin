@extends('layouts.client')

@section('content')
    <h1>Сделать бронирование в клубе "{{ $club->name }}"</h1>
    <form action="{{ route('client.bookings.store', $club->id) }}" method="POST">
    @csrf
    <label for="visitor_name">Имя:</label>
    <input type="text" name="visitor_name" id="visitor_name" required>

    <label for="phone">Телефон:</label>
    <input type="text" name="phone" id="phone" required>

    <label for="in_club_status">Вы сейчас:</label>
    <select id="in_club_status" name="in_club_status" required>
        <option value="yes">В клубе</option>
        <option value="no">Не в клубе</option>
    </select>

    <label for="booking_date">Дата и время бронирования:</label>
    <input 
        type="datetime-local" 
        id="booking_date" 
        name="booking_date" 
        step="1800" 
        required
        disabled>

    <label for="quantity">Количество бронируемых симуляторов:</label>
    <input type="number" name="quantity" id="quantity" required>

    <label for="duration">Длительность (часы):</label>
    <input type="number" name="duration" id="duration" required>
    <br>
    <button class="shift" type="submit">Готово</button>
</form>

<script>
    const inClubStatus = document.getElementById('in_club_status');
    const bookingDate = document.getElementById('booking_date');

    inClubStatus.addEventListener('change', function () {
        bookingDate.disabled = this.value === 'yes'; 
    });

    // bookingDate.addEventListener('focus', function () {
    //     const now = new Date();
    //     const today = now.toISOString().slice(0, 10); 

    //     this.min = `${today}T12:00`;
    //     this.max = `${today}T22:00`;
    // });

    // bookingDate.addEventListener('input', function () {
    //     const selectedDateTime = new Date(this.value);
    //     const selectedMinutes = selectedDateTime.getMinutes();

    //     if (selectedMinutes % 30 !== 0) {
    //         const correctedMinutes = selectedMinutes < 30 ? 0 : 30;
    //         selectedDateTime.setMinutes(correctedMinutes);
    //         this.value = selectedDateTime.toISOString().slice(0, 16); 
    //     }
    // });
</script>
@endsection
