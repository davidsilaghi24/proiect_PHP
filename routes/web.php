<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JournalistController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController; // Adaugă acest rând pentru a folosi DashboardController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rute pentru autentificare și articole
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute pentru jurnaliști
    Route::get('/journalist/{journalist_id}/articles', [JournalistController::class, 'showArticles'])->name('journalist.articles');
    Route::get('/journalist/articles/{article}/edit', [JournalistController::class, 'editArticle'])->name('journalist.articles.edit');
    Route::get('/journalist/{journalist}/profile', [JournalistController::class, 'showProfile'])->name('journalist.profile');
    Route::patch('/journalist/{journalist}/profile', [JournalistController::class, 'updateProfile'])->name('journalist.profile.update');

    // Rute pentru articole
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::patch('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    // Această rută acum va funcționa pentru că nu există o altă definiție a rutei '/dashboard' deasupra ei
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});

require __DIR__.'/auth.php';
