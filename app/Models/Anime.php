<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;

    protected $table = 'animes';

    protected $fillable = [
        'judul',
        'genre',
        'episode',
        'rating',
        'sinopsis',
        'studio',
        'tahun_rilis',
        'gambar',
    ];
}