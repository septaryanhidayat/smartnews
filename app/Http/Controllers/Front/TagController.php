<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $articles = $tag->articles()
            ->with(['category', 'user'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);

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

        return view('front.tag', compact(
            'tag',
            'articles',
            'trendingTags',
            'popularArticles',
            'sidebarLatest',
            'popularTags',
            'navCategories'
        ));
    }
}
