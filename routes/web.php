<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaintingImageController;
use App\Http\Controllers\PaintingListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\Paintings\PaintingController;

Route::controller(PaintingController::class)->prefix('paintings')->group(function () {
    Route::get('/', 'index');
});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');

Route::get('/independent-artists-paintings/independent-artwork', [PaintingListController::class, 'explore'])->name('paintings.explore');
Route::get('/independent-artists-paintings/search', [PaintingListController::class, 'search'])->name('paintings.search');
Route::get('/independent-artists-paintings/{category_slug}', [PaintingListController::class, 'explore'])->name('paintings.list');
Route::get('/independent-artists-paintings/{category_slug}/{painting_slug}', [PaintingController::class, 'show'])->name('paintings.show');
Route::get('/independent-artists', [ArtistController::class, 'index'])->name('artist.index');
Route::get('/independent-artists/{artist_slug}', [ArtistController::class, 'show'])->name('artist.show');
Route::get('/paintings/favorite/{painting_slug}', [PaintingController::class, 'favorite'])->name('paintings.favorite');

Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/auth/facebook', [FacebookController::class, 'redirect'])->name('facebook.redirect');
Route::get('/auth/facebook/callback', [FacebookController::class, 'callback'])->name('facebook.callback');

Route::middleware('auth')->group(function () {
    Route::get('/member/{id}', [MemberController::class, 'member'])->name('member.profile');
    Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::get('/member/{id}/profile', [MemberController::class, 'profile'])->name('member.profile');
    Route::get('/member/{id}/account-settings', [MemberController::class, 'settings'])->name('member.settings');
    Route::get('/member/{id}/privacy-center', [MemberController::class, 'privacy'])->name('member.privacy');
    Route::get('/member/{id}/orders', [MemberController::class, 'orders'])->name('member.orders');
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::put('/member/{id}/updatePrivacy', [MemberController::class, 'updatePrivacy'])->name('member.updatePrivacy');
    Route::get('/member/{id}/favorites', [MemberController::class, 'favorites'])->name('member.favorites');
    Route::get('/member/{id}/messages', [MessageController::class, 'index'])->name('member.messages');
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('/painting/new', [PaintingController::class, 'new'])->name('item.new');
    Route::post('/painting/new', [PaintingController::class, 'store'])->name('item.store');
    Route::get('/painting/{id}/edit', [PaintingController::class, 'edit'])->name('item.edit');
    Route::put('/painting/{painting}/edit', [PaintingController::class, 'update'])->name('item.update');
    Route::delete('/painting/image/{image}', [PaintingImageController::class, 'destroy'])->name('painting.image.delete');

    Route::post('/users/{user}/follow', [FollowController::class, 'toggle'])->name('users.follow');
    Route::post('/paintings/{painting}/favorite', [FavoriteController::class, 'toggle'])->name('paintings.favorite');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    // Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/send', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/paintings/{painting}/ask', [MessageController::class, 'ask'])->name('messages.ask');
});

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
