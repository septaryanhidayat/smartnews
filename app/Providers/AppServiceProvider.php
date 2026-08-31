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

// Require Helper functions
require_once app_path('Helpers/SettingHelper.php');

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
        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            try {
                $breakingNews = \App\Models\Article::with('category')
                    ->where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take(8)
                    ->get();
                
                $view->with('breakingNews', $breakingNews);

                if (!isset($view->getData()['trendingTags'])) {
                    $trendingTags = \App\Models\Tag::withCount('articles')
                        ->orderBy('articles_count', 'desc')
                        ->take(10)
                        ->get();
                    $view->with('trendingTags', $trendingTags);
                }
            } catch (\Throwable $e) {
                $view->with('breakingNews', collect());
            }
        });
    }
}
