@extends('layouts.admin')

@section('page_title', 'Kelola Berita & Artikel')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Seluruh Berita ({{ $articles->total() }})</h3>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Berita Baru
        </a>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('admin.articles.index') }}" method="GET" style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
        <input type="text" name="search" class="form-control" style="max-width: 260px;" placeholder="Cari judul..." value="{{ $search }}">
        <select name="category_id" class="form-control" style="max-width: 180px;">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="form-control" style="max-width: 150px;">
            <option value="">Semua Status</option>
            <option value="published" {{ $status == 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ $status == 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
    </form>

    <table>
        <thead>
            <tr>
                <th style="width: 60px;">Gambar</th>
                <th>Judul Berita</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Views</th>
                <th>Status</th>
                <th>Headline</th>
                <th style="width: 130px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $art)
            <tr>
                <td>
                    <img src="{{ $art->image_url }}" alt="" style="width: 50px; height: 38px; object-fit: cover; border-radius: 4px;">
                </td>
                <td>
                    <a href="{{ route('article.show', $art->slug) }}" target="_blank" style="font-weight: 700; color: var(--admin-primary);">
                        {{ $art->title }}
                    </a>
                    <div style="font-size: 11px; color: var(--admin-muted);">
                        Oleh: {{ $art->user->name ?? 'Redaksi' }} &bull; {{ $art->published_at ? $art->published_at->format('d M Y') : '-' }}
                    </div>
                </td>
                <td><span class="badge badge-info">{{ $art->category->name }}</span></td>
                <td>
                    @if($art->media_type === 'video')
                        <span class="badge badge-danger"><i class="fas fa-play"></i> Video</span>
                    @elseif($art->media_type === 'photo')
                        <span class="badge badge-info"><i class="fas fa-camera"></i> Foto</span>
                    @else
                        <span style="font-size: 12px; color: var(--admin-muted);">Standard</span>
                    @endif
                </td>
                <td><strong>{{ number_format($art->views_count) }}</strong></td>
                <td>
                    @if($art->status === 'published')
                        <span class="badge badge-success">Publish</span>
                    @else
                        <span class="badge badge-danger">Draft</span>
                    @endif
                </td>
                <td>
                    @if($art->is_sticky)
                        <span class="badge badge-danger" title="Sticky Post"><i class="fas fa-thumbtack"></i> Sticky</span>
                    @endif
                    @if($art->is_slider)
                        <span class="badge badge-info" title="Hero Slider"><i class="fas fa-images"></i> Slider</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.articles.edit', $art->id) }}" class="btn btn-sm btn-primary" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 30px; color: var(--admin-muted);">
                    Tidak ada berita ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $articles->appends(request()->query())->links() }}
    </div>
</div>
@endsection
