<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes (Magic Link)
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function () {
        // Magic link login logic will be implemented later
    })->name('login.post');

    Route::get('/verify/{token}', function () {
        // Magic link verification logic will be implemented later
    })->name('verify');

    Route::post('/logout', function () {
        // Logout logic will be implemented later
    })->name('logout');
});

// Profile setup (for first-time users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/setup', function () {
        return view('profile.setup');
    })->name('profile.setup');

    Route::post('/profile/setup', function () {
        // Profile setup logic will be implemented later
    })->name('profile.setup.post');
});

// Authenticated routes
Route::middleware(['auth', 'profile.complete'])->group(function () {
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
