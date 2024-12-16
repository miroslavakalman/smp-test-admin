<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('welcome', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('bookings.edit', compact('booking'));
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('welcome')->with('success', 'Бронирование удалено');
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return redirect()->route('welcome')->with('success', 'Бронирование обновлено');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visitor_name' => 'required|max:255',
            'phone' => 'required',
            'email' => 'required|email',
            'booking_date' => 'required|date',
            'quantity' => 'required|integer',
            'duration' => 'required|integer',
        ]);
    
        Booking::create($validated); // Сохраняем данные в базу
        return redirect()->route('welcome')->with('success', 'Бронирование успешно создано.'); // Перенаправляем обратно на список броней
    }
    public function create()
    {
        return view('create'); // Указываем только имя файла без папки
    }
    
}
