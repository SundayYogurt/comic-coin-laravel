<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\PageController;

use App\Http\Controllers\WalletController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/become-translator', [ProfileController::class, 'becomeTranslator'])->name('profile.becomeTranslator');

    // Comics (all authenticated users)
    Route::get('/comics', [ComicController::class, 'index'])->name('comics.index');

    // Toggle Favorite (only one declaration)
    Route::post('/comics/{comic}/favorite', [ComicController::class, 'toggleFavorite'])
        ->name('comics.toggleFavorite');

    // Chapters (view & purchase)
    Route::get('/chapters/{chapter}', [ChapterController::class, 'show'])->name('chapters.show');
    Route::post('/chapters/{chapter}/purchase', [PurchaseController::class, 'store'])->name('chapters.purchase');


    // Translator & Admin routes
    Route::middleware('translator')->group(function () {
        // Comics CRUD
        Route::get('/comics/create', [ComicController::class, 'create'])->name('comics.create');
        Route::post('/comics', [ComicController::class, 'store'])->name('comics.store');
        Route::get('/comics/{comic}/edit', [ComicController::class, 'edit'])->name('comics.edit');
        Route::put('/comics/{comic}', [ComicController::class, 'update'])->name('comics.update');
        Route::delete('/comics/{comic}', [ComicController::class, 'destroy'])->name('comics.destroy');

        // Chapters CRUD
        Route::get('/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
        Route::post('/chapters', [ChapterController::class, 'store'])->name('chapters.store');
        Route::get('/chapters/{chapter}/edit', [ChapterController::class, 'edit'])->name('chapters.edit');
        Route::put('/chapters/{chapter}', [ChapterController::class, 'update'])->name('chapters.update');
        Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');

        // Add pages to chapter
        Route::post('/chapters/{chapter}/add-pages', [ChapterController::class, 'addPages'])->name('chapters.addPages');
        Route::delete('/chapters/{chapter}/delete-all-pages', [ChapterController::class, 'destroyAllPages'])->name('chapters.destroyAllPages');

        // Pages CRUD
        Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
    });

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        // Wallet admin
        Route::get('wallet', [WalletController::class, 'index'])->name('wallet.index');
        Route::post('wallet/add', [WalletController::class, 'addCoins'])->name('wallet.add');
    });

    // This MUST be last
    Route::get('/comics/{comic}', [ComicController::class, 'show'])->name('comics.show');
});

require __DIR__ . '/auth.php';