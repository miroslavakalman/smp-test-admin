<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\club;
class BookingController extends Controller
{
  // app/Http/Controllers/BookingController.php
  public function index(Request $request)
  {
      // Получаем клуб из запроса или выбираем первый по умолчанию
      $clubId = $request->input('club', Club::first()->id);  // Если club не передан, выбираем первый клуб
      $selectedClub = Club::find($clubId);
  
      if (!$selectedClub) {
          abort(404, 'Клуб не найден');
      }
  
      // Получаем бронирования только для выбранного клуба
      $bookings = Booking::where('club_id', $selectedClub->id)->get();
  
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
