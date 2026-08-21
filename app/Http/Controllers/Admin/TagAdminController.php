<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagAdminController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('articles')->orderBy('name')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:tags,name',
            'slug' => 'nullable|string|max:100|unique:tags,slug',
        ]);

        Tag::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:tags,name,' . $tag->id,
            'slug' => 'nullable|string|max:100|unique:tags,slug,' . $tag->id,
        ]);

        $tag->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil dihapus.');
    }
}
