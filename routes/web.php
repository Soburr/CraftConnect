<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**General Homepage */
Route::get('/', static fn()=> view('homepage'))->name('homepage');

/**Authentication */
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', function() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::get('/artisan/dashboard', [App\Http\Controllers\Artisan\DashboardController::class, 'viewDashboard'])
               ->name('artisan.dashboard')->middleware(['auth', 'role:artisan']);


Route::middleware(['auth', 'role:client'])->prefix('client/dashboard')->group(function () {
    Route::get('/', [App\Http\Controllers\Client\DashboardController::class, 'viewDashboard'])->name('client.dashboard');
    Route::get('/find-artisan', [App\Http\Controllers\Client\ArtisanController::class, 'artisan'])->name('client.artisan');
    Route::get('/bookings', [App\Http\Controllers\Client\BookingsController::class, 'booking'])->name('client.bookings');
    Route::get('/profile', [App\Http\Controllers\Client\ProfileController::class, 'profile'])->name('client.profile');
    Route::post('/profile', [App\Http\Controllers\Client\ProfileController::class, 'store'])->name('client.store');
    Route::get('/reviews', [App\Http\Controllers\Client\ReviewController::class, 'review'])->name('client.reviews');
});

// require __DIR__.'/auth.php';
