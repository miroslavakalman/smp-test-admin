<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
// Главная страница (таблица)
Route::get('/', [BookingController::class, 'index'])->name('welcome');

Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');     
Route::get('/bookings/{id}/edit', [BookingController::class, 'edit'])->name('bookings.edit'); 
Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
Route::patch('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');
// Для отображения формы создания записи
Route::get('create', [BookingController::class, 'create'])->name('bookings.create');



// Для обработки POST-запроса с формы
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
