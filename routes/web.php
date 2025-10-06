<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/**General Homepage */
Route::get('/', static fn()=> view('homepage'))->name('homepage');

/**Authentication */
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/client/dashboard', [App\Http\Controllers\Client\DashboardController::class, 'viewDashboard'])
               ->name('client.dashboard')->middleware(['auth', 'role:client']);
Route::get('/artisan/dashboard', [App\Http\Controllers\Artisan\DashboardController::class, 'viewDashboard'])
               ->name('artisan.dashboard')->middleware(['auth', 'role:artisan']);

// require __DIR__.'/auth.php';
