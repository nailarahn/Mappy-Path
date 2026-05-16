<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');

// Dashboard (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/roadmap', [DashboardController::class, 'roadmap'])->name('roadmap');
    Route::get('/target', [DashboardController::class, 'target'])->name('target');
    Route::get('/progress', [DashboardController::class, 'progress'])->name('progress');
});
