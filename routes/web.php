<?php

use App\Http\Controllers\AttendanceController;
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

// Authenticated routes (active users only)
Route::middleware(['auth', 'user.active', 'profile.complete'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('events.index');
    })->name('dashboard');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    // Event Attendance
    Route::post('/events/{event}/attend', [AttendanceController::class, 'toggle'])
        ->name('events.attend')
        ->middleware('can.mark.attendance');

    // Profile management (duplicated routes for active users)
    // These routes are handled by the middleware group above

    // Connection system
    Route::prefix('connections')->name('connections.')->group(function () {
        Route::get('/', function () {
            return view('connections.index');
        })->name('index');

        Route::post('/request/{user:slug}', function () {
            // Send connection request logic will be implemented later
        })->name('request');

        Route::post('/accept/{request}', function () {
            // Accept connection request logic will be implemented later
        })->name('accept');

        Route::delete('/cancel/{request}', function () {
            // Cancel connection request logic will be implemented later
        })->name('cancel');
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
