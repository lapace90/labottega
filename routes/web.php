<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;


Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Eventi (IT)
Route::get('/eventi', [EventController::class, 'index'])->name('events.index');
Route::get('/eventi/{slug}', [EventController::class, 'show'])->name('events.show');

// Events (EN) — stessi controller, locale diversa
Route::get('/events', [EventController::class, 'index'])
    ->defaults('locale', 'en')
    ->name('events.index.en');
Route::get('/events/{slug}', [EventController::class, 'show'])
    ->defaults('locale', 'en')
    ->name('events.show.en');

// Cookies
Route::get('/cookie-policy', function () {
    return view('pages.cookie-policy');
})->name('cookie-policy');
