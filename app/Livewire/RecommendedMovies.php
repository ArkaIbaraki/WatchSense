<?php

namespace App\Livewire;

use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecommendedMovies extends Component
{
    public $filmId;
    public $recommendedMovies = [];
    public $loading = true;

    public function mount($filmId)
    {
        $this->filmId = $filmId;
        $this->fetchRecommendations();
    }

    public function fetchRecommendations()
    {
        try {
            $this->loading = true;

            // Get current authenticated user
            $user = Auth::user();

            if (!$user) {
                // If not authenticated, return empty
                $this->recommendedMovies = [];
                $this->loading = false;
                return;
            }

            // Use the RecommendationService to get weighted recommendations
            $recommendationService = new RecommendationService();
            $recommendations = $recommendationService->getRecommendationsForUser(
                $user->id,
                $this->filmId,
                8
            );

            // Format recommendations with poster URLs
            $this->recommendedMovies = collect($recommendations)->map(function ($film) {
                return [
                    'id' => $film->id,
                    'judul' => $film->judul,
                    'tahun_rilis' => $film->tahun_rilis,
                    'rating' => $film->rating,
                    'poster_url' => 'https://image.tmdb.org/t/p/w300/default-poster.jpg', // Fallback
                ];
            })->toArray();

            $this->loading = false;

        } catch (\Exception $e) {
            \Log::error('Failed to fetch recommendations: ' . $e->getMessage());
            $this->recommendedMovies = [];
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.recommended-movies');
    }
}
