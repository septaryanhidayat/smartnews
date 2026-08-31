<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Trending Tags for the header ticker
        $trendingTags = Tag::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(10)
            ->get();

        // 2. Hero Slider Articles
        $heroSliderCount = (int) setting('hero_slider_count', 3);
        if ($heroSliderCount < 1) {
            $heroSliderCount = 3;
        }

        // Fetch enough articles to keep carousel sliding smoothly
        $sliderFetchLimit = max(10, $heroSliderCount * 2);

        $sliderArticles = Article::with(['category', 'user'])
            ->published()
            ->where('is_slider', true)
            ->orderBy('published_at', 'desc')
            ->take($sliderFetchLimit)
            ->get();

        // If fewer than sliderFetchLimit articles have is_slider, supplement with latest published articles
        if ($sliderArticles->count() < $sliderFetchLimit) {
            $excludeIds = $sliderArticles->pluck('id')->toArray();
            $needed = $sliderFetchLimit - $sliderArticles->count();

            $additionalArticles = Article::with(['category', 'user'])
                ->published()
                ->whereNotIn('id', $excludeIds)
                ->orderBy('published_at', 'desc')
                ->take($needed)
                ->get();

            $sliderArticles = $sliderArticles->merge($additionalArticles);
        }

        // 3. Featured / Sticky Article
        $featuredArticle = Article::with(['category', 'user'])
            ->published()
            ->where('is_sticky', true)
            ->orderBy('published_at', 'desc')
            ->first();

        if (!$featuredArticle) {
            $featuredArticle = Article::with(['category', 'user'])
                ->published()
                ->orderBy('published_at', 'desc')
                ->first();
        }

        // 4. Category Grid (Nasional block matching demo)
        $nasionalCategory = Category::where('slug', 'nasional')->first();
        $nasionalArticles = collect();
        if ($nasionalCategory) {
            $nasionalArticles = Article::with(['category', 'user'])
                ->published()
                ->where('category_id', $nasionalCategory->id)
                ->when($featuredArticle, fn($q) => $q->where('id', '!=', $featuredArticle->id))
                ->orderBy('published_at', 'desc')
                ->take(6)
                ->get();
        }

        // 5. Berita Terkini (Feed with AJAX load more capability)
        $excludeIds = collect([
            $featuredArticle ? $featuredArticle->id : null,
        ])->filter()->toArray();

        $latestArticles = Article::with(['category', 'user'])
            ->published()
            ->whereNotIn('id', $excludeIds)
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        // If AJAX load more request
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.article-feed-items', ['articles' => $latestArticles])->render(),
                'hasMore' => $latestArticles->hasMorePages(),
                'nextPage' => $latestArticles->currentPage() + 1,
            ]);
        }

        // 6. Sidebar Data
        // Top 5 Popular
        $popularArticles = Article::with(['category', 'user'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        // Latest in sidebar
        $sidebarLatest = Article::with(['category', 'user'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        // Popular Tags Cloud
        $popularTags = Tag::has('articles')
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(15)
            ->get();

        // All Categories for navigation
        $navCategories = Category::orderBy('order', 'asc')->get();

        return view('front.home', compact(
            'trendingTags',
            'sliderArticles',
            'featuredArticle',
            'nasionalCategory',
            'nasionalArticles',
            'latestArticles',
            'popularArticles',
            'sidebarLatest',
            'popularTags',
            'navCategories'
        ));
    }
}
