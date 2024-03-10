<?php

namespace App\Providers;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

    public function boot()
{
    View::composer('*', function ($view) {
        $productsCount = Product::where('stock', '<=', 5)->count();
        $lowStockProducts = Product::where('stock', '<=', 5)->get();
        $view->with('productsCount', $productsCount)->with('lowStockProducts', $lowStockProducts);
    });
}
    
}
