<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MagicLinkController;
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
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    Route::get('/profile/edit', function () {
        return view('profile.edit');
    })->name('profile.edit');

    Route::put('/profile', function () {
        // Profile update logic will be implemented later
    })->name('profile.update');
});

// Authenticated routes (active users only)
Route::middleware(['auth', 'user.active', 'profile.complete'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('events.index');
    })->name('dashboard');

    // Dashboard/Events
    Route::get('/events', function () {
        return view('events.index');
    })->name('events.index');

    Route::get('/events/{event}', function () {
        return view('events.show');
    })->name('events.show');

    Route::post('/events/{event}/attend', function () {
        // Mark attendance logic will be implemented later
    })->name('events.attend');

    // Profile management
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    Route::get('/profile/edit', function () {
        return view('profile.edit');
    })->name('profile.edit');

    Route::put('/profile', function () {
        // Profile update logic will be implemented later
    })->name('profile.update');

    // Connection system
    Route::prefix('connections')->name('connections.')->group(function () {
        Route::get('/', function () {
            return view('connections.index');
        })->name('index');

        Route::post('/request/{user}', function () {
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
    Route::get('/users/{user}', function () {
        return view('users.show');
    })->name('users.show');
});
