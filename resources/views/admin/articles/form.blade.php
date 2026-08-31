@extends('layouts.admin')

@section('page_title', isset($article) ? 'Edit Berita: ' . Str::limit($article->title, 35) : 'Tulis Berita Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ isset($article) ? 'Formulir Edit Berita' : 'Formulir Berita Baru' }}</h3>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 18px;">
            <ul style="margin-left: 20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($article) ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
            
            <!-- Left Column: Main Fields -->
            <div>
                <div class="form-group">
                    <label for="title">Judul Berita *</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $article->title ?? '') }}" placeholder="Contoh: Pemerintah Resmi Luncurkan Logo HUT Ke-81 RI" required>
                </div>

                <div class="form-group">
                    <label for="slug">Slug URL (Opsional, otomatis dari judul jika kosong)</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $article->slug ?? '') }}" placeholder="pemerintah-resmi-luncurkan-logo-hut-ke-81-ri">
                </div>

                <div class="form-group">
                    <label for="excerpt">Ringkasan Berita Singkat (Excerpt)</label>
                    <textarea id="excerpt" name="excerpt" class="form-control" rows="2" placeholder="Ringkasan singkat 1-2 kalimat untuk pratinjau berita...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="ai_summary">
                        <i class="fas fa-magic" style="color: #6366f1;"></i> Poin Ringkasan AI (Opsional)
                        <span style="font-weight: normal; font-size: 12px; color: var(--admin-muted);">(1 poin per baris. Jika dikosongkan, AI otomatis mengekstrak 3 poin dari isi berita)</span>
                    </label>
                    <textarea id="ai_summary" name="ai_summary" class="form-control" rows="3" placeholder="• Poin 1: Fakta utama berita...&#10;• Poin 2: Pernyataan narasumber...&#10;• Poin 3: Dampak atau kelanjutan peristiwa...">{{ old('ai_summary', $article->ai_summary ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="content">Konten Berita Lengkap (HTML Didukung) *</label>
                    <textarea id="content" name="content" class="form-control" rows="12" placeholder="Tulis isi berita lengkap di sini..." required>{{ old('content', $article->content ?? '') }}</textarea>
                </div>
            </div>

            <!-- Right Column: Settings & Media -->
            <div>
                <div class="form-group">
                    <label for="category_id">Kategori *</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="media_type">Tipe Format Berita *</label>
                    <select id="media_type" name="media_type" class="form-control" required>
                        <option value="standard" {{ old('media_type', $article->media_type ?? '') == 'standard' ? 'selected' : '' }}>Standard Berita</option>
                        <option value="video" {{ old('media_type', $article->media_type ?? '') == 'video' ? 'selected' : '' }}>Berita Video</option>
                        <option value="photo" {{ old('media_type', $article->media_type ?? '') == 'photo' ? 'selected' : '' }}>Galeri Foto</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="media_badge">Badge Durasi / Jumlah Foto (Opsional)</label>
                    <input type="text" id="media_badge" name="media_badge" class="form-control" value="{{ old('media_badge', $article->media_badge ?? '') }}" placeholder="Contoh: 02:07 atau 3 Foto">
                </div>

                <div class="form-group">
                    <label for="video_url">URL YouTube (Jika tipe Video)</label>
                    <input type="text" id="video_url" name="video_url" class="form-control" value="{{ old('video_url', $article->video_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=XI09xqDqTsk">
                </div>

                <div class="form-group">
                    <label for="image">URL Gambar Utama</label>
                    <input type="text" id="image" name="image" class="form-control" value="{{ old('image', $article->image ?? '') }}" placeholder="https://images.unsplash.com/photo-...">
                </div>

                <div class="form-group">
                    <label for="image_caption">Keterangan Foto (Caption)</label>
                    <input type="text" id="image_caption" name="image_caption" class="form-control" value="{{ old('image_caption', $article->image_caption ?? '') }}" placeholder="Suasana peresmian...">
                </div>

                <div class="form-group">
                    <label for="image_source">Sumber Foto</label>
                    <input type="text" id="image_source" name="image_source" class="form-control" value="{{ old('image_source', $article->image_source ?? '') }}" placeholder="Biro Pers Setpres">
                </div>

                <div class="form-group">
                    <label>Tags / Topik</label>
                    <div style="max-height: 140px; overflow-y: auto; border: 1px solid var(--admin-border); padding: 8px 12px; border-radius: 6px; background: #fff;">
                        @php
                            $selectedTags = isset($article) ? $article->tags->pluck('id')->toArray() : [];
                        @endphp
                        @foreach($tags as $t)
                            <label style="display: flex; align-items: center; gap: 6px; font-weight: normal; margin-bottom: 4px; font-size: 13px; cursor: pointer;">
                                <input type="checkbox" name="tags[]" value="{{ $t->id }}" {{ in_array($t->id, old('tags', $selectedTags)) ? 'checked' : '' }}>
                                #{{ $t->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div style="background-color: #f8fafc; padding: 14px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; margin-bottom: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_sticky" value="1" {{ old('is_sticky', $article->is_sticky ?? false) ? 'checked' : '' }}>
                        <i class="fas fa-thumbtack" style="color: #dc2626;"></i> Jadikan Berita Utama (Sticky Post)
                    </label>

                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; cursor: pointer;">
                        <input type="checkbox" name="is_slider" value="1" {{ old('is_slider', $article->is_slider ?? false) ? 'checked' : '' }}>
                        <i class="fas fa-images" style="color: #1a56db;"></i> Tampilkan di Hero Slider Atas
                    </label>
                </div>

                <div class="form-group">
                    <label for="status">Status Publikasi *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="published" {{ old('status', $article->status ?? 'published') == 'published' ? 'selected' : '' }}>Langsung Publish</option>
                        <option value="draft" {{ old('status', $article->status ?? '') == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success" style="width: 100%; padding: 12px; font-size: 14px; justify-content: center;">
                    <i class="fas fa-save"></i> {{ isset($article) ? 'Simpan Perubahan' : 'Publikasikan Berita' }}
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
