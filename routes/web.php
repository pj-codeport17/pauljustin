<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProfileController;

// ── Guest routes ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/',        [AuthController::class, 'showLogin']);
    Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [AuthController::class, 'login']);
    Route::get('/register',[AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class,'register']);
});

// ── Logout ───────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── User routes ──────────────────────────────────────────────
Route::middleware(['auth', App\Http\Middleware\UserMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Anime CRUD
    Route::get('/anime',           [AnimeController::class, 'index'])->name('anime.index');
    Route::get('/anime/create',    [AnimeController::class, 'create'])->name('anime.create');
    Route::post('/anime',          [AnimeController::class, 'store'])->name('anime.store');
    Route::get('/anime/{anime}/edit', [AnimeController::class, 'edit'])->name('anime.edit');
    Route::put('/anime/{anime}',   [AnimeController::class, 'update'])->name('anime.update');
    Route::delete('/anime/{anime}',[AnimeController::class, 'destroy'])->name('anime.destroy');

    // Profile
    Route::get('/profile',             [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile',             [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar',     [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Contact
    Route::get('/contact',  [ContactController::class, 'show'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});

// ── Admin routes ─────────────────────────────────────────────
Route::middleware(['auth', App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users management
    Route::get('/users',          [AdminUserController::class, 'index'])->name('users');
    Route::delete('/users/{user}',[AdminUserController::class, 'destroy'])->name('users.destroy');

    // Admin profile
    Route::get('/profile',         [AdminProfileController::class, 'show'])->name('profile');
    Route::put('/profile',         [AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [AdminProfileController::class, 'updateAvatar'])->name('profile.avatar');
});
