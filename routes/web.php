<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/produk', [HomeController::class, 'produk'])->name('produk');
Route::get('/produk/{product}', [HomeController::class, 'produkDetail'])->name('produk.detail');

Route::get('/jasa', [HomeController::class, 'jasa'])->name('jasa');
Route::get('/jasa/{product}', [HomeController::class, 'jasaDetail'])->name('jasa.detail');

Route::get('/umkm/{umkm}', [HomeController::class, 'umkm'])->name('umkm.detail');

Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{news}', [HomeController::class, 'beritaDetail'])->name('berita.detail');

Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');

Route::get('/page/{page}', [HomeController::class, 'page'])->name('page');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';