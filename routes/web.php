<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;


Route::get('/', [BookingController::class, 'index'])->name('welcome');
Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');     
Route::get('/bookings/{id}/edit', [BookingController::class, 'edit'])->name('bookings.edit'); 
Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
Route::patch('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');
