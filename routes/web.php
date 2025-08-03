<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ConnectionManagementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MagicLinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSetupController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes (Magic Link)
Route::get('/login', [MagicLinkController::class, 'showLoginForm'])->name('login');
Route::post('/magic-link/send', [MagicLinkController::class, 'sendMagicLink'])->name('magic-link.send');
Route::get('/magic-link/verify', [MagicLinkController::class, 'verify'])->name('magic-link.verify');
Route::post('/magic-link/verify', [MagicLinkController::class, 'verify'])->name('magic-link.verify.post');
Route::get('/verify', [MagicLinkController::class, 'showVerificationForm'])->name('verify.form');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Profile setup (for first-time users)
Route::middleware(['auth', 'user.active'])->group(function () {
    Route::get('/profile/setup', [ProfileSetupController::class, 'show'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileSetupController::class, 'store'])->name('profile.setup.store');
});

// Routes for inactive users (profile access only)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Authenticated routes (active users only)
Route::middleware(['auth', 'user.active', 'profile.complete'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('events.index');
    })->name('dashboard');

    // Event Attendance
    Route::post('/events/{event}/attend', [AttendanceController::class, 'toggle'])
        ->name('events.attend')
        ->middleware('can.mark.attendance');

    // Profile management (duplicated routes for active users)
    // These routes are handled by the middleware group above

    // Connection system
    Route::prefix('connections')->name('connections.')->group(function () {
        // Connection management pages
        Route::get('/', [ConnectionManagementController::class, 'index'])->name('index');
        Route::get('/incoming', [ConnectionManagementController::class, 'incoming'])->name('incoming');
        Route::get('/sent', [ConnectionManagementController::class, 'sent'])->name('sent');
        Route::get('/matches', [ConnectionManagementController::class, 'matches'])->name('matches');

        Route::post('/request/{user:slug}', [ConnectionController::class, 'sendRequest'])->name('request');
        Route::post('/cancel/{user:slug}', [ConnectionController::class, 'cancelRequest'])->name('cancel');
        Route::post('/accept/{user:slug}', [ConnectionController::class, 'acceptRequest'])->name('accept');
        Route::post('/reject/{user:slug}', [ConnectionController::class, 'rejectRequest'])->name('reject');
    });

    // User profiles (view other users)
    Route::get('/users', function () {
        $users = \App\Models\User::active()
            ->where('id', '!=', auth()->id())
            ->whereNotNull('slug')
            ->get();

        return view('users.index', compact('users'));
    })->name('users.index');

    Route::get('/users/{user:slug}', [ProfileController::class, 'show'])->name('users.show');
});
