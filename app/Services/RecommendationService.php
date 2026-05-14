<?php

namespace App\Services;

use App\Models\Film;
use App\Models\Review;
use App\Models\UserMovieLike;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    // Weight points for each factor
    private const GENRE_WEIGHT = 20;
    private const USER_LIKE_WEIGHT = 50;
    private const SIMILAR_USER_RATING_WEIGHT = 30;
    private const GLOBAL_RATING_WEIGHT = 15;
    private const ACTOR_WEIGHT = 15;
    private const DIRECTOR_WEIGHT = 15;

    /**
     * Get weighted recommendations for a specific user based on a current movie
     * 
     * @param int $userId
     * @param int $currentFilmId
     * @param int $limit
     * @return array
     */
    public function getRecommendationsForUser($userId, $currentFilmId, $limit = 8)
    {
        $currentFilm = Film::findOrFail($currentFilmId);
        
        // Get all films except the current one
        $allFilms = Film::where('id', '!=', $currentFilmId)
            ->get();

        // Build weighted graph and calculate scores
        $filmScores = [];

        foreach ($allFilms as $film) {
            $score = 0;

            // 1. Genre matching (20 points per shared genre)
            $score += $this->calculateGenreScore($currentFilm, $film);

            // 2. User's previous likes (50 points for movies they've liked)
            $score += $this->calculateUserLikeScore($userId, $film);

            // 3. Similar users' ratings (30 points)
            $score += $this->calculateSimilarUserScore($userId, $currentFilm, $film);

            // 4. Global rating weight (15 points based on average rating)
            $score += $this->calculateGlobalRatingScore($film);

            // 5. Common actors (15 points per shared actor)
            $score += $this->calculateActorScore($currentFilm, $film);

            // 6. Director connection (15 points)
            $score += $this->calculateDirectorScore($currentFilm, $film);

            if ($score > 0) {
                $filmScores[$film->id] = [
                    'film' => $film,
                    'score' => $score,
                ];
            }
        }

        // Sort by score descending
        usort($filmScores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Return top N films
        return collect($filmScores)
            ->take($limit)
            ->map(fn($item) => $item['film'])
            ->toArray();
    }

    /**
     * Calculate genre matching score
     */
    private function calculateGenreScore($currentFilm, $comparisonFilm)
    {
        $currentGenres = $currentFilm->genres()->pluck('genre_id')->toArray();
        $comparisonGenres = $comparisonFilm->genres()->pluck('genre_id')->toArray();

        $commonGenres = count(array_intersect($currentGenres, $comparisonGenres));
        
        return $commonGenres * self::GENRE_WEIGHT;
    }

    /**
     * Calculate score based on user's previous likes
     */
    private function calculateUserLikeScore($userId, $film)
    {
        $userLike = UserMovieLike::where('user_id', $userId)
            ->where('film_id', $film->id)
            ->where('is_liked', true)
            ->exists();

        return $userLike ? self::USER_LIKE_WEIGHT : 0;
    }

    /**
     * Calculate score based on similar users' ratings
     */
    private function calculateSimilarUserScore($userId, $currentFilm, $comparisonFilm)
    {
        // Find users who rated the current film highly
        $similarUsers = Review::where('film_id', $currentFilm->id)
            ->where('rating', '>=', 4)
            ->pluck('user_id')
            ->toArray();

        if (empty($similarUsers)) {
            return 0;
        }

        // Check if similar users rated the comparison film
        $similarUserRatings = Review::whereIn('user_id', $similarUsers)
            ->where('film_id', $comparisonFilm->id)
            ->avg('rating');

        if ($similarUserRatings === null) {
            return 0;
        }

        // Normalize rating (1-5 scale)
        return ($similarUserRatings / 5) * self::SIMILAR_USER_RATING_WEIGHT;
    }

    /**
     * Calculate score based on global film rating
     */
    private function calculateGlobalRatingScore($film)
    {
        $rating = $film->rating ?? 0;
        
        if ($rating == 0) {
            return 0;
        }

        // Normalize rating (1-10 scale to 0-1)
        return ($rating / 10) * self::GLOBAL_RATING_WEIGHT;
    }

    /**
     * Calculate score based on shared actors
     */
    private function calculateActorScore($currentFilm, $comparisonFilm)
    {
        $currentActors = $currentFilm->actors()->pluck('actor_id')->toArray();
        $comparisonActors = $comparisonFilm->actors()->pluck('actor_id')->toArray();

        $commonActors = count(array_intersect($currentActors, $comparisonActors));
        
        return $commonActors * self::ACTOR_WEIGHT;
    }

    /**
     * Calculate score based on director connection
     */
    private function calculateDirectorScore($currentFilm, $comparisonFilm)
    {
        if ($currentFilm->director_id === $comparisonFilm->director_id) {
            return self::DIRECTOR_WEIGHT;
        }

        return 0;
    }

    /**
     * Add a like for a user
     */
    public function addLike($userId, $filmId)
    {
        return UserMovieLike::updateOrCreate(
            ['user_id' => $userId, 'film_id' => $filmId],
            ['is_liked' => true]
        );
    }

    /**
     * Remove a like for a user
     */
    public function removeLike($userId, $filmId)
    {
        return UserMovieLike::where('user_id', $userId)
            ->where('film_id', $filmId)
            ->delete();
    }

    /**
     * Check if user liked a film
     */
    public function isLiked($userId, $filmId)
    {
        return UserMovieLike::where('user_id', $userId)
            ->where('film_id', $filmId)
            ->where('is_liked', true)
            ->exists();
    }
}
