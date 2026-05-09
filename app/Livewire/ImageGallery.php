<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ImageGallery extends Component
{
    public $movies = [];
    public $loading = true;

    public function mount()
    {
        $this->fetchMovies();
    }

    public function fetchMovies()
    {
        try {
            // Get API key from env, with fallback
            $apiKey = $_ENV['TMDB_API_KEY'] ?? env('TMDB_API_KEY');
            
            if (!$apiKey) {
                throw new \Exception('TMDB_API_KEY not configured');
            }
            
            // Fetch genres first
            $genresResponse = Http::timeout(10)
                ->withoutVerifying()
                ->get('https://api.themoviedb.org/3/genre/movie/list', [
                    'api_key' => $apiKey,
                ]);
            
            $genreData = $genresResponse->json();
            $genreMap = [];
            if (isset($genreData['genres'])) {
                foreach ($genreData['genres'] as $genre) {
                    $genreMap[$genre['id']] = $genre['name'];
                }
            }
            
            // Fetch movies
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->get('https://api.themoviedb.org/3/discover/movie', [
                    'api_key' => $apiKey,
                    'sort_by' => 'popularity.desc',
                    'page' => 1,
                ]);
            
            if (!$response->successful()) {
                throw new \Exception('API returned status: ' . $response->status());
            }
            
            $data = $response->json();
            
            if (!isset($data['results']) || empty($data['results'])) {
                \Log::warning('TMDb API returned empty results', $data);
                $this->movies = [];
                $this->loading = false;
                return;
            }
            
            // Format movies with image URLs and genres
            $this->movies = collect($data['results'])->map(function ($movie) use ($genreMap) {
                $genres = [];
                if (isset($movie['genre_ids'])) {
                    $genres = array_map(function ($genreId) use ($genreMap) {
                        return $genreMap[$genreId] ?? 'Unknown';
                    }, array_slice($movie['genre_ids'], 0, 2)); // Get first 2 genres
                }
                
                return [
                    'title' => $movie['title'] ?? 'Unknown',
                    'poster_url' => 'https://image.tmdb.org/t/p/w500' . ($movie['poster_path'] ?? ''),
                    'backdrop_url' => 'https://image.tmdb.org/t/p/w1280' . ($movie['backdrop_path'] ?? ''),
                    'rating' => $movie['vote_average'] ?? 0,
                    'overview' => $movie['overview'] ?? 'No overview available',
                    'release_date' => $movie['release_date'] ?? 'N/A',
                    'genres' => $genres,
                ];
            })->toArray();
            
            \Log::info('Successfully fetched ' . count($this->movies) . ' movies from TMDb');
            $this->loading = false;
        } catch (\Exception $e) {
            \Log::error('TMDb API Error: ' . $e->getMessage());
            $this->movies = [];
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.image-gallery');
    }
}
