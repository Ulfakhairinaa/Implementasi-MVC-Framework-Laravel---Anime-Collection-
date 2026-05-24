<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $fillable = [
        'judul', 'genre_id', 'studio_id',
        'episode', 'rating', 'sinopsis',
        'tahun_rilis', 'gambar',
    ];

    // Relasi: anime milik satu genre
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // Relasi: anime milik satu studio
    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}




