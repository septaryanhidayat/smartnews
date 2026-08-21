<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'total_views' => Article::sum('views_count'),
            'total_categories' => Category::count(),
            'total_tags' => Tag::count(),
            'total_comments' => Comment::count(),
            'total_users' => User::count(),
        ];

        $latestArticles = Article::with(['category', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $topArticles = Article::with(['category', 'user'])
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        $latestComments = Comment::with('article')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestArticles', 'topArticles', 'latestComments'));
    }
}
