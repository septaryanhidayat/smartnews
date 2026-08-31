<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleAdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $status = $request->input('status');

        $articles = Article::with(['category', 'user'])
            ->when($user->isAuthor(), function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        $categories = Category::orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories', 'search', 'categoryId', 'status'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.articles.form', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'ai_summary' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|max:8192',
            'image_caption' => 'nullable|string',
            'image_source' => 'nullable|string',
            'media_type' => 'required|in:standard,video,photo',
            'media_badge' => 'nullable|string|max:50',
            'video_url' => 'nullable|string',
            'video_id' => 'nullable|string',
            'is_sticky' => 'boolean',
            'is_slider' => 'boolean',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
        ]);

        $imagePath = $request->input('image');
        if ($request->hasFile('image_file')) {
            $imagePath = ImageService::convertToWebp($request->file('image_file'), 'articles', 1200, 80);
        }

        // Parse YouTube ID if video url provided
        $videoId = $request->input('video_id');
        if ($request->filled('video_url') && empty($videoId)) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $request->input('video_url'), $match)) {
                $videoId = $match[1];
            }
        }

        $article = Article::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?: Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'],
            'ai_summary' => $validated['ai_summary'] ?? null,
            'content' => $validated['content'],
            'image' => $imagePath,
            'image_caption' => $validated['image_caption'],
            'image_source' => $validated['image_source'],
            'media_type' => $validated['media_type'],
            'media_badge' => $validated['media_badge'],
            'video_url' => $validated['video_url'],
            'video_id' => $videoId,
            'is_sticky' => $request->has('is_sticky'),
            'is_slider' => $request->has('is_slider'),
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? now(),
        ]);

        if ($request->filled('tags')) {
            $article->tags()->sync($request->input('tags'));
        }

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil dipublikasikan dengan format gambar WebP optimal!');
    }

    public function edit($id)
    {
        $article = Article::with('tags')->findOrFail($id);
        $user = Auth::user();

        if ($user->isAuthor() && $article->user_id !== $user->id) {
            abort(403, 'Akses Ditolak: Anda hanya dapat mengedit artikel yang Anda tulis sendiri.');
        }

        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.articles.form', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();

        if ($user->isAuthor() && $article->user_id !== $user->id) {
            abort(403, 'Akses Ditolak: Anda hanya dapat memperbarui artikel yang Anda tulis sendiri.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'ai_summary' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|max:8192',
            'image_caption' => 'nullable|string',
            'image_source' => 'nullable|string',
            'media_type' => 'required|in:standard,video,photo',
            'media_badge' => 'nullable|string|max:50',
            'video_url' => 'nullable|string',
            'video_id' => 'nullable|string',
            'is_sticky' => 'boolean',
            'is_slider' => 'boolean',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
        ]);

        $imagePath = $article->image;
        if ($request->filled('image')) {
            $imagePath = $request->input('image');
        }
        if ($request->hasFile('image_file')) {
            $imagePath = ImageService::convertToWebp($request->file('image_file'), 'articles', 1200, 80);
        }

        $videoId = $request->input('video_id');
        if ($request->filled('video_url') && empty($videoId)) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $request->input('video_url'), $match)) {
                $videoId = $match[1];
            }
        }

        $article->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?: Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'],
            'ai_summary' => $validated['ai_summary'] ?? null,
            'content' => $validated['content'],
            'image' => $imagePath,
            'image_caption' => $validated['image_caption'],
            'image_source' => $validated['image_source'],
            'media_type' => $validated['media_type'],
            'media_badge' => $validated['media_badge'],
            'video_url' => $validated['video_url'],
            'video_id' => $videoId,
            'is_sticky' => $request->has('is_sticky'),
            'is_slider' => $request->has('is_slider'),
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? $article->published_at,
        ]);

        if ($request->has('tags')) {
            $article->tags()->sync($request->input('tags'));
        }

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();

        if ($user->isAuthor() && $article->user_id !== $user->id) {
            abort(403, 'Akses Ditolak: Anda hanya dapat menghapus artikel yang Anda tulis sendiri.');
        }

        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil dihapus.');
    }
}
