<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $fillable = ['nama'];

    // Relasi: satu studio punya banyak anime
    public function animes()
    {
        return $this->hasMany(Anime::class);
    }
}

