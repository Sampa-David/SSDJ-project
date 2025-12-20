<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\EventPaymentController;
use App\Http\Controllers\EventPublicController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;

// ========================================
// PUBLIC ROUTES
// ========================================

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

// Buy Tickets
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

// ========================================
// AUTHENTICATION ROUTES (Guest Only)
// ========================================

// Registration - Simple form
Route::get('/register', [AuthController::class, 'showRegister'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ========================================
// USER ROUTES (Authenticated)
// ========================================

Route::middleware('auth')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [TicketController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
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
    
    // Messages & Conversations
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}/reply', [MessageController::class, 'storeMessage'])->name('messages.reply');
    Route::post('/messages/{conversation}/close', [MessageController::class, 'close'])->name('messages.close');
    Route::post('/messages/{conversation}/reopen', [MessageController::class, 'reopen'])->name('messages.reopen');
    
    // Event Publishing Payment Routes (Must be before Route::resource to avoid conflicts)
    Route::get('/events/payment', [EventPaymentController::class, 'showPaymentPage'])->name('events.payment');
    Route::post('/events/payment/process', [EventPaymentController::class, 'processPayment'])->name('events.process-payment');
    Route::get('/events/payment-confirmation/{publishingRight}', [EventPaymentController::class, 'confirmation'])->name('events.payment-confirmation');
    
    // Events Management (Must be after specific payment routes)
    Route::resource('events', eventController::class);
});

// ========================================
// ADMIN ROUTES (Authenticated + Admin Role)
// ========================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Admin Profile Management
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Users Management
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminDashboardController::class, 'showUser'])->name('user');
    
    // Tickets Management
    Route::get('/tickets', [AdminDashboardController::class, 'tickets'])->name('tickets');
    Route::get('/tickets/{ticket}', [AdminDashboardController::class, 'showTicket'])->name('ticket');
    
    // Events Management (Admin can create without payment)
    Route::get('/events', [AdminDashboardController::class, 'events'])->name('events.index');
    Route::get('/events/create', [AdminDashboardController::class, 'createEvent'])->name('events.create');
    Route::post('/events', [AdminDashboardController::class, 'storeEvent'])->name('events.store');
    Route::get('/events/{event}/edit', [AdminDashboardController::class, 'editEvent'])->name('events.edit');
    Route::put('/events/{event}', [AdminDashboardController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{event}', [AdminDashboardController::class, 'deleteEvent'])->name('events.destroy');
    
    // Payment History
    Route::get('/payment-history', [AdminDashboardController::class, 'paymentHistory'])->name('payment-history');
    
    // Messages Management
    Route::get('/messages', [MessageController::class, 'adminConversations'])->name('messages.admin-conversations');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}/reply', [MessageController::class, 'storeMessage'])->name('messages.reply');
    Route::post('/messages/{conversation}/assign', [MessageController::class, 'assignToAdmin'])->name('messages.assign');
    Route::post('/messages/{conversation}/close', [MessageController::class, 'close'])->name('messages.close');
    Route::delete('/messages/{conversation}', [MessageController::class, 'destroy'])->name('messages.destroy');
    
    // Statistics & Reports
    Route::get('/stats', [AdminDashboardController::class, 'getStats'])->name('stats');
    Route::get('/export', [AdminDashboardController::class, 'exportStats'])->name('export');
});

// ========================================
// PUBLIC EVENTS ROUTES (Must be after authenticated routes to avoid conflicts)
// ========================================
Route::get('/browse-events', [EventPublicController::class, 'list'])->name('events.public.list');
Route::get('/browse-events/{event}', [EventPublicController::class, 'show'])->name('events.public.show');


