<?php

use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\ArtisanManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\ClientManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SkillManagementController;
use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**General Homepage */
Route::get('/', [HomepageController::class, 'index'])->name('homepage');

/**Authentication */
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::post('/testimonials', [\App\Http\Controllers\TestimonialController::class, 'store'])->name('testimonial.store');
Route::get('/testimonials', [\App\Http\Controllers\TestimonialController::class, 'getAll'])->name('testimonial.get');

Route::middleware(['auth', 'role:client'])->prefix('client/dashboard')->group(function () {
    Route::get('/', [App\Http\Controllers\Client\DashboardController::class, 'viewDashboard'])->name('client.dashboard');
    Route::get('/find-artisan', [App\Http\Controllers\Client\ArtisanController::class, 'index'])->name('client.artisan');
    Route::get('/profile', [App\Http\Controllers\Client\ProfileController::class, 'profile'])->name('client.profile');
    Route::post('/profile', [App\Http\Controllers\Client\ProfileController::class, 'store'])->name('client.store');
    Route::get('/reviews', [App\Http\Controllers\Client\ReviewController::class, 'review'])->name('client.reviews');
    Route::get('/change-password', [App\Http\Controllers\Client\PasswordChangeController::class, 'change'])->name('client.password.edit');
    Route::put('/change-password', [App\Http\Controllers\Client\PasswordChangeController::class, 'update'])->name('client.password.update');
});

Route::middleware(['auth', 'role:client'])->prefix('client/dashboard/bookings')->group(function () {
    Route::get('/', [App\Http\Controllers\Client\BookingsController::class, 'booking'])->name('client.bookings');
    Route::post('/{booking}/complete', [App\Http\Controllers\Client\BookingsController::class, 'markComplete']);
    Route::post('/{booking}/cancel', [App\Http\Controllers\Client\BookingsController::class, 'cancel']);
    Route::post('/{booking}/rebook', [App\Http\Controllers\Client\BookingsController::class, 'rebook']);
    Route::post('/{booking}/review', [App\Http\Controllers\Client\BookingsController::class, 'review']);
});

Route::middleware(['auth', 'role:client'])->prefix('client/dashboard')->group(function () {
    Route::post('/book-artisan/{artisan}', [App\Http\Controllers\Client\BookingsController::class, 'store'])
        ->name('client.book-artisan');
});

Route::post('/book-artisan/{artisan}', [App\Http\Controllers\Client\ArtisanController::class, 'bookArtisan'])
    ->name('client.book-artisan');



Route::middleware(['auth', 'role:artisan'])->prefix('artisan/dashboard')->group(function () {
    Route::get('/', [App\Http\Controllers\Artisan\DashboardController::class, 'viewDashboard'])->name('artisan.dashboard');
    Route::get('/profile', [App\Http\Controllers\Artisan\ProfileController::class, 'profile'])->name('artisan.profile');
    Route::post('/profile', [App\Http\Controllers\Artisan\ProfileController::class, 'store'])->name('artisan.store');
    Route::get('/bookings', [App\Http\Controllers\Artisan\BookingsController::class, 'booking'])->name('artisan.bookings');
    Route::get('/reviews', [App\Http\Controllers\Artisan\ReviewsController::class, 'artisanReviews'])->name('artisan.reviews');
    Route::get('/change-password', [App\Http\Controllers\Artisan\PasswordChangeController::class, 'change'])->name('password.edit');
    Route::put('/change-password', [App\Http\Controllers\Artisan\PasswordChangeController::class, 'update'])->name('password.update');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/sign-in', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/sign-in', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Artisan management
        Route::get('/artisans', [ArtisanManagementController::class, 'index'])->name('artisans.index');
        Route::get('/artisans/{id}', [ArtisanManagementController::class, 'show'])->name('artisans.show');
        Route::post('/artisans/{id}/suspend', [ArtisanManagementController::class, 'suspend'])->name('artisans.suspend');
        Route::post('/artisans/{id}/block', [ArtisanManagementController::class, 'block'])->name('artisans.block');
        Route::delete('/artisans/{id}', [ArtisanManagementController::class, 'destroy'])->name('artisans.destroy');

        // Client management
        Route::get('/clients', [ClientManagementController::class, 'index'])->name('clients.index');
        Route::get('/clients/{id}', [ClientManagementController::class, 'show'])->name('clients.show');
        Route::delete('/clients/{id}', [ClientManagementController::class, 'destroy'])->name('clients.destroy');

        // Category management
        Route::get('/categories', [CategoryManagementController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryManagementController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [CategoryManagementController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryManagementController::class, 'destroy'])->name('categories.destroy');

        // Skill management
        Route::get('/skills', [SkillManagementController::class, 'index'])->name('skills.index');
        Route::post('/skills', [SkillManagementController::class, 'store'])->name('skills.store');
        Route::put('/skills/{id}', [SkillManagementController::class, 'update'])->name('skills.update');
        Route::delete('/skills/{id}', [SkillManagementController::class, 'destroy'])->name('skills.destroy');

        // Testimonials
        Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
        Route::post('/testimonials/{id}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');
        Route::post('/testimonials/{id}/reject', [AdminTestimonialController::class, 'reject'])->name('testimonials.reject');

    });
});


// require __DIR__.'/auth.php';
