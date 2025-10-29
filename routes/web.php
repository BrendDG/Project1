<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NieuwsController;

Route::get('/', function () {
    return view('home');
});

// Nieuws routes (publiek toegankelijk)
Route::get('/nieuws', [NieuwsController::class, 'index'])->name('nieuws.index');
Route::get('/nieuws/{nieuws}', [NieuwsController::class, 'show'])->name('nieuws.show');
