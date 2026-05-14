<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_movie_likes', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->foreignId('film_id')
                  ->constrained('films')
                  ->onDelete('cascade');
            
            $table->boolean('is_liked')->default(true);
            $table->timestamps();
            
            // Ensure unique user-film combination
            $table->unique(['user_id', 'film_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_movie_likes');
    }
};
