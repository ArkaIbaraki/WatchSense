<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class MovieDetails extends Component
{
    public $movieId;
    public $movie = null;
    public $loading = true;
    public $cast = [];
    public $crew = [];
    public $similarMovies = [];

    public function mount($movieId)
    {
        $this->movieId = $movieId;
        $this->fetchMovieDetails();
    }

    public function fetchMovieDetails()
    {
        try {
            $apiKey = $_ENV['TMDB_API_KEY'] ?? env('TMDB_API_KEY');
            
            if (!$apiKey) {
                throw new \Exception('TMDB_API_KEY not configured');
            }
            
            // Fetch main movie details
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->get("https://api.themoviedb.org/3/movie/{$this->movieId}", [
                    'api_key' => $apiKey,
                ]);
            
            if (!$response->successful()) {
                throw new \Exception('Failed to fetch movie details');
            }
            
            $data = $response->json();
            
            $this->movie = [
                'id' => $data['id'] ?? null,
                'title' => $data['title'] ?? 'Unknown',
                'poster_url' => 'https://image.tmdb.org/t/p/w500' . ($data['poster_path'] ?? ''),
                'backdrop_url' => 'https://image.tmdb.org/t/p/w1280' . ($data['backdrop_path'] ?? ''),
                'rating' => $data['vote_average'] ?? 0,
                'overview' => $data['overview'] ?? 'No overview available',
                'release_date' => $data['release_date'] ?? 'N/A',
                'runtime' => $data['runtime'] ?? 0,
                'genres' => collect($data['genres'] ?? [])->pluck('name')->toArray(),
                'status' => $data['status'] ?? 'Unknown',
                'budget' => $data['budget'] ?? 0,
                'revenue' => $data['revenue'] ?? 0,
                'language' => $data['original_language'] ?? 'Unknown',
                'vote_count' => $data['vote_count'] ?? 0,
            ];
            
            // Fetch cast and crew
            $creditsResponse = Http::timeout(10)
                ->withoutVerifying()
                ->get("https://api.themoviedb.org/3/movie/{$this->movieId}/credits", [
                    'api_key' => $apiKey,
                ]);
            
            if ($creditsResponse->successful()) {
                $creditsData = $creditsResponse->json();
                
                // Get cast (first 8)
                $this->cast = collect($creditsData['cast'] ?? [])->take(8)->map(function ($actor) {
                    return [
                        'id' => $actor['id'] ?? null,
                        'name' => $actor['name'] ?? 'Unknown',
                        'character' => $actor['character'] ?? 'Unknown',
                        'profile_path' => $actor['profile_path'] ? 'https://image.tmdb.org/t/p/w300' . $actor['profile_path'] : null,
                    ];
                })->toArray();
                
                // Get crew (directors, writers, producers, etc.)
                $this->crew = collect($creditsData['crew'] ?? [])->filter(function ($member) {
                    return in_array($member['job'], ['Director', 'Writer', 'Screenplay', 'Producer', 'Cinematography', 'Original Music Composer']);
                })->take(6)->toArray();
            }
            
            // Fetch similar movies
            $similarResponse = Http::timeout(10)
                ->withoutVerifying()
                ->get("https://api.themoviedb.org/3/movie/{$this->movieId}/similar", [
                    'api_key' => $apiKey,
                ]);
            
            if ($similarResponse->successful()) {
                $similarData = $similarResponse->json();
                
                $this->similarMovies = collect($similarData['results'] ?? [])->take(8)->map(function ($movie) {
                    return [
                        'id' => $movie['id'] ?? null,
                        'title' => $movie['title'] ?? 'Unknown',
                        'poster_url' => 'https://image.tmdb.org/t/p/w300' . ($movie['poster_path'] ?? ''),
                        'rating' => $movie['vote_average'] ?? 0,
                        'release_date' => $movie['release_date'] ?? 'N/A',
                        'runtime' => $movie['runtime'] ?? 0,
                    ];
                })->toArray();
            }
            
            $this->loading = false;
        } catch (\Exception $e) {
            \Log::error('Failed to fetch movie details: ' . $e->getMessage());
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.movie-details');
    }
}