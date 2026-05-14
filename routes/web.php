<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;

// Home route - redirect based on auth status
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('gallery.index');
    }
    return view('landing');
})->name('home');

// Guest Routes (only for unauthenticated users)
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'store']);
    
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes (only for authenticated users)
Route::middleware('auth')->group(function () {
    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/api/search-movies', [GalleryController::class, 'searchPreview'])->name('search.preview');
    
    // Movie browsing
    Route::get('/movie/{id}', fn($id) => view('movie-details', ['movieId' => $id]))->name('movie.details');
    
    // User profile
    Route::get('/profile', fn() => view('profile'))->name('profile');
    Route::get('/dashboard', fn() => redirect()->route('profile'))->name('dashboard');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    
    // Prevent GET requests to logout
    Route::get('/logout', fn() => redirect('/'));
});
