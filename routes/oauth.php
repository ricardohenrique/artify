<?php

use App\Http\Controllers\Auth\Social\FacebookController;
use App\Http\Controllers\Auth\Social\GoogleController;

Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/auth/facebook', [FacebookController::class, 'redirect'])->name('facebook.redirect');
Route::get('/auth/facebook/callback', [FacebookController::class, 'callback'])->name('facebook.callback');
