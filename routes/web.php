<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect()->route('login'));
    Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users CRUD
    Route::get('/users',          [UserController::class, 'index'])->name('users.index');
    Route::post('/users',         [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}',   [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',[UserController::class, 'destroy'])->name('users.destroy');

    // Anime CRUD
    Route::get('/anime',           [AnimeController::class, 'index'])->name('anime.index');
    Route::post('/anime',          [AnimeController::class, 'store'])->name('anime.store');
    Route::put('/anime/{anime}',   [AnimeController::class, 'update'])->name('anime.update');
    Route::delete('/anime/{anime}',[AnimeController::class, 'destroy'])->name('anime.destroy');

    // Profile
    Route::get('/profile',  [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile',  [ProfileController::class, 'update'])->name('profile.update');
});
