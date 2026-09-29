<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\HotelRatingController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::post('/about/rating', [HomeController::class, 'submitRating'])->name('about.rating');

    // Booking self-service (customer)
    Route::patch('/bookings/{id}/dates', [BookingController::class, 'updateDates'])->name('bookings.update-dates');

    // Payment page (customer)
    Route::get('/bookings/{id}/pay', [BookingController::class, 'pay'])->name('bookings.pay');

    // Simulated payments
    Route::post('/bookings/{id}/payment', [BookingController::class, 'updatePayment'])->name('bookings.payment');
});

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Room routes
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::post('/rooms/check-availability', [RoomController::class, 'checkAvailability'])->name('rooms.check-availability');
Route::get('/rooms/types', [RoomController::class, 'getRoomTypes'])->name('rooms.types');

// Room management - Admin only
Route::middleware('admin')->group(function () {
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{id}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update');
});

Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show');

// Booking routes - Admin only
Route::middleware('admin')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('/admin/messages', [ContactMessageController::class, 'index'])->name('admin.messages.index');

    Route::get('/admin/ratings', [HotelRatingController::class, 'index'])->name('admin.ratings.index');
});

// Booking routes - Public
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
Route::get('/bookings/{id}/confirmation', [BookingController::class, 'confirmation'])->name('bookings.confirmation');
Route::get('/riwayat', [BookingController::class, 'history'])->name('bookings.history');
Route::get('/my-bookings', [BookingController::class, 'history'])->name('bookings.my-bookings');
