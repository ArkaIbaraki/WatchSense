<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    protected $fillable = [
        'tmdb_id',
        'judul',
        'tahun_rilis',
        'durasi_menit',
        'rating',
        'deskripsi',
        'bahasa',
        'director_id',
        'gambar_url',
        'backdrop_url',
    ];

    protected $casts = [
        'tahun_rilis' => 'integer',
        'durasi_menit' => 'integer',
        'rating' => 'float',
    ];

    /**
     * Get the director of the film
     */
    public function director(): BelongsTo
    {
        return $this->belongsTo(Director::class);
    }

    /**
     * Get all genres for the film
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'film_genre', 'film_id', 'genre_id');
    }

    /**
     * Get all actors in the film
     */
    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'film_actor', 'film_id', 'actor_id');
    }

    /**
     * Get all reviews for the film
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'film_id');
    }

    /**
     * Get all user likes for the film
     */
    public function userLikes(): HasMany
    {
        return $this->hasMany(UserMovieLike::class, 'film_id');
    }

    /**
     * Find film by TMDb ID or create a placeholder
     */
    public static function findOrCreateFromTmdbId($tmdbId, $movieData = null)
    {
        $film = self::where('tmdb_id', $tmdbId)->first();

        if ($film) {
            return $film;
        }

        // Create a new film with TMDb data
        if ($movieData) {
            $film = self::create([
                'tmdb_id' => $tmdbId,
                'judul' => $movieData['title'] ?? 'Unknown',
                'tahun_rilis' => isset($movieData['release_date']) ? (int)substr($movieData['release_date'], 0, 4) : null,
                'durasi_menit' => $movieData['runtime'] ?? 120,
                'director_id' => null,
                'rating' => $movieData['vote_average'] ?? 0,
                'deskripsi' => $movieData['overview'] ?? '',
                'bahasa' => $movieData['original_language'] ?? 'en',
                'gambar_url' => isset($movieData['poster_path']) ? 'https://image.tmdb.org/t/p/w500' . $movieData['poster_path'] : null,
                'backdrop_url' => isset($movieData['backdrop_path']) ? 'https://image.tmdb.org/t/p/w1280' . $movieData['backdrop_path'] : null,
            ]);
        }

        return $film;
    }
}
