<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ImageGallery extends Component
{
    public $movies = [];
    public $loading = true;
    public $search = '';

    public function mount()
    {
        $this->fetchMovies();
    }

    public function updatedSearch()
    {
        $this->loading = true;
        $this->fetchMovies();
    }

    public function fetchMovies()
    {
        try {
            // Get API key from env
            $apiKey = $_ENV['TMDB_API_KEY'] ?? env('TMDB_API_KEY');

            if (!$apiKey) {
                throw new \Exception('TMDB_API_KEY not configured');
            }

            // Fetch genres
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

            // Search or Discover
            if (!empty($this->search)) {
                $response = Http::timeout(10)
                    ->withoutVerifying()
                    ->get('https://api.themoviedb.org/3/search/movie', [
                        'api_key' => $apiKey,
                        'query' => $this->search,
                        'page' => 1,
                    ]);
            } else {
                $response = Http::timeout(10)
                    ->withoutVerifying()
                    ->get('https://api.themoviedb.org/3/discover/movie', [
                        'api_key' => $apiKey,
                        'sort_by' => 'popularity.desc',
                        'page' => 1,
                    ]);
            }

            if (!$response->successful()) {
                throw new \Exception('API returned status: ' . $response->status());
            }

            $data = $response->json();

            if (!isset($data['results']) || empty($data['results'])) {
                $this->movies = [];
                $this->loading = false;
                return;
            }

            // Format Movies
            $this->movies = collect($data['results'])->map(function ($movie) use ($genreMap) {

                $genres = [];

                if (isset($movie['genre_ids'])) {
                    $genres = array_map(function ($genreId) use ($genreMap) {
                        return $genreMap[$genreId] ?? 'Unknown';
                    }, array_slice($movie['genre_ids'], 0, 2));
                }

                return [
                    'id' => $movie['id'] ?? null,
                    'title' => $movie['title'] ?? 'Unknown',
                    'poster_url' => 'https://image.tmdb.org/t/p/w500' . ($movie['poster_path'] ?? ''),
                    'backdrop_url' => 'https://image.tmdb.org/t/p/w1280' . ($movie['backdrop_path'] ?? ''),
                    'rating' => $movie['vote_average'] ?? 0,
                    'overview' => $movie['overview'] ?? 'No overview available',
                    'release_date' => $movie['release_date'] ?? 'N/A',
                    'genres' => $genres,
                ];
            })->toArray();

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