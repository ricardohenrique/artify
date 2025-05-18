<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Paintings\PaintingController;

Route::get('/', [PaintingController::class, 'home']);
Route::get('about-us', [PaintingController::class, 'about-us'])->name('about-us');
Route::get('painting', [PaintingController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('member/{id}', [PaintingController::class, 'member'])->name('member.profile');
    Route::get('painting/new', [PaintingController::class, 'new'])->name('item.new');
    Route::post('painting/new', [PaintingController::class, 'store'])->name('item.store');
    Route::get('painting/{id}/edit', [PaintingController::class, 'edit'])->name('item.edit');
    Route::get('dashboard', [PaintingController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
