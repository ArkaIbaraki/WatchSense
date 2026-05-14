<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'film_id',
        'user_id',
        'rating',
        'komentar',
        'dibuat_pada',
    ];

    protected $casts = [
        'rating' => 'integer',
        'dibuat_pada' => 'datetime',
    ];

    /**
     * Get the film being reviewed
     */
    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    /**
     * Get the user who wrote the review
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
