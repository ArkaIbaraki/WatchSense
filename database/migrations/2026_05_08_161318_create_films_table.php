<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->integer('tahun_rilis');
            $table->integer('durasi_menit');
            $table->float('rating')->nullable();
            $table->text('deskripsi');
            $table->string('bahasa');
            // $table->string('poster_url')->nullable();
            $table->foreignId('director_id')
                  ->constrained('directors')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};