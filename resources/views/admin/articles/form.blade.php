@extends('layouts.admin')

@section('title', isset($article) ? 'Edit Berita - ' . Str::limit($article->title, 40) : 'Tulis Berita Baru - SmartNews')

@push('styles')
<!-- Summernote Lite WYSIWYG (Full Word-like Rich Text Editor) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    /* CMS Editor Layout */
    .wp-editor-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .wp-editor-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Post Title Input (WP Style) */
    .wp-title-input {
        width: 100%;
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        padding: 14px 18px;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        background-color: #ffffff;
        outline: none;
        transition: all 0.2s ease;
        line-height: 1.3;
        margin-bottom: 8px;
    }
    .wp-title-input:focus {
        border-color: #1a56db;
        box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.15);
    }
    .wp-title-input::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    /* Permalink Bar */
    .wp-permalink-bar {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #64748b;
        margin-bottom: 18px;
        padding: 4px 8px;
        background: #f8fafc;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        flex-wrap: wrap;
    }
    .wp-permalink-bar strong {
        color: #334155;
    }
    .wp-slug-pill {
        color: #1a56db;
        font-weight: 600;
        text-decoration: underline;
    }
    .wp-slug-edit-btn {
        background: #e2e8f0;
        border: none;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
    }
    .wp-slug-edit-btn:hover {
        background: #cbd5e1;
    }

    /* WordPress Meta Box */
    .wp-meta-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .wp-meta-box__header {
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 700;
        font-size: 13.5px;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .wp-meta-box__body {
        padding: 16px 18px;
    }

    /* Summernote Word-like Editor Enhancements */
    .note-editor.note-airframe, .note-editor.note-frame {
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        box-shadow: none !important;
        background: #ffffff !important;
    }
    .note-toolbar {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 8px 10px !important;
        border-radius: 8px 8px 0 0 !important;
    }
    .note-btn {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #334155 !important;
        font-size: 13px !important;
        padding: 5px 9px !important;
        border-radius: 4px !important;
        transition: all 0.15s !important;
    }
    .note-btn:hover, .note-btn.active {
        background: #e2e8f0 !important;
        color: #1a56db !important;
        border-color: #94a3b8 !important;
    }
    .note-editable {
        background: #ffffff !important;
        font-family: 'Noto Sans', sans-serif !important;
        font-size: 15px !important;
        line-height: 1.7 !important;
        color: #1e293b !important;
        min-height: 420px !important;
        padding: 20px !important;
    }
    .note-editable p {
        margin-bottom: 1rem;
    }

    /* Drag & Drop Featured Image Upload Box */
    .featured-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        padding: 20px 14px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    .featured-upload-zone:hover {
        border-color: #1a56db;
        background: #f0f7ff;
    }
    .featured-upload-zone i {
        font-size: 32px;
        color: #64748b;
        margin-bottom: 8px;
    }
    .featured-upload-zone strong {
        display: block;
        font-size: 13px;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .featured-upload-zone span {
        font-size: 11px;
        color: #94a3b8;
    }

    /* Featured Image Preview Card */
    .featured-preview-card {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
        background: #0f172a;
    }
    .featured-preview-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
    }
    .featured-preview-actions {
        padding: 8px 12px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid #e2e8f0;
    }
</style>
@endpush

@section('content')
<div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
    <div>
        <h2 style="font-size: 20px; font-weight: 800; color: var(--admin-text); margin: 0;">
            {{ isset($article) ? 'Edit Berita' : 'Tulis Berita Baru' }}
        </h2>
        <p style="font-size: 12.5px; color: var(--admin-muted); margin: 2px 0 0 0;">
            Editor konten berita profesional dengan format kaya & asisten optimasi AI.
        </p>
    </div>
    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary" style="background: #e2e8f0; color: #334155; font-weight: 600; padding: 6px 14px; font-size: 13px;">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

@if($errors->any())
    <div style="background-color: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: 14px; border-radius: 6px; margin-bottom: 20px; font-size: 13.5px;">
        <strong style="display: block; margin-bottom: 4px;"><i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan input:</strong>
        <ul style="margin-left: 20px; margin-bottom: 0;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($article) ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
    @csrf
    @if(isset($article))
        @method('PUT')
    @endif

    <div class="wp-editor-layout">
        <!-- ================= LEFT COLUMN: MAIN CONTENT & TITLE ================= -->
        <div>
            <!-- Post Title (WordPress Style) -->
            <div>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="wp-title-input" 
                    value="{{ old('title', $article->title ?? '') }}" 
                    placeholder="Tambah Judul Berita..." 
                    autocomplete="off"
                    required
                >
            </div>

            <!-- Permalink / Slug Bar -->
            <div class="wp-permalink-bar">
                <strong><i class="fas fa-link"></i> Permalink:</strong>
                <span>{{ url('/berita') }}/</span>
                <span id="slugDisplay" class="wp-slug-pill">{{ old('slug', $article->slug ?? 'judul-berita-otomatis') }}</span>
                <button type="button" class="wp-slug-edit-btn" onclick="toggleSlugEdit()"><i class="fas fa-pencil-alt"></i> Edit Slug</button>
            </div>

            <!-- Hidden/Editable Slug Input -->
            <div id="slugInputWrap" style="display: none; margin-bottom: 14px; background: #f1f5f9; padding: 8px 12px; border-radius: 6px; border: 1px solid #cbd5e1;">
                <label for="slug" style="font-size: 11.5px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Kustomisasi Slug URL:</label>
                <div style="display: flex; gap: 8px;">
                    <input type="text" id="slug" name="slug" class="form-control" style="font-size: 13px; height: 34px;" value="{{ old('slug', $article->slug ?? '') }}" placeholder="kustom-url-berita-anda">
                    <button type="button" class="btn btn-sm btn-primary" onclick="applySlugEdit()">Simpan</button>
                </div>
            </div>

            <!-- WORD-LIKE WYSIWYG RICH TEXT EDITOR -->
            <div class="wp-meta-box" style="margin-bottom: 24px;">
                <div class="wp-meta-box__header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-alt" style="color: var(--admin-primary);"></i>
                        <span>Isi Konten Berita (Word-like Visual Editor)</span>
                    </div>
                    <span style="font-size: 11px; font-weight: normal; color: var(--admin-muted);">
                        Mendukung Gambar, Format Teks, Rata Tengah/Kiri/Kanan/Penuh & Video
                    </span>
                </div>
                <div style="padding: 0;">
                    <textarea id="content" name="content" required>{{ old('content', $article->content ?? '') }}</textarea>
                </div>
            </div>

            <!-- EXCERPT / RINGKASAN META -->
            <div class="wp-meta-box">
                <div class="wp-meta-box__header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-align-left" style="color: #6366f1;"></i>
                        <span>Ringkasan Berita Singkat (Excerpt / Snippet)</span>
                    </div>
                    <span style="font-size: 11px; font-weight: normal; color: var(--admin-muted);">Untuk Google SERP & Sosial Media</span>
                </div>
                <div class="wp-meta-box__body">
                    <textarea id="excerpt" name="excerpt" class="form-control" rows="3" placeholder="Tuliskan 1-2 kalimat ringkasan tajam berita ini...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                    <div style="font-size: 11.5px; color: var(--admin-muted); margin-top: 4px;">
                        Disarankan 80–160 karakter agar tampil optimal saat dibagikan ke WhatsApp, Facebook, dan Google.
                    </div>
                </div>
            </div>

            <!-- AI OVERVIEW / POIN RINGKASAN CERDAS AI -->
            <div class="wp-meta-box">
                <div class="wp-meta-box__header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-magic" style="color: #8b5cf6;"></i>
                        <span>Poin Ringkasan Cerdas AI (AI Overview)</span>
                    </div>
                    <span class="badge badge-info" style="font-size: 10px;">Fitur Cerdas</span>
                </div>
                <div class="wp-meta-box__body">
                    <textarea id="ai_summary" name="ai_summary" class="form-control" rows="3" placeholder="• Poin 1: Fakta utama berita...&#10;• Poin 2: Pernyataan narasumber / data penting...&#10;• Poin 3: Dampak dan kesimpulan peristiwa...">{{ old('ai_summary', $article->ai_summary ?? '') }}</textarea>
                    <div style="font-size: 11.5px; color: var(--admin-muted); margin-top: 4px;">
                        Tulis 1 poin per baris (diawali tanda • atau nomor). Jika dikosongkan, AI otomatis mengekstrak 3 poin terbaik dari isi berita.
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= RIGHT COLUMN: WORDPRESS SIDEBAR META BOXES ================= -->
        <div>
            <!-- BOX 1: PANEL PUBLIKASI (PUBLISH) -->
            <div class="wp-meta-box" style="border-top: 3px solid var(--admin-primary);">
                <div class="wp-meta-box__header">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-paper-plane" style="color: var(--admin-primary);"></i>
                        <span>Publikasi Berita</span>
                    </div>
                </div>
                <div class="wp-meta-box__body">
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label for="status" style="font-size: 12px; font-weight: 700; color: #475569;">Status Berita:</label>
                        <select id="status" name="status" class="form-control" style="font-size: 13px;" required>
                            <option value="published" {{ old('status', $article->status ?? 'published') == 'published' ? 'selected' : '' }}>🟢 Langsung Publish</option>
                            <option value="draft" {{ old('status', $article->status ?? '') == 'draft' ? 'selected' : '' }}>⚪ Simpan sebagai Draf</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 14px;">
                        <label for="published_at" style="font-size: 12px; font-weight: 700; color: #475569;">Waktu Penerbitan:</label>
                        <input type="datetime-local" id="published_at" name="published_at" class="form-control" style="font-size: 12.5px;" value="{{ old('published_at', isset($article) && $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                    </div>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 12px; margin-bottom: 16px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 12.5px; margin-bottom: 8px; cursor: pointer; color: #1e293b;">
                            <input type="checkbox" name="is_sticky" value="1" {{ old('is_sticky', $article->is_sticky ?? false) ? 'checked' : '' }}>
                            <i class="fas fa-thumbtack" style="color: #dc2626;"></i> Berita Utama (Sticky Post)
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 12.5px; cursor: pointer; color: #1e293b;">
                            <input type="checkbox" name="is_slider" value="1" {{ old('is_slider', $article->is_slider ?? false) ? 'checked' : '' }}>
                            <i class="fas fa-images" style="color: #1a56db;"></i> Tampil di Slider Depan
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 14px; font-weight: 700; justify-content: center; border-radius: 6px; box-shadow: 0 2px 6px rgba(26, 86, 219, 0.25);">
                        <i class="fas fa-save"></i> {{ isset($article) ? 'Perbarui Berita' : 'Terbitkan Berita' }}
                    </button>
                </div>
            </div>

            <!-- BOX 2: ASISTEN SKOR SEO AI REAL-TIME -->
            <div style="background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 10px; padding: 16px; margin-bottom: 20px; color: #ffffff; box-shadow: 0 4px 14px rgba(0,0,0,0.12); border: 1px solid #334155;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-robot" style="color: #60a5fa; font-size: 16px;"></i>
                        <strong style="font-size: 13px; color: #f8fafc;">Asisten Skor SEO AI</strong>
                    </div>
                    <div id="liveSeoBadge" style="background-color: #059669; color: #fff; padding: 3px 8px; border-radius: 999px; font-size: 11px; font-weight: 800;">
                        <span id="liveSeoScore">85</span>/100 (<span id="liveSeoGrade">A</span>)
                    </div>
                </div>

                <div style="background: rgba(255,255,255,0.06); border-radius: 6px; padding: 8px 10px; font-size: 11.5px; margin-bottom: 10px;">
                    <div id="liveSeoGradeText" style="font-weight: 700; color: #38bdf8; margin-bottom: 2px;">Baik</div>
                    <div style="color: #94a3b8; font-size: 10.5px; display: flex; gap: 8px;">
                        <span id="liveWordCount">0</span> kata &bull; <span id="liveTitleCount">0</span> karakter judul
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 5px; font-size: 11px;">
                    <div id="checkTitle" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                        <i class="fas fa-circle" style="font-size: 7px;"></i> <span>Judul (40-80 char)</span>
                    </div>
                    <div id="checkContent" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                        <i class="fas fa-circle" style="font-size: 7px;"></i> <span>Kedalaman isi (>200 kata)</span>
                    </div>
                    <div id="checkExcerpt" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                        <i class="fas fa-circle" style="font-size: 7px;"></i> <span>Excerpt / Cuplikan</span>
                    </div>
                    <div id="checkAi" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                        <i class="fas fa-circle" style="font-size: 7px;"></i> <span>Ringkasan Cerdas AI</span>
                    </div>
                    <div id="checkImage" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                        <i class="fas fa-circle" style="font-size: 7px;"></i> <span>Gambar utama terpasang</span>
                    </div>
                    <div id="checkTags" style="display: flex; align-items: center; gap: 6px; color: #cbd5e1;">
                        <i class="fas fa-circle" style="font-size: 7px;"></i> <span>Kategori & min 2 tag</span>
                    </div>
                </div>
            </div>

            <!-- BOX 3: GAMBAR UNGGULAN (FEATURED IMAGE - WORDPRESS STYLE) -->
            <div class="wp-meta-box">
                <div class="wp-meta-box__header">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-image" style="color: #0284c7;"></i>
                        <span>Gambar Unggulan (Featured Image)</span>
                    </div>
                </div>
                <div class="wp-meta-box__body">
                    @php
                        $hasImage = isset($article) && !empty($article->image);
                        $currentImageUrl = $hasImage ? $article->image_url : '';
                    @endphp

                    <!-- Image Preview Card (shown if image exists or selected) -->
                    <div id="featuredPreviewContainer" class="featured-preview-card" style="{{ $hasImage ? '' : 'display: none;' }}">
                        <img id="featuredPreviewImg" src="{{ $currentImageUrl }}" alt="Preview Foto" class="featured-preview-img">
                        <div class="featured-preview-actions">
                            <span style="font-size: 11.5px; color: #475569; font-weight: 600;">Foto Terpasang</span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeFeaturedImage()" style="padding: 2px 8px; font-size: 11px;">
                                <i class="fas fa-trash"></i> Hapus Foto
                            </button>
                        </div>
                    </div>

                    <!-- Local File Upload Drag & Drop Dropzone -->
                    <div id="featuredUploadZone" class="featured-upload-zone" onclick="triggerFileInput()" style="{{ $hasImage ? 'display: none;' : '' }}">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <strong>Pilih Foto dari Komputer / HP</strong>
                        <span>Klik di sini untuk memilih file gambar lokal (JPG, PNG, WebP)</span>
                    </div>

                    <!-- Hidden Native File Input -->
                    <input 
                        type="file" 
                        id="imageFileInput" 
                        name="image_file" 
                        accept="image/jpeg,image/png,image/webp,image/jpg" 
                        style="display: none;" 
                        onchange="handleLocalFileSelect(this)"
                    >

                    <!-- Toggle for optional URL input -->
                    <div style="margin-top: 10px; font-size: 11.5px; text-align: right;">
                        <a href="javascript:void(0)" onclick="toggleUrlInput()" style="color: var(--admin-primary); text-decoration: underline;">
                            <i class="fas fa-link"></i> <span id="toggleUrlText">Atau gunakan URL Gambar Web</span>
                        </a>
                    </div>

                    <!-- Optional Direct Image URL Input -->
                    <div id="urlInputContainer" style="display: none; margin-top: 8px;">
                        <input 
                            type="text" 
                            id="image" 
                            name="image" 
                            class="form-control" 
                            style="font-size: 12px;" 
                            value="{{ old('image', $article->image ?? '') }}" 
                            placeholder="https://images.unsplash.com/..."
                            oninput="handleUrlImageInput(this.value)"
                        >
                    </div>

                    <div style="margin-top: 14px;">
                        <div class="form-group" style="margin-bottom: 8px;">
                            <label for="image_caption" style="font-size: 11.5px; font-weight: 700; color: #475569;">Keterangan Foto (Caption):</label>
                            <input type="text" id="image_caption" name="image_caption" class="form-control" style="font-size: 12px; height: 32px;" value="{{ old('image_caption', $article->image_caption ?? '') }}" placeholder="Contoh: Suasana pelantikan...">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="image_source" style="font-size: 11.5px; font-weight: 700; color: #475569;">Sumber / Hak Cipta Foto:</label>
                            <input type="text" id="image_source" name="image_source" class="form-control" style="font-size: 12px; height: 32px;" value="{{ old('image_source', $article->image_source ?? '') }}" placeholder="Contoh: Dok. Humas / Reuters">
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOX 4: FORMAT BERITA (POST FORMAT) -->
            <div class="wp-meta-box">
                <div class="wp-meta-box__header">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-play-circle" style="color: #ef4444;"></i>
                        <span>Format Berita</span>
                    </div>
                </div>
                <div class="wp-meta-box__body">
                    <div class="form-group" style="margin-bottom: 10px;">
                        <select id="media_type" name="media_type" class="form-control" style="font-size: 13px;" onchange="handleMediaTypeChange(this.value)" required>
                            <option value="standard" {{ old('media_type', $article->media_type ?? '') == 'standard' ? 'selected' : '' }}>📄 Standar Artikel Berita</option>
                            <option value="video" {{ old('media_type', $article->media_type ?? '') == 'video' ? 'selected' : '' }}>🎬 Berita Video (YouTube)</option>
                            <option value="photo" {{ old('media_type', $article->media_type ?? '') == 'photo' ? 'selected' : '' }}>📷 Galeri Foto Berita</option>
                        </select>
                    </div>

                    <!-- Video YouTube URL container -->
                    <div id="videoUrlGroup" style="{{ old('media_type', $article->media_type ?? '') === 'video' ? '' : 'display: none;' }} margin-bottom: 10px;">
                        <label for="video_url" style="font-size: 11.5px; font-weight: 700; color: #475569;">URL Video YouTube:</label>
                        <input type="text" id="video_url" name="video_url" class="form-control" style="font-size: 12px;" value="{{ old('video_url', $article->video_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=...">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="media_badge" style="font-size: 11.5px; font-weight: 700; color: #475569;">Badge Durasi / Foto (Opsional):</label>
                        <input type="text" id="media_badge" name="media_badge" class="form-control" style="font-size: 12px; height: 32px;" value="{{ old('media_badge', $article->media_badge ?? '') }}" placeholder="Contoh: 03:15 atau 6 Foto">
                    </div>
                </div>
            </div>

            <!-- BOX 5: KATEGORI / RUBRIK -->
            <div class="wp-meta-box">
                <div class="wp-meta-box__header">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-folder" style="color: #f59e0b;"></i>
                        <span>Kategori & Rubrik *</span>
                    </div>
                </div>
                <div class="wp-meta-box__body">
                    <select id="category_id" name="category_id" class="form-control" style="font-size: 13px;" required>
                        <option value="">-- Pilih Rubrik Berita --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- BOX 6: TAG / KATA KUNCI -->
            <div class="wp-meta-box">
                <div class="wp-meta-box__header">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-tags" style="color: #10b981;"></i>
                        <span>Tag & Kata Kunci</span>
                    </div>
                    <span style="font-size: 10.5px; color: var(--admin-muted);">Pilih 2-4 tag</span>
                </div>
                <div class="wp-meta-box__body" style="padding: 12px;">
                    <div style="max-height: 180px; overflow-y: auto; padding-right: 4px;">
                        @php
                            $selectedTags = isset($article) ? $article->tags->pluck('id')->toArray() : [];
                        @endphp
                        @foreach($tags as $t)
                            <label style="display: flex; align-items: center; gap: 6px; font-weight: normal; margin-bottom: 6px; font-size: 12.5px; cursor: pointer; color: #334155;">
                                <input type="checkbox" name="tags[]" value="{{ $t->id }}" {{ in_array($t->id, old('tags', $selectedTags)) ? 'checked' : '' }}>
                                #{{ $t->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<!-- jQuery CDN (Required for Summernote) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Summernote Lite JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function() {
    // 1. Initialize Word-like Rich Text Summernote Editor
    $('#content').summernote({
        placeholder: 'Mulai ketik artikel berita di sini... Anda bisa mengatur format huruf, perataan paragraf (rata kiri/tengah/kanan/penuh), menyisipkan gambar lokal, tabel, dan video seperti di Microsoft Word.',
        tabsize: 2,
        height: 440,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['alignment', ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                // Upload image directly via AJAX
                for (var i = 0; i < files.length; i++) {
                    uploadEditorImage(files[i]);
                }
            },
            onChange: function(contents, $editable) {
                calculateLiveSeo();
            }
        }
    });

    // Function to upload inline image in editor
    function uploadEditorImage(file) {
        var data = new FormData();
        data.append("image", file);
        data.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: "{{ route('admin.articles.upload-image') }}",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "POST",
            success: function(response) {
                if (response.url) {
                    $('#content').summernote('insertImage', response.url);
                }
            },
            error: function(data) {
                alert("Gagal mengunggah gambar ke server. Pastikan format file gambar valid.");
            }
        });
    }

    // Auto generate slug from title if title changes
    $('#title').on('input', function() {
        var val = $(this).val();
        var currentSlug = $('#slug').val();
        if (!currentSlug || $('#slug').data('auto') !== false) {
            var generatedSlug = slugify(val);
            $('#slugDisplay').text(generatedSlug || 'judul-berita-otomatis');
            $('#slug').val(generatedSlug);
        }
        calculateLiveSeo();
    });

    $('#slug').on('input', function() {
        $(this).data('auto', false);
        $('#slugDisplay').text($(this).val());
    });

    // Listeners for SEO calculation
    $('#excerpt, #ai_summary, #category_id').on('input change', calculateLiveSeo);
    $('input[name="tags[]"]').on('change', calculateLiveSeo);

    calculateLiveSeo();
});

