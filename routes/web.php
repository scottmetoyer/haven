<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AffiliateSiteController;
use App\Http\Controllers\Admin\ReviewGenerationSettingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public article routes
Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Legal pages
Route::get('/privacy', [PageController::class, 'privacy'])->name('page.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('page.terms');
Route::get('/dmca', [PageController::class, 'dmca'])->name('page.dmca');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('page.disclaimer');
Route::get('/contact', [PageController::class, 'contact'])->name('page.contact');

// Authenticated routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('articles', AdminArticleController::class);
    Route::resource('affiliate-sites', AffiliateSiteController::class);
    Route::post('affiliate-sites/{affiliate_site}/scrape', [AffiliateSiteController::class, 'scrape'])->name('affiliate-sites.scrape');

    Route::get('review-settings', [ReviewGenerationSettingController::class, 'index'])->name('review-settings.index');
    Route::post('review-settings', [ReviewGenerationSettingController::class, 'update'])->name('review-settings.update');

    Route::get('scraped-content', function () {
        return view('admin.scraped-content.review');
    })->name('scraped-content.index');

    Route::get('scraped-content/review', function () {
        return view('admin.scraped-content.review');
    })->name('scraped-content.review');
});

require __DIR__.'/auth.php';
