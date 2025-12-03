<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NieuwsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\RankedController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Nieuws routes (publiek toegankelijk)
Route::get('/nieuws', [NieuwsController::class, 'index'])->name('nieuws.index');
Route::get('/nieuws/{nieuws}', [NieuwsController::class, 'show'])->name('nieuws.show');

// FAQ routes (publiek toegankelijk)
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Ranked systeem routes (publiek toegankelijk)
Route::get('/ranked', [RankedController::class, 'index'])->name('ranked.index');

// Contact routes (publiek toegankelijk)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Players routes (publiek toegankelijk - iedereen kan spelers zoeken en bekijken)
Route::prefix('players')->name('players.')->group(function () {
    Route::get('/', [PlayersController::class, 'index'])->name('index');
    Route::get('/{user}', [PlayersController::class, 'show'])->name('show');
});

// Tournament routes (publiek toegankelijk)
Route::prefix('tournaments')->name('tournaments.')->group(function () {
    Route::get('/', [TournamentController::class, 'index'])->name('index');
    Route::get('/{tournament}', [TournamentController::class, 'show'])->name('show');

    // Registratie routes (vereisen authenticatie)
    Route::middleware('auth')->group(function () {
        Route::post('/{tournament}/register', [TournamentController::class, 'register'])->name('register');
        Route::post('/{tournament}/unregister', [TournamentController::class, 'unregister'])->name('unregister');
    });
});

// Storage route for serving uploaded files (fallback if storage:link doesn't work)
Route::get('/storage/{path}', [StorageController::class, 'serve'])
    ->where('path', '.*')
    ->name('storage.serve');

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

// Admin routes (alleen voor admins)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    // Gebruikers beheer
    Route::get('/users', [\App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [\App\Http\Controllers\Admin\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::post('/users/{user}/toggle-admin', [\App\Http\Controllers\Admin\AdminController::class, 'toggleAdmin'])->name('users.toggle-admin');

    // Nieuws beheer
    Route::get('/nieuws', [\App\Http\Controllers\Admin\AdminController::class, 'nieuws'])->name('nieuws');
    Route::get('/nieuws/create', [\App\Http\Controllers\Admin\AdminController::class, 'createNieuws'])->name('nieuws.create');
    Route::post('/nieuws', [\App\Http\Controllers\Admin\AdminController::class, 'storeNieuws'])->name('nieuws.store');
    Route::get('/nieuws/{nieuws}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editNieuws'])->name('nieuws.edit');
    Route::put('/nieuws/{nieuws}', [\App\Http\Controllers\Admin\AdminController::class, 'updateNieuws'])->name('nieuws.update');
    Route::delete('/nieuws/{nieuws}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyNieuws'])->name('nieuws.destroy');

    // FAQ Categorieën beheer
    Route::get('/faq/categories', [\App\Http\Controllers\Admin\AdminController::class, 'faqCategories'])->name('faq.categories');
    Route::get('/faq/categories/create', [\App\Http\Controllers\Admin\AdminController::class, 'createFaqCategory'])->name('faq.categories.create');
    Route::post('/faq/categories', [\App\Http\Controllers\Admin\AdminController::class, 'storeFaqCategory'])->name('faq.categories.store');
    Route::get('/faq/categories/{category}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editFaqCategory'])->name('faq.categories.edit');
    Route::put('/faq/categories/{category}', [\App\Http\Controllers\Admin\AdminController::class, 'updateFaqCategory'])->name('faq.categories.update');
    Route::delete('/faq/categories/{category}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyFaqCategory'])->name('faq.categories.destroy');

    // FAQ Items beheer
    Route::get('/faq/items', [\App\Http\Controllers\Admin\AdminController::class, 'faqItems'])->name('faq.items');
    Route::get('/faq/items/create', [\App\Http\Controllers\Admin\AdminController::class, 'createFaqItem'])->name('faq.items.create');
    Route::post('/faq/items', [\App\Http\Controllers\Admin\AdminController::class, 'storeFaqItem'])->name('faq.items.store');
    Route::get('/faq/items/{item}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editFaqItem'])->name('faq.items.edit');
    Route::put('/faq/items/{item}', [\App\Http\Controllers\Admin\AdminController::class, 'updateFaqItem'])->name('faq.items.update');
    Route::delete('/faq/items/{item}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyFaqItem'])->name('faq.items.destroy');

    // Contact berichten
    Route::get('/contact', [\App\Http\Controllers\Admin\AdminController::class, 'contactMessages'])->name('contact.messages');
    Route::get('/contact/{message}', [\App\Http\Controllers\Admin\AdminController::class, 'showContactMessage'])->name('contact.show');
    Route::post('/contact/{message}/toggle-read', [\App\Http\Controllers\Admin\AdminController::class, 'toggleReadStatus'])->name('contact.toggle-read');
    Route::delete('/contact/{message}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyContactMessage'])->name('contact.destroy');
    Route::post('/contact/mark-all-read', [\App\Http\Controllers\Admin\AdminController::class, 'markAllAsRead'])->name('contact.mark-all-read');

    // Tournament beheer
    Route::resource('tournaments', \App\Http\Controllers\Admin\TournamentController::class);
    Route::get('/tournaments/{tournament}/participants', [\App\Http\Controllers\Admin\TournamentController::class, 'participants'])->name('tournaments.participants');
});
