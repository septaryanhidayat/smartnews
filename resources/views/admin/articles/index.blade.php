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
    <form action="{{ route('admin.articles.index') }}" method="GET" style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" class="form-control" style="max-width: 240px;" placeholder="Cari judul berita..." value="{{ $search }}">
        <select name="category_id" class="form-control" style="max-width: 170px;">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="form-control" style="max-width: 140px;">
            <option value="">Semua Status</option>
            <option value="published" {{ $status == 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ $status == 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        <select name="per_page" class="form-control" style="max-width: 130px;" onchange="this.form.submit()">
            <option value="20" {{ ($perPageInput ?? '20') == '20' ? 'selected' : '' }}>Tampil 20</option>
            <option value="50" {{ ($perPageInput ?? '') == '50' ? 'selected' : '' }}>Tampil 50</option>
            <option value="100" {{ ($perPageInput ?? '') == '100' ? 'selected' : '' }}>Tampil 100</option>
            <option value="500" {{ ($perPageInput ?? '') == '500' ? 'selected' : '' }}>Tampil 500</option>
            <option value="all" {{ ($perPageInput ?? '') == 'all' || ($perPageInput ?? '') == 'semua' ? 'selected' : '' }}>Tampil Semua</option>
        </select>
        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
        @if($search || $categoryId || $status || ($perPageInput ?? '20') != '20')
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary" style="background-color: #94a3b8; color: #fff;"><i class="fas fa-undo"></i> Reset</a>
        @endif
    </form>

    <table>
        <thead>
            <tr>
                <th style="width: 55px;">Gambar</th>
                <th>Judul Berita</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Skor SEO AI</th>
                <th>Views</th>
                <th>Status</th>
                <th>Headline</th>
                <th style="width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $art)
            @php
                $seo = $art->seo_analysis;
            @endphp
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
                <td>
                    <button type="button" onclick='openSeoModal(@json($seo), @json($art->title), "{{ route('admin.articles.edit', $art->id) }}")' 
                            style="border: 1px solid {{ $seo['badge_color'] }}40; background-color: {{ $seo['badge_bg'] }}; color: {{ $seo['badge_color'] }}; padding: 4px 9px; border-radius: 999px; font-weight: 800; font-size: 11.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; transition: transform 0.15s ease;"
                            onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                            title="Klik untuk melihat Audit & Rekomendasi SEO AI">
                        <i class="fas fa-robot"></i> {{ $seo['score'] }}/100 <span style="font-size: 10px; opacity: 0.9;">({{ $seo['grade'] }})</span>
                    </button>
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
                    <form action="{{ route('admin.articles.toggle-sticky', $art->id) }}" method="POST" style="display: inline-block; margin-bottom: 2px;">
                        @csrf
                        @if($art->is_sticky)
                            <button type="submit" class="badge badge-danger" style="border: none; cursor: pointer; padding: 4px 8px; font-weight: 700;" title="Klik untuk menonaktifkan Berita Utama">
                                <i class="fas fa-thumbtack"></i> Sticky
                            </button>
                        @else
                            <button type="submit" class="badge" style="border: 1px solid var(--admin-border); background-color: var(--admin-muted-bg, #f1f5f9); color: var(--admin-muted, #64748b); cursor: pointer; padding: 3px 6px; font-size: 11px;" title="Klik untuk menjadikan Berita Utama (Sticky Post)">
                                <i class="fas fa-thumbtack"></i> Set
                            </button>
                        @endif
                    </form>
                    @if($art->is_slider)
                        <span class="badge badge-info" title="Tampil di Hero Slider"><i class="fas fa-images"></i> Slider</span>
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
                <td colspan="9" style="text-align: center; padding: 30px; color: var(--admin-muted);">
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

<!-- MODAL AI SEO AUDIT & OPTIMIZATION -->
<div id="seoAuditModal" style="display: none; position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.75); z-index: 9999; align-items: center; justify-content: center; padding: 16px; backdrop-filter: blur(4px);">
    <div style="background-color: var(--admin-card-bg, #ffffff); border-radius: 12px; width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2); border: 1px solid var(--admin-border);">
        <!-- Modal Header -->
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between; background: linear-gradient(135deg, #1e293b, #0f172a); color: #ffffff; border-radius: 12px 12px 0 0;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(59, 130, 246, 0.2); color: #60a5fa; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: #f8fafc;">Analisa Skor SEO Berita AI</h3>
                    <p style="font-size: 11.5px; color: #94a3b8; margin: 2px 0 0 0;">Audit otomatis algoritma Google Helpful Content & Discover</p>
                </div>
            </div>
            <button type="button" onclick="closeSeoModal()" style="background: none; border: none; color: #94a3b8; font-size: 18px; cursor: pointer; padding: 4px 8px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div style="padding: 20px;">
            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--admin-muted); margin-bottom: 4px;">Judul Berita:</div>
                <div id="modalArticleTitle" style="font-size: 14px; font-weight: 700; color: var(--admin-text); line-height: 1.4;"></div>
            </div>

            <!-- Score Summary Box -->
            <div style="display: flex; align-items: center; gap: 16px; background-color: var(--admin-muted-bg, #f8fafc); padding: 14px 18px; border-radius: 10px; border: 1px solid var(--admin-border); margin-bottom: 20px;">
                <div id="modalScoreCircle" style="width: 64px; height: 64px; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; font-weight: 800; font-size: 18px; color: #ffffff; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <span id="modalScoreNum">95</span>
                    <span id="modalScoreGrade" style="font-size: 10px; opacity: 0.9;">A+</span>
                </div>
                <div style="flex: 1;">
                    <div id="modalScoreGradeText" style="font-size: 15px; font-weight: 800; color: var(--admin-text);">Sangat Baik (Optimal)</div>
                    <div style="font-size: 12px; color: var(--admin-muted); margin-top: 3px;">
                        <span id="modalWordCount">0</span> kata &bull; <span id="modalTitleLen">0</span> karakter judul
                    </div>
                </div>
            </div>

            <!-- Checklist Parameters -->
            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; font-weight: 700; color: var(--admin-text); margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-tasks" style="color: var(--admin-primary);"></i> Parameter Audit SEO:
                </div>
                <div id="modalChecklist" style="display: flex; flex-direction: column; gap: 8px;"></div>
            </div>

            <!-- AI Recommendations / Suggestions -->
            <div style="background-color: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.2); border-radius: 8px; padding: 14px;">
                <div style="font-size: 12.5px; font-weight: 700; color: #4f46e5; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-lightbulb"></i> Rekomendasi Optimasi AI:
                </div>
                <ul id="modalSuggestions" style="margin: 0; padding-left: 18px; font-size: 12.5px; color: var(--admin-text); line-height: 1.5;"></ul>
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="padding: 14px 20px; border-top: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between; background-color: var(--admin-muted-bg, #f8fafc); border-radius: 0 0 12px 12px;">
            <button type="button" onclick="closeSeoModal()" class="btn btn-sm btn-secondary" style="background-color: #94a3b8; color: #fff;">Tutup</button>
            <a id="modalEditLink" href="#" class="btn btn-sm btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-edit"></i> Edit & Optimalkan Artikel
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openSeoModal(seo, title, editUrl) {
    document.getElementById('modalArticleTitle').textContent = title;
    document.getElementById('modalScoreNum').textContent = seo.score;
    document.getElementById('modalScoreGrade').textContent = seo.grade;
    document.getElementById('modalScoreGradeText').textContent = seo.grade_text;
    document.getElementById('modalWordCount').textContent = seo.word_count;
    document.getElementById('modalTitleLen').textContent = seo.title_length;
    document.getElementById('modalScoreCircle').style.backgroundColor = seo.badge_color;
    document.getElementById('modalEditLink').href = editUrl;

    var checklistHtml = '';
    seo.checklist.forEach(function(item) {
        var isPass = item.status === 'pass';
        var icon = isPass ? '<i class="fas fa-check-circle" style="color: #059669; font-size: 15px;"></i>' 
                          : (item.status === 'warn' ? '<i class="fas fa-exclamation-triangle" style="color: #d97706; font-size: 15px;"></i>' 
                                                    : '<i class="fas fa-times-circle" style="color: #dc2626; font-size: 15px;"></i>');
        var bg = isPass ? 'rgba(5, 150, 105, 0.04)' : (item.status === 'warn' ? 'rgba(217, 119, 6, 0.05)' : 'rgba(220, 38, 38, 0.05)');
        
        checklistHtml += '<div style="display: flex; align-items: flex-start; gap: 10px; padding: 8px 12px; border-radius: 6px; background-color: ' + bg + ';">' +
            '<div style="flex-shrink: 0; margin-top: 2px;">' + icon + '</div>' +
            '<div style="font-size: 12.5px;">' +
                '<strong style="color: var(--admin-text);">' + item.label + '</strong>' +
                '<div style="color: var(--admin-muted); font-size: 11.5px; margin-top: 1px;">' + item.detail + '</div>' +
            '</div>' +
        '</div>';
    });
    document.getElementById('modalChecklist').innerHTML = checklistHtml;

    var sugHtml = '';
    seo.suggestions.forEach(function(sug) {
        sugHtml += '<li style="margin-bottom: 4px;">' + sug + '</li>';
    });
    document.getElementById('modalSuggestions').innerHTML = sugHtml;

    document.getElementById('seoAuditModal').style.display = 'flex';
}

function closeSeoModal() {
    document.getElementById('seoAuditModal').style.display = 'none';
}

// Close on backdrop click
window.onclick = function(event) {
    var modal = document.getElementById('seoAuditModal');
    if (event.target === modal) {
        closeSeoModal();
    }
}
</script>
@endpush
@endsection
