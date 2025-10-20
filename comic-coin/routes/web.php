<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\PageController;

use App\Http\Controllers\WalletController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::resource('comics', ComicController::class);
Route::post('comics/{comic}/favorite', [ComicController::class, 'toggleFavorite'])->name('comics.toggleFavorite')->middleware('auth');

// Chapter Routes
// Use non-nested routes for create/store to match forms that send comic_id in the body.
Route::resource('chapters', ChapterController::class)->only([
    'create', 'store', 'show', 'edit', 'update', 'destroy'
]);

// Purchase Route
Route::post('chapters/{chapter}/purchase', [PurchaseController::class, 'store'])->name('chapters.purchase')->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Wallet Top-up Routes
    Route::get('/wallet/topup', [App\Http\Controllers\WalletController::class, 'showTopupForm'])->name('wallet.topup');
    Route::post('/wallet/topup', [App\Http\Controllers\WalletController::class, 'processTopup'])->name('wallet.processTopup');
});

require __DIR__.'/auth.php';

Route::get('language/{locale}', [LocalizationController::class, 'switch'])->name('language.switch');

Route::resource('banners', App\Http\Controllers\BannerController::class)->middleware(['auth', 'admin']);

// Admin Wallet Management
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
    Route::post('/admin/wallet/add', [App\HttpControllers\WalletController::class, 'addCoins'])->name('wallet.add');
});
