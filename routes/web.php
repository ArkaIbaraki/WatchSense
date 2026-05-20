<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;

// Home route - redirect based on auth status
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('gallery.index');
    }
    
    $trendingMovie = Cache::remember('trending_movie', 3600, function () {
        $trendingMovie = null;
        try {
            $apiKey = config('services.tmdb.api_key');
            if ($apiKey) {
                $response = Http::timeout(10)
                    ->withoutVerifying()
                    ->get('https://api.themoviedb.org/3/trending/movie/week', [
                        'api_key' => $apiKey,
                    ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data['results'])) {
                        $movie = $data['results'][0];
                        
                        // Fetch movie details to get genres
                        $detailsResponse = Http::timeout(10)
                            ->withoutVerifying()
                            ->get('https://api.themoviedb.org/3/movie/' . $movie['id'], [
                                'api_key' => $apiKey,
                            ]);
                        
                        $genres = [];
                        if ($detailsResponse->successful()) {
                            $details = $detailsResponse->json();
                            $genres = collect($details['genres'] ?? [])->pluck('name')->toArray();
                        }
                        
                        $trendingMovie = [
                            'id' => $movie['id'] ?? null,
                            'title' => $movie['title'] ?? 'Unknown',
                            'overview' => $movie['overview'] ?? '',
                            'backdrop_url' => isset($movie['backdrop_path']) 
                                ? 'https://image.tmdb.org/t/p/w1280' . $movie['backdrop_path']
                                : null,
                            'poster_url' => isset($movie['poster_path'])
                                ? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path']
                                : null,
                            'rating' => $movie['vote_average'] ?? 0,
                            'genres' => $genres,
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to fetch trending movies: ' . $e->getMessage());
        }
        return $trendingMovie;
    });
    
    return view('landing', ['trendingMovie' => $trendingMovie]);
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
