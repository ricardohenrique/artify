<?php

use App\Http\Controllers\Artists\ArtistController;

Route::get('/independent-artists', [ArtistController::class, 'index'])->name('artist.index');
Route::get('/independent-artists/{artist_slug}', [ArtistController::class, 'show'])->name('artist.show');
