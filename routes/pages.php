<?php

use App\Http\Controllers\Pages\StaticPageController;

Route::get('/about-us', [StaticPageController::class, 'aboutUs'])->name('about-us');
Route::get('/privacy-policy', [StaticPageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-conditions', [StaticPageController::class, 'termsConditions'])->name('terms-conditions');
Route::get('/frequently-asked-questions', [StaticPageController::class, 'faq'])->name('faq');
Route::get('/how-artify-works', [StaticPageController::class, 'howArtifyWorks'])->name('how-artify-works');