// Slugify helper
function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
}

// Toggle slug edit box
function toggleSlugEdit() {
    var wrap = document.getElementById('slugInputWrap');
    wrap.style.display = wrap.style.display === 'none' ? 'block' : 'none';
}

function applySlugEdit() {
    var val = document.getElementById('slug').value;
    document.getElementById('slugDisplay').textContent = slugify(val);
    document.getElementById('slug').value = slugify(val);
    document.getElementById('slugInputWrap').style.display = 'none';
}

// Handle format change (video URL toggle)
function handleMediaTypeChange(val) {
    var group = document.getElementById('videoUrlGroup');
    if (val === 'video') {
        group.style.display = 'block';
    } else {
        group.style.display = 'none';
    }
}

// Trigger local file input for featured image
function triggerFileInput() {
    document.getElementById('imageFileInput').click();
}

// Handle local file selection with instant client-side preview
function handleLocalFileSelect(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('featuredPreviewImg').src = e.target.result;
            document.getElementById('featuredPreviewContainer').style.display = 'block';
            document.getElementById('featuredUploadZone').style.display = 'none';
            // Clear URL input if file is chosen
            document.getElementById('image').value = '';
            calculateLiveSeo();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove featured image
function removeFeaturedImage() {
    document.getElementById('imageFileInput').value = '';
    document.getElementById('image').value = '';
    document.getElementById('featuredPreviewImg').src = '';
    document.getElementById('featuredPreviewContainer').style.display = 'none';
    document.getElementById('featuredUploadZone').style.display = 'block';
    calculateLiveSeo();
}

// Toggle optional URL input
function toggleUrlInput() {
    var container = document.getElementById('urlInputContainer');
    var isHidden = container.style.display === 'none';
    container.style.display = isHidden ? 'block' : 'none';
    document.getElementById('toggleUrlText').textContent = isHidden ? 'Sembunyikan input URL' : 'Atau gunakan URL Gambar Web';
}

function handleUrlImageInput(url) {
    if (url.length > 5) {
        document.getElementById('featuredPreviewImg').src = url;
        document.getElementById('featuredPreviewContainer').style.display = 'block';
        document.getElementById('featuredUploadZone').style.display = 'none';
    }
    calculateLiveSeo();
}

// Live SEO Calculator
function calculateLiveSeo() {
    var title = (document.getElementById('title') ? document.getElementById('title').value : '').trim();
    var content = '';
    if (typeof $ !== 'undefined' && $('#content').summernote) {
        content = $('#content').summernote('code') || '';
    } else if (document.getElementById('content')) {
        content = document.getElementById('content').value;
    }
    var excerpt = (document.getElementById('excerpt') ? document.getElementById('excerpt').value : '').trim();
    var aiSummary = (document.getElementById('ai_summary') ? document.getElementById('ai_summary').value : '').trim();
    var hasLocalImage = document.getElementById('imageFileInput') && document.getElementById('imageFileInput').files.length > 0;
    var hasUrlImage = (document.getElementById('image') ? document.getElementById('image').value : '').trim().length > 5;
    var hasExistingImage = document.getElementById('featuredPreviewContainer') && document.getElementById('featuredPreviewContainer').style.display !== 'none';
    var hasImage = hasLocalImage || hasUrlImage || hasExistingImage;
    var categoryId = document.getElementById('category_id') ? document.getElementById('category_id').value : '';
    
    var checkedTags = document.querySelectorAll('input[name="tags[]"]:checked').length;
    var plainText = content.replace(/<[^>]*>/g, ' ').replace(/&nbsp;/g, ' ').trim();
    var words = plainText ? plainText.split(/\s+/).filter(Boolean).length : 0;
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
        elAi.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Ringkasan AI siap</span>';
    } else if (aiPoints >= 1) {
        score += 12;
        elAi.innerHTML = '<i class="fas fa-check-circle" style="color: #34d399;"></i> <span>Ringkasan AI (' + aiPoints + ' poin)</span>';
    } else {
        score += 8;
        elAi.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #fbbf24;"></i> <span>Otomatis diekstrak dari konten</span>';
    }

    // 5. Image (10 pts)
    var elImage = document.getElementById('checkImage');
    if (hasImage) {
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
</script>
@endpush
