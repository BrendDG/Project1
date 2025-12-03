<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NieuwsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Nieuws routes (publiek toegankelijk)
Route::get('/nieuws', [NieuwsController::class, 'index'])->name('nieuws.index');
Route::get('/nieuws/{nieuws}', [NieuwsController::class, 'show'])->name('nieuws.show');

// Comment routes (vereisen authenticatie)
Route::middleware('auth')->group(function () {
    Route::post('/nieuws/{nieuws}/comments', [NieuwsController::class, 'storeComment'])->name('nieuws.comments.store');
    Route::delete('/nieuws/{nieuws}/comments/{comment}', [NieuwsController::class, 'destroyComment'])->name('nieuws.comments.destroy');
});

// FAQ routes (publiek toegankelijk)
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Contact routes (publiek toegankelijk)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// Logout route (authenticated users only)
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Profile routes
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show'); // Public profile view
Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit own profile
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update'); // Update own profile
});
