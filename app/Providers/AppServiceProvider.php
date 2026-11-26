<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menu frontend di-cache ke file (bukan database) supaya tidak menambah koneksi MySQL per request.
        View::composer('layouts.frontend', function ($view) {
            $view->with('frontendMenus', Cache::store('file')->rememberForever('frontend_menus', fn () => Menu::where('status', 'active')
                ->whereNull('parent_id')
                ->with('children')
                ->orderBy('order')
                ->get()));
        });
    }
}
