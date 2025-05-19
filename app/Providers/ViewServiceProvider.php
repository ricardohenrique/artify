<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $topCategories = Category::withCount('paintings')
                ->orderByDesc('paintings_count')
                ->take(5)
                ->get();

            $view->with('headerCategories', $topCategories);
        });
    }
}
