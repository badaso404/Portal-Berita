<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicNewsController;

Route::get('/', [PublicNewsController::class, 'index'])->name('home');
Route::get('/news/search', [PublicNewsController::class, 'search'])->name('news.search');
Route::get('/news/{slug}', [PublicNewsController::class, 'show'])->name('news.show');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'total_articles' => \App\Models\Article::count(),
            'published_articles' => \App\Models\Article::where('status', 'published')->count(),
            'categories' => \App\Models\Category::count(),
        ];
        $latestArticles = \App\Models\Article::with('category', 'user')->latest()->take(5)->get();
        
        return view('dashboard', compact('stats', 'latestArticles'));
    })->name('dashboard');

    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    // Route::resource('users', \App\Http\Controllers\Admin\UserController::class); // To be implemented
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
