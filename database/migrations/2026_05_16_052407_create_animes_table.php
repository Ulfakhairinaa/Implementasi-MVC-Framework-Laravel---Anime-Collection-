<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('genre');
            $table->integer('episode');
            $table->decimal('rating', 3, 1);
            $table->text('sinopsis')->nullable();
            $table->string('studio')->nullable();
            $table->year('tahun_rilis')->nullable();
            $table->string('gambar')->nullable(); // path gambar di storage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};