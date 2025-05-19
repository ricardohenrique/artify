<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaintingImageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Paintings\PaintingController;

Route::get('/', [HomeController::class, 'index']);
Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('painting', [PaintingController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('member/{id}', [MemberController::class, 'member'])->name('member.profile');
    Route::get('dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('painting/new', [PaintingController::class, 'new'])->name('item.new');
    Route::post('painting/new', [PaintingController::class, 'store'])->name('item.store');
    Route::get('painting/{id}/edit', [PaintingController::class, 'edit'])->name('item.edit');
    Route::put('painting/{painting}/edit', [PaintingController::class, 'update'])->name('item.update');
    Route::delete('/painting/image/{image}', [PaintingImageController::class, 'destroy'])->name('painting.image.delete');
});

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
