<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

// Room API routes
Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/{id}', [RoomController::class, 'show']);
Route::post('/rooms/check-availability', [RoomController::class, 'checkAvailability']);
Route::get('/rooms/types', [RoomController::class, 'getRoomTypes']);

// Booking API routes
Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/bookings/{id}', [BookingController::class, 'show']);
Route::post('/bookings/{id}/status', [BookingController::class, 'updateStatus']);
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
Route::post('/bookings/available-rooms', [BookingController::class, 'getAvailableRooms']);
