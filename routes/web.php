<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NieuwsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('home');
});

// Nieuws routes (publiek toegankelijk)
Route::get('/nieuws', [NieuwsController::class, 'index'])->name('nieuws.index');
Route::get('/nieuws/{nieuws}', [NieuwsController::class, 'show'])->name('nieuws.show');

// FAQ routes (publiek toegankelijk)
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Contact routes (publiek toegankelijk)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
