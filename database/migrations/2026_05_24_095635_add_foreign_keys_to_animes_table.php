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
        Schema::table('animes', function (Blueprint $table) {
            $table->foreignId('genre_id')->nullable()->constrained('genres')->nullOnDelete();
            $table->foreignId('studio_id')->nullable()->constrained('studios')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animes', function (Blueprint $table) {
            $table->dropForeign(['genre_id']);
            $table->dropForeign(['studio_id']);
            $table->dropColumn(['genre_id', 'studio_id']);
        });
    }
};
