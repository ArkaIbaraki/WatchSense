<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_movie_likes', function (Blueprint $table) {

            // Hapus foreign key film_id
            $table->dropForeign(['film_id']);

        });
    }

    public function down(): void
    {
        Schema::table('user_movie_likes', function (Blueprint $table) {

            // Kembalikan foreign key
            $table->foreign('film_id')
                ->references('id')
                ->on('films')
                ->onDelete('cascade');

        });
    }
};