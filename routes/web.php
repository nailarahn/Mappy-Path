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

// ── DASHBOARD (AUTH REQUIRED) ─────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Roadmap
    Route::get('/roadmap', [DashboardController::class, 'roadmap'])->name('roadmap');
    Route::post('/roadmap/{roadmapId}/enroll', [DashboardController::class, 'enroll'])->name('roadmap.enroll');
    Route::get('/roadmap/{roadmapId}/stage/{stageId}', [DashboardController::class, 'stage'])->name('roadmap.stage');
    Route::post('/roadmap/{roadmapId}/stage/{stageId}/complete', [DashboardController::class, 'completeStage'])->name('roadmap.complete');

    // Target & Progress
    Route::get('/target',   [DashboardController::class, 'target'])->name('target');
    Route::get('/progress', [DashboardController::class, 'progress'])->name('progress');
});