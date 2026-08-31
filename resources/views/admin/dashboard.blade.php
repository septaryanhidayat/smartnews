@extends('layouts.admin')

@section('page_title', 'Dashboard Ringkasan')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    .dashboard-layout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .dashboard-layout-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
    }
</style>
@endpush

@section('content')
<!-- Stats Cards -->
<div class="stats-grid">
    
    <div class="card" style="margin-bottom: 0; border-left: 4px solid #1a56db;">
        <div style="font-size: 12px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Total Artikel</div>
        <div style="font-size: 28px; font-weight: 800; color: #1a56db; margin-top: 4px;">{{ $stats['total_articles'] }}</div>
        <div style="font-size: 12px; color: #059669; margin-top: 4px;"><i class="fas fa-check"></i> {{ $stats['published_articles'] }} Dipublikasikan</div>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 4px solid #059669;">
        <div style="font-size: 12px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Total Pembaca (Views)</div>
        <div style="font-size: 28px; font-weight: 800; color: #059669; margin-top: 4px;">{{ number_format($stats['total_views']) }}</div>
        <div style="font-size: 12px; color: var(--admin-muted); margin-top: 4px;"><i class="fas fa-eye"></i> Di seluruh portal</div>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 4px solid #d97706;">
        <div style="font-size: 12px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Kategori & Tags</div>
        <div style="font-size: 28px; font-weight: 800; color: #d97706; margin-top: 4px;">{{ $stats['total_categories'] }} / {{ $stats['total_tags'] }}</div>
        <div style="font-size: 12px; color: var(--admin-muted); margin-top: 4px;"><i class="fas fa-folder"></i> Kategori aktif</div>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 4px solid #7c3aed;">
        <div style="font-size: 12px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Total Komentar</div>
        <div style="font-size: 28px; font-weight: 800; color: #7c3aed; margin-top: 4px;">{{ $stats['total_comments'] }}</div>
        <div style="font-size: 12px; color: var(--admin-muted); margin-top: 4px;"><i class="fas fa-comments"></i> Interaksi pembaca</div>
    </div>

</div>

<!-- Quick Actions & Top Articles -->
<div class="dashboard-layout-grid">
    
    <!-- Left: Latest Articles -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-newspaper"></i> Berita Terbaru Ditambahkan</h3>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tulis Berita
            </a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Judul Berita</th>
                        <th>Kategori</th>
                        <th>Pembaca</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestArticles as $art)
                    <tr>
                        <td>
                            <strong>{{ Str::limit($art->title, 45) }}</strong>
                            <div style="font-size: 11px; color: var(--admin-muted);">{{ $art->published_at ? $art->published_at->format('d M Y H:i') : '-' }}</div>
                        </td>
                        <td><span class="badge badge-info">{{ $art->category->name }}</span></td>
                        <td><strong>{{ number_format($art->views_count) }}</strong></td>
                        <td>
                            @if($art->status === 'published')
                                <span class="badge badge-success">Publish</span>
                            @else
                                <span class="badge badge-danger">Draft</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.articles.edit', $art->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right: Top 5 Most Viewed -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-fire" style="color: #dc2626;"></i> 5 Berita Terpopuler</h3>
        </div>
        <ul style="list-style: none;">
            @foreach($topArticles as $top)
            <li style="margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px dashed var(--admin-border);">
                <a href="{{ route('article.show', $top->slug) }}" target="_blank" style="font-weight: 700; color: var(--admin-primary); font-size: 13px; line-height: 1.3; display: block; margin-bottom: 4px;">
                    {{ $top->title }}
                </a>
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 11.5px; color: var(--admin-muted);">
                    <span>{{ $top->category->name }}</span>
                    <span><i class="fas fa-eye"></i> {{ number_format($top->views_count) }}</span>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

</div>
@endsection

