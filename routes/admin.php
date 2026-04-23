<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\Admin\KelurahanController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KataTokohController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:super-admin|admin|umkm-ikm'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/categories/quick-store', [CategoryController::class, 'quickStore'])->name('categories.quick-store');
    Route::get('/umkm/kecamatan/{kecamatan}/kelurahans', [UmkmController::class, 'kelurahanByKecamatan'])->name('umkm.kelurahan-by-kecamatan');

    Route::middleware('role:super-admin|admin')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        Route::resource('/categories', CategoryController::class);
        Route::post('/menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
        Route::resource('/menus', MenuController::class);
        Route::resource('/sliders', SliderController::class);
        Route::resource('/partners', PartnerController::class);
        Route::resource('/sponsors', \App\Http\Controllers\Admin\SponsorController::class);
        Route::resource('/kata-tokoh', KataTokohController::class);
        Route::post('/kata-tokoh/{kataTokoh}/toggle', [\App\Http\Controllers\Admin\KataTokohController::class, 'toggle'])->name('kata-tokoh.toggle');
        Route::resource('/news', \App\Http\Controllers\Admin\NewsController::class);
        Route::post('/news/{news}/publish', [\App\Http\Controllers\Admin\NewsController::class, 'publish'])->name('news.publish');
        Route::resource('/pages', \App\Http\Controllers\Admin\PageController::class);
        Route::resource('/galleries', \App\Http\Controllers\Admin\GalleryController::class);
        Route::delete('/galleries/{gallery}/images/{image}', [\App\Http\Controllers\Admin\GalleryController::class, 'destroyImage'])->name('galleries.images.destroy');
        Route::post('/galleries/{gallery}/add-images', [\App\Http\Controllers\Admin\GalleryController::class, 'addImages'])->name('galleries.add-images');
        Route::resource('/users', UserController::class);
        Route::resource('/kecamatans', KecamatanController::class);
        Route::get('/kecamatans/{kecamatan}/kelurahans', [KecamatanController::class, 'kelurahans'])->name('kecamatans.kelurahans');
        Route::resource('/kelurahans', KelurahanController::class);
        Route::post('/kelurahans-ajax', [KelurahanController::class, 'ajaxStore'])->name('kelurahans.ajax-store');
        Route::put('/kelurahans-ajax/{kelurahan}', [KelurahanController::class, 'ajaxUpdate'])->name('kelurahans.ajax-update');
        Route::delete('/kelurahans-ajax/{kelurahan}', [KelurahanController::class, 'ajaxDestroy'])->name('kelurahans.ajax-destroy');
    });

    Route::resource('/umkm', UmkmController::class);
    Route::post('/umkm/{umkm}/approve', [UmkmController::class, 'approve'])->name('umkm.approve');
    Route::post('/umkm/{umkm}/reject', [UmkmController::class, 'reject'])->name('umkm.reject');

    Route::resource('/products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('/products/{product}/featured', [\App\Http\Controllers\Admin\ProductController::class, 'featured'])->name('products.featured');
    Route::post('/products/{product}/approve', [\App\Http\Controllers\Admin\ProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{product}/reject', [\App\Http\Controllers\Admin\ProductController::class, 'reject'])->name('products.reject');
    Route::delete('/products/{product}/images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('products.images.destroy');
});