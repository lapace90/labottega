<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;


Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Eventi
Route::get('/eventi', [EventController::class, 'index'])->name('events.index');
Route::get('/eventi/{slug}', [EventController::class, 'show'])->name('events.show');

// Shop
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/categoria/{slug}', [ShopController::class, 'category'])->name('category');
    Route::get('/prodotto/{slug}', [ShopController::class, 'product'])->name('product');
});

// Carrello (AJAX)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('/add', [\App\Http\Controllers\CartController::class, 'add'])->name('add');
    Route::get('/summary', [\App\Http\Controllers\CartController::class, 'summary'])->name('summary');
    Route::patch('/update', [\App\Http\Controllers\CartController::class, 'update'])->name('update');
    Route::delete('/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('clear');
});

// Cookies
Route::get('/cookie-policy', function () {
    return view('pages.cookie-policy');
})->name('cookie-policy');
