<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Paintings\PaintingController;

Route::get('/', [PaintingController::class, 'home']);
Route::get('about-us', [PaintingController::class, 'aboutUs']);
Route::get('painting', [PaintingController::class, 'index']);
Route::middleware('auth')->group(function () {
    Route::get('member/{id}', [PaintingController::class, 'member'])->name('member.profile');
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
