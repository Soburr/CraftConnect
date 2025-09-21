<?php

use Illuminate\Support\Facades\Route;

/**General Homepage */
Route::get('/', static fn()=> view('homepage'))->name('homepage');

require __DIR__.'/auth.php';
