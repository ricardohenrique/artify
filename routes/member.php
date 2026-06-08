<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Paintings\PaintingController;
use App\Http\Controllers\Paintings\PaintingImageController;

Route::middleware('auth')->group(function () {
    Route::get('/member/{id}', [MemberController::class, 'member'])->name('member.show');
    Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::get('/member/{id}/profile', [MemberController::class, 'profile'])->name('member.profile');
    Route::get('/member/{id}/account-settings', [MemberController::class, 'settings'])->name('member.settings');
    Route::get('/member/{id}/privacy-center', [MemberController::class, 'privacy'])->name('member.privacy');
    Route::get('/member/{id}/dashboard', [MemberController::class, 'memberDashboard'])->name('member.dashboard');
    Route::get('/member/{id}/orders', [MemberController::class, 'orders'])->name('member.orders');
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::put('/member/{id}/updatePrivacy', [MemberController::class, 'updatePrivacy'])->name('member.privacy.update');
    Route::get('/member/{id}/favorites', [MemberController::class, 'favorites'])->name('member.favorites');
    Route::get('/member/{id}/messages', [MessageController::class, 'index'])->name('member.messages');
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');

    Route::get('/painting/new', [PaintingController::class, 'new'])->name('painting.new');
    Route::get('/painting/create', [PaintingController::class, 'create'])->name('painting.create');
    Route::post('/painting/new', [PaintingController::class, 'store'])->name('painting.store');
    Route::post('/painting/add', [PaintingController::class, 'add'])->name('painting.add');
    Route::get('/painting/{id}/edit', [PaintingController::class, 'edit'])->name('painting.edit');
    Route::get('/painting/{id}/update', [PaintingController::class, 'editPainting'])->name('painting.edit-details');
    Route::put('/painting/{painting}/edit', [PaintingController::class, 'update'])->name('painting.update');
    Route::put('/painting/{painting}/update', [PaintingController::class, 'updatePainting'])->name('painting.update-details');
    Route::delete('/painting/image/{image}', [PaintingImageController::class, 'destroy'])->name('painting.image.delete');

    Route::post('/users/{user}/follow', [FollowController::class, 'toggle'])->name('users.follow');
    Route::post('/paintings/{painting}/favorite', [FavoriteController::class, 'toggle'])->name('paintings.favorite');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/send', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/paintings/{painting}/ask', [MessageController::class, 'ask'])->name('messages.ask');
});
