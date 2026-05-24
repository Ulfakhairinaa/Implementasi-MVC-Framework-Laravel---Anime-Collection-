<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['nama'];

    // Relasi: satu genre punya banyak anime
    public function animes()
    {
        return $this->hasMany(Anime::class);
    }
}


