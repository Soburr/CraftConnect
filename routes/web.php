<?php

use Illuminate\Support\Facades\Route;

/**General Homepage */
Route::get('/', static fn()=> view('homepage'))->name('homepage');

Route::get('/test', static fn()=> view('partials.navbar'))->name('navbar');

require __DIR__.'/auth.php';
