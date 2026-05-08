<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('film_id')
                  ->constrained('films')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');

            $table->integer('rating');
            $table->text('komentar');
            $table->dateTime('dibuat_pada');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};