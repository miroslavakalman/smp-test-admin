<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Club;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $clubId = $request->input('club', Club::first()->id);  
        $selectedClub = Club::find($clubId);
    
        if (!$selectedClub) {
            abort(404, 'Клуб не найден');
        }
    
        $start_date = $request->input('start_date');
        $finish_date = $request->input('finish_date');
        if ($request->filled('all-time')) {
            $bookings = Booking::where('club_id', $selectedClub->id)->get();
        } else {
            $bookings = Booking::where('club_id', $selectedClub->id)
                ->whereBetween('booking_date', [$start_date, $finish_date])
                ->get();
        }
    
        return view('welcome', [
            'bookings' => $bookings,
            'clubs' => Club::all(), // Для фильтрации клубов
            'selectedClub' => $selectedClub, // Выбранный клуб
        ]);
    }
    
    public function show($clubId, $id)
    {
        // Найдем клуб по его ID
        $club = Club::findOrFail($clubId);

        // Найдем бронирование по ID
        $booking = Booking::findOrFail($id);

        // Отправим данные в представление
        return view('bookings.show', compact('club', 'booking'));
    }

    public function edit($clubId, $id)
    {
        $club = Club::findOrFail($clubId);
        $booking = Booking::where('id', $id)->where('club_id', $club->id)->firstOrFail();

        return view('bookings.edit', compact('club', 'booking'));
    }

    public function destroy($clubId, $id)
    {
        $club = Club::findOrFail($clubId);
        $booking = Booking::where('id', $id)->where('club_id', $club->id)->firstOrFail();
        $booking->delete();

        return redirect()->route('clubs.bookings.index', $club->id)->with('success', 'Бронирование удалено');
    }

    public function update(Request $request, $clubId, $id)
    {
        $club = Club::findOrFail($clubId);

        $booking = Booking::where('id', $id)->where('club_id', $club->id)->firstOrFail();

        $validated = $request->validate([
            'visitor_name' => 'required|max:255',
            'phone' => 'required',
            'booking_date' => 'required|date',
            'quantity' => 'required|integer',
            'duration' => 'required|integer',
        ]);

        $booking->update($validated);

        return redirect()->route('clubs.bookings.index', $club->id)
            ->with('success', 'Бронирование обновлено');
    }

    public function store(Request $request, $club_id)
    {
        $club = Club::findOrFail($club_id);

        $validated = $request->validate([
            'visitor_name' => 'required|max:255',
            'phone' => 'required',
            'booking_date' => 'required|date',
            'quantity' => 'required|integer',
            'duration' => 'required|integer',
        ]);

        $club->bookings()->create($validated); // Привязываем запись к клубу

        return redirect()->route('clubs.bookings.index', $club_id)->with('success', 'Запись создана.');
    }

    public function create($club_id)
    {
        $club = Club::findOrFail($club_id);
        return view('create', compact('club')); // Отправляем клуб в форму
    }
}
