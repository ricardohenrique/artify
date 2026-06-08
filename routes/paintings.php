<?php

use App\Http\Controllers\Paintings\PaintingController;
use App\Http\Controllers\Paintings\PaintingListController;

Route::get('/independent-artists-paintings/independent-artwork', [PaintingListController::class, 'explore'])->name('paintings.explore');
Route::get('/independent-artists-paintings/search', [PaintingListController::class, 'search'])->name('paintings.search');
Route::get('/independent-artists-paintings/{category_slug}', [PaintingListController::class, 'explore'])->name('paintings.list');
Route::get('/independent-artists-paintings/{category_slug}/{painting_slug}', [PaintingController::class, 'show'])->name('paintings.show');
Route::get('/paintings/favorite/{painting_slug}', [PaintingController::class, 'favorite'])->name('painting.favorite.page');
