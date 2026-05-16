<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

Route::get('/', function () {
    return redirect()->route('anime.index');
});

Route::resource('anime', AnimeController::class);