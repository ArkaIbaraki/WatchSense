<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    protected $fillable = [
        'judul',
        'tahun_rilis',
        'durasi_menit',
        'rating',
        'deskripsi',
        'bahasa',
        'director_id',
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
}
