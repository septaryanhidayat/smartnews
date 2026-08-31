<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $articles = collect();
        if (!empty($query)) {
            // SECURITY: Escape LIKE wildcards to prevent SQL LIKE injection
            $escapedQuery = str_replace(['%', '_'], ['\\%', '\\_'], $query);
            $articles = Article::with(['category', 'user'])
                ->published()
                ->where(function ($q) use ($escapedQuery) {
                    $q->where('title', 'like', "%{$escapedQuery}%")
                      ->orWhere('excerpt', 'like', "%{$escapedQuery}%")
                      ->orWhere('content', 'like', "%{$escapedQuery}%");
                })
                ->orderBy('published_at', 'desc')
                ->paginate(10)
                ->withQueryString();
        }

        $trendingTags = Tag::withCount('articles')->orderBy('articles_count', 'desc')->take(10)->get();

        $popularArticles = Article::with(['category', 'user'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        $sidebarLatest = Article::with(['category', 'user'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $popularTags = Tag::has('articles')
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(15)
            ->get();

        $navCategories = Category::orderBy('order', 'asc')->get();

        return view('front.search', compact(
            'query',
            'articles',
            'trendingTags',
            'popularArticles',
            'sidebarLatest',
            'popularTags',
            'navCategories'
        ));
    }
}
