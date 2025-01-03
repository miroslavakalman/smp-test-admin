<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Club;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function checkBookingLimit(Request $request, $clubId)
    {
        $bookingDate = Carbon::parse($request->input('booking_date'));
        $club = Club::find($clubId);

        // Check existing bookings for the same time range
        $existingBookings = Booking::where('club_id', $clubId)
            ->where('booking_date', $bookingDate->format('Y-m-d H:i:s'))
            ->count();

        if ($existingBookings >= $club->pc_count) {
            return response()->json(['error' => 'В это время нет свободных симуляторов']);
        }

        return response()->json(['success' => 'Симуляторы доступны']);
    }

    public function updateAll(Request $request, $clubId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
        ]);

        Booking::where('club_id', $clubId)->update([
            'quantity' => $request->quantity,
            'duration' => $request->duration,
        ]);

        return redirect()->back()->with('success', 'Изменения успешно сохранены.');
    }

    public function index(Request $request)
    {
        $clubId = $request->input('club', Club::first()->id);  
        $selectedClub = Club::find($clubId);
    
        if (!$selectedClub) {
            abort(404, 'Клуб не найден');
        }
    
        $start_date = $request->input('start_date');
        $finish_date = $request->input('finish_date');
    
        $bookings = Booking::where('club_id', $selectedClub->id)
            ->when(!$request->filled('all-time'), function ($query) use ($start_date, $finish_date) {
                $query->whereBetween('booking_date', [$start_date, $finish_date]);
            })
            ->get()
            ->map(function ($booking) {
                $booking->formatted_date = Carbon::parse($booking->booking_date)->translatedFormat('d F Y, H:i');
                return $booking;
            });
    
        return view('welcome', [
            'bookings' => $bookings,
            'clubs' => Club::all(),
            'selectedClub' => $selectedClub, 
        ]);
    }

    public function show($clubId, $id)
    {
        $club = Club::findOrFail($clubId);
        $booking = Booking::findOrFail($id);
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
    public function store(Request $request, $clubId)
    {
        // Валидация входных данных
        $request->validate([
            'visitor_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'in_club_status' => 'required|string|in:yes,no',
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i', // Время в формате H:i
            'quantity' => 'required|integer|min:1',
            'sim_setup' => 'required|string|in:yes,no',
        ]);

        // Преобразуем дату и время в один объект Carbon
        $bookingDateTime = Carbon::parse($request->booking_date . ' ' . $request->booking_time);

        // Проверяем, не пересекается ли время с существующими бронированиями
        $existingBooking = Booking::where('club_id', $clubId)
            ->whereDate('booking_date', $bookingDateTime->toDateString())
            ->whereTime('booking_time', $bookingDateTime->toTimeString())
            ->exists();

        if ($existingBooking) {
            return back()->with('error', 'Это время уже занято. Пожалуйста, выберите другое.');
        }

        // Создание нового бронирования
        Booking::create([
            'club_id' => $clubId,
            'visitor_name' => $request->visitor_name,
            'phone' => $request->phone,
            'in_club_status' => $request->in_club_status,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'quantity' => $request->quantity,
            'sim_setup' => $request->sim_setup,
        ]);

        return redirect()->route('client.bookings.index', $clubId)
            ->with('success', 'Бронирование успешно создано.');
    }
    public function checkBooking(Request $request)
{
    $bookingDate = Carbon::parse($request->input('date'));
    $bookingTime = $request->input('time');

    $existingBookings = Booking::whereDate('booking_date', $bookingDate->format('Y-m-d'))
        ->where('booking_time', $bookingTime)
        ->count();

    return response()->json(['isOccupied' => $existingBookings > 0]);
}


    public function create($club_id)
    {
        $club = Club::findOrFail($club_id);
        return view('create', compact('club'));
    }

    public function clientCreate($club_id)
    {
        $club = Club::findOrFail($club_id); 
        return view('clients.bookings.create', compact('club')); 
    }

    public function clientStore(Request $request, $club_id)
    {
        $club = Club::findOrFail($club_id);

        $validated = $request->validate([
            'visitor_name' => 'required|max:255',
            'phone' => 'required',
            'booking_date' => 'required|date',
            'in_club_status' => 'required|in:yes,no',
            'quantity' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'sim_setup' => 'required|in:yes,no',
        ]);
        
        if ($validated['in_club_status'] === 'yes') {
            $validated['booking_date'] = now();
        }

        $club->bookings()->create($validated);

        return redirect()->route('client.bookings.thankyou')->with('success', 'Бронирование успешно создано!');
    }

    public function main()
    {
        $clubs = Club::all(); 
        return view('main', compact('clubs')); 
    }
}
