<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

    /*
    |--------------------------------------------------------------------------
    | ADVANCED WEIGHTED GRAPH RECOMMENDATION
    |--------------------------------------------------------------------------
    */

    public function fetchRecommendations()
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | TEMP FIX EXECUTION TIME
            |--------------------------------------------------------------------------
            */

            set_time_limit(120);

            $this->loading = true;

            $user = Auth::user();

            if (!$user) {

                $this->recommendedMovies = [];

                return;
            }

            $apiKey = config('services.tmdb.api_key');

            if (!$apiKey) {
                throw new \Exception('TMDB API Key missing');
            }

            /*
            |--------------------------------------------------------------------------
            | CACHE
            |--------------------------------------------------------------------------
            */

            $cacheKey = "recommendations.user.{$user->id}";

            $this->recommendedMovies = Cache::remember(
                $cacheKey,
                3600,
                function () use ($user, $apiKey) {

                    /*
                    |--------------------------------------------------------------------------
                    | USER LIKES
                    |--------------------------------------------------------------------------
                    */

                    $userLikes = DB::table('user_movie_likes')
                        ->where('user_id', $user->id)
                        ->where('is_liked', 1)
                        ->pluck('film_id')
                        ->toArray();

                    /*
                    |--------------------------------------------------------------------------
                    | LIMIT USER LIKES
                    |--------------------------------------------------------------------------
                    */

                    $userLikes = array_slice($userLikes, 0, 5);

                    if (count($userLikes) < 1) {

                        return [];
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | SCORE STORAGE
                    |--------------------------------------------------------------------------
                    */

                    $scores = [];

                    /*
                    |--------------------------------------------------------------------------
                    | LOOP USER LIKES
                    |--------------------------------------------------------------------------
                    */

                    foreach ($userLikes as $likedFilmId) {

                        /*
                        |--------------------------------------------------------------------------
                        | CACHE MOVIE DETAILS
                        |--------------------------------------------------------------------------
                        */

                        $movieData = Cache::remember(
                            "movie.data.{$likedFilmId}",
                            86400,
                            function () use ($likedFilmId, $apiKey) {

                                $response = Http::timeout(10)
                                    ->withoutVerifying()
                                    ->get(
                                        "https://api.themoviedb.org/3/movie/{$likedFilmId}",
                                        [
                                            'api_key' => $apiKey,
                                        ]
                                    );

                                if (!$response->successful()) {
                                    return null;
                                }

                                return $response->json();
                            }
                        );

                        if (!$movieData) {
                            continue;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | GENRES
                        |--------------------------------------------------------------------------
                        */

                        $genres = collect($movieData['genres'] ?? [])
                            ->pluck('id')
                            ->toArray();

                        if (empty($genres)) {
                            continue;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | CACHE DISCOVER MOVIES
                        |--------------------------------------------------------------------------
                        */

                        $discoverMovies = Cache::remember(
                            "discover." . md5(implode(',', $genres)),
                            86400,
                            function () use ($genres, $apiKey) {

                                $response = Http::timeout(10)
                                    ->withoutVerifying()
                                    ->get(
                                        "https://api.themoviedb.org/3/discover/movie",
                                        [
                                            'api_key' => $apiKey,

                                            'with_genres' => implode(',', $genres),

                                            'vote_count.gte' => 100,

                                            'sort_by' => 'popularity.desc',
                                        ]
                                    );

                                if (!$response->successful()) {
                                    return [];
                                }

                                return collect(
                                    $response->json()['results'] ?? []
                                )
                                ->take(10)
                                ->toArray();
                            }
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | SCORING ENGINE
                        |--------------------------------------------------------------------------
                        */

                        foreach ($discoverMovies as $movie) {

                            $movieId = $movie['id'];

                            /*
                            |--------------------------------------------------------------------------
                            | SKIP LIKED MOVIES
                            |--------------------------------------------------------------------------
                            */

                            if (in_array($movieId, $userLikes)) {
                                continue;
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | INIT SCORE
                            |--------------------------------------------------------------------------
                            */

                            if (!isset($scores[$movieId])) {

                                $scores[$movieId] = [

                                    'score' => 0,

                                    'appearance' => 0,

                                    'data' => $movie,
                                ];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | GENRE SIMILARITY
                            |--------------------------------------------------------------------------
                            */

                            $candidateGenres = $movie['genre_ids'] ?? [];

                            $genreMatches = count(
                                array_intersect(
                                    $genres,
                                    $candidateGenres
                                )
                            );

                            $scores[$movieId]['score'] += (
                                $genreMatches * 5
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | HIGH RATING
                            |--------------------------------------------------------------------------
                            */

                            $scores[$movieId]['score'] += (
                                $movie['vote_average'] ?? 0
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | POPULARITY BOOST
                            |--------------------------------------------------------------------------
                            */

                            if (
                                ($movie['popularity'] ?? 0) > 50
                            ) {

                                $scores[$movieId]['score'] += 8;
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | APPEARANCE COUNT
                            |--------------------------------------------------------------------------
                            */

                            $scores[$movieId]['appearance']++;
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | MULTI APPEARANCE BOOST
                    |--------------------------------------------------------------------------
                    */

                    foreach ($scores as $movieId => &$movieScore) {

                        if ($movieScore['appearance'] > 1) {

                            $movieScore['score'] += 10;
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | SORT SCORES
                    |--------------------------------------------------------------------------
                    */

                    uasort($scores, function ($a, $b) {

                        return $b['score'] <=> $a['score'];
                    });

                    /*
                    |--------------------------------------------------------------------------
                    | FINAL FORMAT
                    |--------------------------------------------------------------------------
                    */

                    return collect($scores)
                        ->take(8)
                        ->map(function ($item) {

                            $movie = $item['data'];

                            return [

                                'id' => $movie['id'],

                                'judul' => $movie['title'] ?? 'Unknown',

                                'tahun_rilis' => isset($movie['release_date'])
                                    ? substr($movie['release_date'], 0, 4)
                                    : 'N/A',

                                'rating' => $movie['vote_average'] ?? 0,

                                'score' => round(
                                    $item['score'],
                                    1
                                ),

                                'poster_url' => $movie['poster_path']
                                    ? 'https://image.tmdb.org/t/p/w300' . $movie['poster_path']
                                    : null,
                            ];
                        })
                        ->values()
                        ->toArray();
                }
            );

        } catch (\Exception $e) {

            \Log::error(
                'Advanced Recommendation Error: ' .
                $e->getMessage()
            );

            $this->recommendedMovies = [];
        }

        $this->loading = false;
    }

    /*
    |--------------------------------------------------------------------------
    | REFRESH AFTER LIKE
    |--------------------------------------------------------------------------
    */

    #[On('likeToggled')]
    public function refreshRecommendations()
    {
        $user = Auth::user();

        if ($user) {

            Cache::forget(
                "recommendations.user.{$user->id}"
            );
        }

        $this->fetchRecommendations();
    }

    public function render()
    {
        return view('livewire.recommended-movies');
    }
}