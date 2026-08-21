<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = Article::with(['category', 'user'])
            ->published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(10);

        $trendingTags = Tag::withCount('articles')->orderBy('articles_count', 'desc')->take(10)->get();

        $popularArticles = Article::with(['category', 'user'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        $sidebarLatest = Article::with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->take(5)
            ->get();

        $popularTags = Tag::has('articles')
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(15)
            ->get();

        $navCategories = Category::orderBy('order', 'asc')->get();

        return view('front.category', compact(
            'category',
            'articles',
            'trendingTags',
            'popularArticles',
            'sidebarLatest',
            'popularTags',
            'navCategories'
        ));
    }
}
