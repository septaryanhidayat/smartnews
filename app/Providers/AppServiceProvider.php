<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

if (!enum_exists('SortDirection')) {
    enum SortDirection
    {
        case Ascending;
        case Descending;
    }
}

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
        //
    }
}
