<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMovieLike extends Model
{
    protected $fillable = [
        'user_id',
        'film_id',
        'is_liked'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}