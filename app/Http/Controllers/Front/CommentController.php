<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'comment' => 'required|string|max:1000',
        ]);

        $comment = new Comment([
            'article_id' => $article->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'comment' => $validated['comment'],
            'is_approved' => true,
        ]);
        $comment->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar Anda berhasil dikirim dan ditayangkan.',
                'comment' => [
                    'name' => $comment->name,
                    'comment' => e($comment->comment),
                    'created_at' => $comment->created_at->diffForHumans(),
                ],
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
