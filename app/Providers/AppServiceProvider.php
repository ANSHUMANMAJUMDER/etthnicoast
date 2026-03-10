<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\TabCategories;
use Illuminate\Support\Facades\View;

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
          View::composer('frontend.layouts.master', function ($view) {

        $categories = TabCategories::with(['subCategories' => function ($q) {
                            $q->where('is_active', true);
                        }])
                        ->where('is_active', true)
                        ->get();

        $view->with('navCategories', $categories);
    });
        Paginator::useBootstrapFive();
    }
}
