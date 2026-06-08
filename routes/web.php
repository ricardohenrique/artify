<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkController;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/go/{slug}', [LinkController::class, 'redirect'])->name('link.redirect');

require __DIR__.'/pages.php';
require __DIR__.'/paintings.php';
require __DIR__.'/artists.php';
require __DIR__.'/oauth.php';
require __DIR__.'/member.php';
require __DIR__.'/auth.php';
