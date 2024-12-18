<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::prefix('client/clubs/{club_id}/bookings')->group(function () {
    Route::get('/create', [BookingController::class, 'clientCreate'])->name('client.bookings.create');
    Route::post('/', [BookingController::class, 'clientStore'])->name('client.bookings.store');
});
Route::patch('/clubs/{club}/bookings/update-all', [BookingController::class, 'updateAll'])->name('bookings.update-all');

Route::get('/thank-you', function () {
    return view('clients.bookings.thankyou'); 
})->name('client.bookings.thankyou');
Route::get('/clubs', [BookingController::class, 'main'])->name('main');

Route::get('/{club?}', [BookingController::class, 'index'])->name('welcome');

Route::prefix('clubs/{club}')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('clubs.bookings.index');
    Route::get('create', [BookingController::class, 'create'])->name('clubs.bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('clubs.bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{id}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::patch('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});



