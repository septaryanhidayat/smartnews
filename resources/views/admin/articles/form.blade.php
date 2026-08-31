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

                <!-- LIVE AI SEO OPTIMIZER WIDGET -->
                <div style="background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 10px; padding: 16px; margin-bottom: 20px; color: #ffffff; box-shadow: 0 4px 14px rgba(0,0,0,0.12); border: 1px solid #334155;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-robot" style="color: #60a5fa; font-size: 16px;"></i>
                            <strong style="font-size: 13.5px; color: #f8fafc;">Asisten Skor SEO AI</strong>
                        </div>
                        <div id="liveSeoBadge" style="background-color: #059669; color: #fff; padding: 3px 8px; border-radius: 999px; font-size: 11px; font-weight: 800;">
                            <span id="liveSeoScore">85</span>/100 (<span id="liveSeoGrade">A</span>)
                        </div>
                    </div>

                    <div style="background: rgba(255,255,255,0.06); border-radius: 6px; padding: 10px; font-size: 12px; margin-bottom: 12px;">
                        <div id="liveSeoGradeText" style="font-weight: 700; color: #38bdf8; margin-bottom: 4px;">Baik</div>
                        <div style="color: #94a3b8; font-size: 11px; display: flex; gap: 8px;">
                            <span id="liveWordCount">0</span> kata &bull; <span id="liveTitleCount">0</span> karakter judul
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 6px; font-size: 11.5px;">
                        <div id="checkTitle" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                            <i class="fas fa-circle" style="font-size: 8px;"></i> <span>Judul berita (40-80 karakter)</span>
                        </div>
                        <div id="checkContent" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                            <i class="fas fa-circle" style="font-size: 8px;"></i> <span>Kedalaman konten (min 200 kata)</span>
                        </div>
                        <div id="checkExcerpt" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                            <i class="fas fa-circle" style="font-size: 8px;"></i> <span>Ringkasan / Excerpt (80-160 char)</span>
                        </div>
                        <div id="checkAi" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                            <i class="fas fa-circle" style="font-size: 8px;"></i> <span>Poin Ringkasan AI (min 1-3 poin)</span>
                        </div>
                        <div id="checkImage" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                            <i class="fas fa-circle" style="font-size: 8px;"></i> <span>Gambar utama terpasang</span>
                        </div>
                        <div id="checkTags" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                            <i class="fas fa-circle" style="font-size: 8px;"></i> <span>Kategori & min 2 tag topik</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status Publikasi *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="published" {{ old('status', $article->status ?? 'published') == 'published' ? 'selected' : '' }}>Langsung Publish</option>
                        <option value="draft" {{ old('status', $article->status ?? '') == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 15px;">
                    <i class="fas fa-save"></i> {{ isset($article) ? 'Simpan Perubahan' : 'Terbitkan Berita' }}
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function calculateLiveSeo() {
    var title = (document.getElementById('title') ? document.getElementById('title').value : '').trim();
    var content = (document.getElementById('content') ? document.getElementById('content').value : '').trim();
    var excerpt = (document.getElementById('excerpt') ? document.getElementById('excerpt').value : '').trim();
    var aiSummary = (document.getElementById('ai_summary') ? document.getElementById('ai_summary').value : '').trim();
    var image = (document.getElementById('image') ? document.getElementById('image').value : '').trim();
    var categoryId = document.getElementById('category_id') ? document.getElementById('category_id').value : '';
    
    var checkedTags = document.querySelectorAll('input[name="tags[]"]:checked').length;
    var words = content ? content.replace(/<[^>]*>/g, ' ').trim().split(/\s+/).filter(Boolean).length : 0;
    var titleLen = title.length;
    var excerptLen = excerpt.length;

    document.getElementById('liveWordCount').textContent = words;
    document.getElementById('liveTitleCount').textContent = titleLen;

    var score = 0;

    // 1. Title (20 pts)
    var elTitle = document.getElementById('checkTitle');
    if (titleLen >= 40 && titleLen <= 80) {
        score += 20;
        elTitle.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Judul optimal (' + titleLen + ' char)</span>';
    } else if (titleLen >= 25) {
        score += 12;
        elTitle.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #fbbf24;"></i> <span>Judul agak pendek (' + titleLen + ' char)</span>';
    } else {
        score += 5;
        elTitle.innerHTML = '<i class="fas fa-times-circle" style="color: #f87171;"></i> <span>Judul terlalu pendek</span>';
    }

    // 2. Content (25 pts)
    var elContent = document.getElementById('checkContent');
    if (words >= 400) {
        score += 25;
        elContent.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Konten mendalam (' + words + ' kata)</span>';
    } else if (words >= 200) {
        score += 18;
        elContent.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Konten memadai (' + words + ' kata)</span>';
    } else if (words >= 100) {
        score += 10;
        elContent.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #fbbf24;"></i> <span>Konten agak singkat (' + words + ' kata)</span>';
    } else {
        score += 4;
        elContent.innerHTML = '<i class="fas fa-times-circle" style="color: #f87171;"></i> <span>Konten terlalu tipis (' + words + ' kata)</span>';
    }

    // 3. Excerpt (15 pts)
    var elExcerpt = document.getElementById('checkExcerpt');
    if (excerptLen >= 70 && excerptLen <= 200) {
        score += 15;
        elExcerpt.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Excerpt optimal (' + excerptLen + ' char)</span>';
    } else if (excerptLen > 0) {
        score += 8;
        elExcerpt.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #fbbf24;"></i> <span>Excerpt disesuaikan (' + excerptLen + ' char)</span>';
    } else {
        elExcerpt.innerHTML = '<i class="fas fa-times-circle" style="color: #f87171;"></i> <span>Excerpt masih kosong</span>';
    }

    // 4. AI Summary (20 pts)
    var elAi = document.getElementById('checkAi');
    var aiPoints = aiSummary ? aiSummary.split('\n').filter(function(l){ return l.trim().length > 5; }).length : 0;
    if (aiPoints >= 3 || (!aiSummary && words >= 200)) {
        score += 20;
        elAi.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Ringkasan AI siap (3 poin)</span>';
    } else if (aiPoints >= 1) {
        score += 12;
        elAi.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Ringkasan AI (' + aiPoints + ' poin)</span>';
    } else {
        score += 8;
        elAi.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #fbbf24;"></i> <span>Otomatis diekstrak dari konten</span>';
    }

    // 5. Image (10 pts)
    var elImage = document.getElementById('checkImage');
    if (image.length > 5) {
        score += 10;
        elImage.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Foto utama terpasang</span>';
    } else {
        elImage.innerHTML = '<i class="fas fa-times-circle" style="color: #f87171;"></i> <span>Foto utama belum diisi</span>';
    }

    // 6. Category & Tags (10 pts)
    var elTags = document.getElementById('checkTags');
    if (categoryId && checkedTags >= 2) {
        score += 10;
        elTags.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Kategori & ' + checkedTags + ' tag terpasang</span>';
    } else if (categoryId && checkedTags >= 1) {
        score += 7;
        elTags.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #fbbf24;"></i> <span>Kategori & 1 tag (tambah 1 lagi)</span>';
    } else {
        score += 3;
        elTags.innerHTML = '<i class="fas fa-times-circle" style="color: #f87171;"></i> <span>Pilih kategori & min 2 tag</span>';
    }

    score = Math.min(100, Math.max(15, score));
    var grade = 'C';
    var gradeText = 'Perlu Optimasi';
    var badgeBg = '#dc2626';

    if (score >= 88) {
        grade = 'A+';
        gradeText = 'Sangat Baik (Optimal)';
        badgeBg = '#059669';
    } else if (score >= 75) {
        grade = 'A';
        gradeText = 'Baik';
        badgeBg = '#0284c7';
    } else if (score >= 60) {
        grade = 'B';
        gradeText = 'Cukup';
        badgeBg = '#d97706';
    }

    document.getElementById('liveSeoScore').textContent = score;
    document.getElementById('liveSeoGrade').textContent = grade;
    document.getElementById('liveSeoGradeText').textContent = gradeText;
    document.getElementById('liveSeoBadge').style.backgroundColor = badgeBg;
}

document.addEventListener('DOMContentLoaded', function() {
    var inputs = ['title', 'content', 'excerpt', 'ai_summary', 'image', 'category_id'];
    inputs.forEach(function(id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', calculateLiveSeo);
            el.addEventListener('change', calculateLiveSeo);
        }
    });

    document.querySelectorAll('input[name="tags[]"]').forEach(function(cb) {
        cb.addEventListener('change', calculateLiveSeo);
    });

    calculateLiveSeo();
});
</script>
@endpush
@endsection
