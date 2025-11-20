<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Schedule
Route::get('/schedule', function () {
    return view('schedule');
})->name('schedule');

// Speakers
Route::get('/speakers', function () {
    return view('speakers');
})->name('speakers');

// Buy Tickets - Updated to use TicketController
Route::get('/buy-tickets', [TicketController::class, 'showPurchase'])->name('buy-tickets');

// Venue
Route::get('/venue', function () {
    return view('venue');
})->name('venue');

// Terms
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// Privacy
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Contact
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// ===== Authentication Routes =====
// Registration
Route::get('/register', [AuthController::class, 'showRegister'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ===== Ticket Routes =====
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [TicketController::class, 'dashboard'])->name('dashboard');
    
    // Purchase ticket
    Route::post('/tickets/purchase', [TicketController::class, 'purchase'])->name('ticket.purchase');
    
    // My tickets list
    Route::get('/my-tickets', [TicketController::class, 'myTickets'])->name('my-tickets');
    
    // View ticket details
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('ticket.show');
    
    // Cancel ticket
    Route::delete('/tickets/{ticket}/cancel', [TicketController::class, 'cancel'])->name('ticket.cancel');
    
    // Download ticket
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])->name('ticket.download');
    
    // Purchase confirmation
    Route::get('/tickets/confirmation/{ticket}', [TicketController::class, 'confirmation'])->name('tickets.confirmation');
});
