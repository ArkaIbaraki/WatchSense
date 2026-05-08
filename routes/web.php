<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Guest Routes (only for unauthenticated users)
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
});

// Protected Routes (only for authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', fn() => view('profile'))->name('profile');
    Route::get('/dashboard', fn() => redirect()->route('profile'))->name('dashboard');
    
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');
    
    // Prevent GET requests to logout
    Route::get('/logout', fn() => redirect('/'));
});
