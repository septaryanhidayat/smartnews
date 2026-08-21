<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request, $slug)
    {
        $article = Article::with(['category', 'user', 'tags', 'approvedComments'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count
        $article->increment('views_count');

        // Trending tags for header
        $trendingTags = Tag::withCount('articles')->orderBy('articles_count', 'desc')->take(10)->get();

        // Previous and Next article
        $prevArticle = Article::published()
            ->where('id', '<', $article->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextArticle = Article::published()
            ->where('id', '>', $article->id)
            ->orderBy('id', 'asc')
            ->first();

        // Inline related article ("Baca Juga")
        $inlineRelated = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->first();

        // Related articles grid at bottom
        $relatedArticles = Article::with(['category', 'user'])
            ->published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Sidebar Data
        $popularArticles = Article::with(['category', 'user'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        $sidebarLatest = Article::with(['category', 'user'])
            ->published()
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $popularTags = Tag::has('articles')
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(15)
            ->get();

        $navCategories = Category::orderBy('order', 'asc')->get();

        return view('front.article', compact(
            'article',
            'trendingTags',
            'prevArticle',
            'nextArticle',
            'inlineRelated',
            'relatedArticles',
            'popularArticles',
            'sidebarLatest',
            'popularTags',
            'navCategories'
        ));
    }
}
