<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminDashboardController;

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
// EMAIL VERIFICATION ROUTES (Guest Only)
// ========================================

Route::middleware('guest')->prefix('register')->name('register.')->group(function () {
    // Step 1: Enter email
    Route::get('/', [EmailVerificationController::class, 'showRegisterForm'])->name('email');
    Route::post('/send-code', [EmailVerificationController::class, 'sendCode'])->name('send-code');
    
    // Step 2: Verify code and create account
    Route::get('/verify', [EmailVerificationController::class, 'showCodeForm'])->name('verify');
    Route::post('/verify-code', [EmailVerificationController::class, 'verifyCode'])->name('verify-code');
    
    // Resend code
    Route::post('/resend-code', [EmailVerificationController::class, 'resendCode'])->name('resend-code');
});

// ========================================
// AUTHENTICATION ROUTES (Guest Only)
// ========================================

// Legacy Registration (if still needed)
Route::get('/register-old', [AuthController::class, 'showRegister'])->middleware('guest')->name('register-old');
Route::post('/register-old', [AuthController::class, 'register'])->middleware('guest');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ========================================
// USER ROUTES (Authenticated)
// ========================================

Route::middleware('auth')->group(function () {
    // User Dashboard
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

// ========================================
// ADMIN ROUTES (Authenticated + Admin Role)
// ========================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminDashboardController::class, 'showUser'])->name('user');
    
    // Tickets Management
    Route::get('/tickets', [AdminDashboardController::class, 'tickets'])->name('tickets');
    Route::get('/tickets/{ticket}', [AdminDashboardController::class, 'showTicket'])->name('ticket');
    
    // Statistics & Reports
    Route::get('/stats', [AdminDashboardController::class, 'getStats'])->name('stats');
    Route::get('/export', [AdminDashboardController::class, 'exportStats'])->name('export');
});

