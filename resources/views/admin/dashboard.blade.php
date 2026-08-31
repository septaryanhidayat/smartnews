@extends('layouts.admin')

@section('page_title', 'Dashboard Ringkasan & Monitoring')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .dashboard-layout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    .category-bar {
        height: 8px;
        border-radius: 4px;
        background-color: var(--admin-border);
        overflow: hidden;
        margin-top: 4px;
    }
    .category-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.6s ease;
    }
    .log-terminal {
        background-color: #0f172a;
        color: #f8fafc;
        border-radius: 8px;
        padding: 16px;
        font-family: 'Consolas', 'Courier New', monospace;
        font-size: 12px;
        line-height: 1.6;
        max-height: 380px;
        overflow-y: auto;
    }
    .log-item {
        padding: 8px 12px;
        border-radius: 6px;
        margin-bottom: 8px;
        background-color: rgba(255, 255, 255, 0.04);
        border-left: 3px solid #64748b;
    }
    .log-item--error {
        border-left-color: #ef4444;
        background-color: rgba(239, 68, 68, 0.1);
    }
    .log-item--warning {
        border-left-color: #f59e0b;
        background-color: rgba(245, 158, 11, 0.1);
    }
    .log-item--info {
        border-left-color: #3b82f6;
        background-color: rgba(59, 130, 246, 0.08);
    }
    @media (max-width: 1280px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 1024px) {
        .dashboard-layout-grid {
            grid-template-columns: 1fr;
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<!-- 1. Stats Metric Cards (6 Columns) -->
<div class="stats-grid">
    
    <div class="card" style="margin-bottom: 0; border-left: 4px solid #1a56db;">
        <div style="font-size: 11.5px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Total Berita</div>
        <div style="font-size: 26px; font-weight: 800; color: #1a56db; margin-top: 4px;">{{ number_format($stats['total_articles']) }}</div>
        <div style="font-size: 11.5px; color: #059669; margin-top: 4px;"><i class="fas fa-check"></i> {{ $stats['published_articles'] }} Publish &bull; {{ $stats['draft_articles'] }} Draft</div>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 4px solid #059669;">
        <div style="font-size: 11.5px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Total Pembaca</div>
        <div style="font-size: 26px; font-weight: 800; color: #059669; margin-top: 4px;">{{ number_format($stats['total_views']) }}</div>
        <div style="font-size: 11.5px; color: var(--admin-muted); margin-top: 4px;"><i class="fas fa-chart-line"></i> Total artikel views</div>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 4px solid #dc2626;">
        <div style="font-size: 11.5px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Berita Baru</div>
        <div style="font-size: 26px; font-weight: 800; color: #dc2626; margin-top: 4px;">{{ $stats['today_articles'] }}</div>
        <div style="font-size: 11.5px; color: var(--admin-muted); margin-top: 4px;"><i class="fas fa-calendar-day"></i> Hari ini ({{ $stats['month_articles'] }} bln ini)</div>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 4px solid #d97706;">
        <div style="font-size: 11.5px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Kategori & Tags</div>
        <div style="font-size: 26px; font-weight: 800; color: #d97706; margin-top: 4px;">{{ $stats['total_categories'] }} / {{ $stats['total_tags'] }}</div>
        <div style="font-size: 11.5px; color: var(--admin-muted); margin-top: 4px;"><i class="fas fa-tags"></i> Rubrikasi aktif</div>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 4px solid #7c3aed;">
        <div style="font-size: 11.5px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Komentar</div>
        <div style="font-size: 26px; font-weight: 800; color: #7c3aed; margin-top: 4px;">{{ $stats['total_comments'] }}</div>
        <div style="font-size: 11.5px; color: {{ $stats['pending_comments'] > 0 ? '#dc2626' : 'var(--admin-muted)' }}; margin-top: 4px;">
            <i class="fas fa-comments"></i> {{ $stats['pending_comments'] }} menunggu moderasi
        </div>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 4px solid #0284c7;">
        <div style="font-size: 11.5px; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">Iklan & Tim Redaksi</div>
        <div style="font-size: 26px; font-weight: 800; color: #0284c7; margin-top: 4px;">{{ $stats['active_ads'] }} / {{ $stats['total_users'] }}</div>
        <div style="font-size: 11.5px; color: var(--admin-muted); margin-top: 4px;"><i class="fas fa-users-cog"></i> {{ $stats['active_ads'] }} banner iklan aktif</div>
    </div>

</div>

<!-- 2. Main Content Layout -->
<div class="dashboard-layout-grid">
    
    <!-- Left Column: Top Articles & Latest Articles -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Top Most Read Articles -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-fire" style="color: #dc2626;"></i> Berita Terpopuler (Paling Banyak Dibaca)</h3>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Judul Berita</th>
                            <th>Kategori</th>
                            <th style="text-align: right;">Total Pembaca</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topArticles as $idx => $top)
                        <tr>
                            <td>
                                <span style="display: inline-flex; width: 22px; height: 22px; border-radius: 50%; background: {{ $idx < 3 ? '#dc2626' : 'var(--admin-muted-bg)' }}; color: {{ $idx < 3 ? '#fff' : 'var(--admin-muted)' }}; font-weight: 800; font-size: 11px; align-items: center; justify-content: center;">
                                    {{ $idx + 1 }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('article.show', $top->slug) }}" target="_blank" style="font-weight: 700; color: var(--admin-primary);">
                                    {{ Str::limit($top->title, 60) }}
                                </a>
                                <div style="font-size: 11px; color: var(--admin-muted);">Oleh: {{ $top->user->name ?? 'Redaksi' }} &bull; {{ $top->published_at ? $top->published_at->format('d M Y') : '-' }}</div>
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $top->category->color ?? '#1a56db' }}15; color: {{ $top->category->color ?? '#1a56db' }}; font-weight: 700;">
                                    {{ $top->category->name }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <strong style="color: #059669; font-size: 13.5px;"><i class="fas fa-eye"></i> {{ number_format($top->views_count) }}</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Latest Articles -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clock"></i> Berita Terbaru Diterbitkan</h3>
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
                            <th>Status</th>
                            <th style="width: 90px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestArticles as $art)
                        <tr>
                            <td>
                                <strong>{{ Str::limit($art->title, 55) }}</strong>
                                <div style="font-size: 11px; color: var(--admin-muted);">
                                    {{ $art->published_at ? $art->published_at->format('d M Y H:i') : '-' }}
                                    @if($art->is_sticky)
                                        &bull; <span style="color: #dc2626; font-weight: 700;"><i class="fas fa-thumbtack"></i> Sticky</span>
                                    @endif
                                </div>
                            </td>
                            <td><span class="badge badge-info">{{ $art->category->name }}</span></td>
                            <td>
                                @if($art->status === 'published')
                                    <span class="badge badge-success">Publish</span>
                                @else
                                    <span class="badge badge-danger">Draft</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.articles.edit', $art->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Right Column: Category Breakdown & Recent Comments -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Category Distribution Progress Bars -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Sebaran Rubrikasi Berita</h3>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">Kelola</a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 14px;">
                @php
                    $maxCatArticles = $categoryDistribution->max('articles_count') ?: 1;
                @endphp
                @foreach($categoryDistribution as $catDist)
                @php
                    $pct = round(($catDist->articles_count / max(1, $stats['total_articles'])) * 100);
                @endphp
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; font-weight: 600; margin-bottom: 2px;">
                        <span style="color: {{ $catDist->color ?? 'var(--admin-text)' }};">
                            <i class="fas fa-folder" style="font-size: 11px;"></i> {{ $catDist->name }}
                        </span>
                        <span style="color: var(--admin-muted);">{{ $catDist->articles_count }} berita ({{ $pct }}%)</span>
                    </div>
                    <div class="category-bar">
                        <div class="category-bar-fill" style="width: {{ $pct }}%; background-color: {{ $catDist->color ?? '#1a56db' }};"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Latest Comments -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-comments"></i> Komentar Pembaca Terbaru</h3>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-secondary">Moderasi</a>
            </div>
            @if($latestComments->count() > 0)
            <ul style="list-style: none;">
                @foreach($latestComments as $comment)
                <li style="margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px dashed var(--admin-border);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3px;">
                        <strong style="font-size: 12.5px; color: var(--admin-text);">{{ $comment->name }}</strong>
                        <span style="font-size: 10.5px; color: var(--admin-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p style="font-size: 12px; color: var(--admin-muted); line-height: 1.4; margin-bottom: 4px;">
                        "{{ Str::limit($comment->comment, 80) }}"
                    </p>
                    <div style="font-size: 11px; color: var(--admin-primary);">
                        <i class="fas fa-link"></i> {{ Str::limit($comment->article->title ?? 'Artikel', 35) }}
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <p style="font-size: 12.5px; color: var(--admin-muted); text-align: center; padding: 16px 0;">Belum ada komentar pembaca.</p>
            @endif
        </div>

    </div>

</div>

<!-- 3. System Error Logs & Live Monitoring Console -->
<div class="card">
    <div class="card-header" style="flex-wrap: wrap; gap: 12px;">
        <div>
            <h3 class="card-title"><i class="fas fa-terminal"></i> Log Error & Monitoring Sistem</h3>
            <p style="font-size: 12px; color: var(--admin-muted); margin-top: 2px;">
                Memantau rekaman error, warning, dan status eksekusi server secara real-time.
            </p>
        </div>
        <div style="display: flex; gap: 8px;">
            <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Bersihkan seluruh catatan log error sistem?');">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash-alt"></i> Bersihkan Log
                </button>
            </form>
        </div>
    </div>

    @if(count($logs) > 0)
    <div class="log-terminal">
        @foreach($logs as $log)
        <div class="log-item log-item--{{ strtolower($log['level']) }}">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 4px;">
                <div>
                    <span class="badge badge-{{ $log['level'] === 'ERROR' ? 'danger' : ($log['level'] === 'WARNING' ? 'warning' : 'info') }}" style="font-size: 10px; padding: 2px 6px;">
                        {{ $log['level'] }}
                    </span>
                    <span style="color: #94a3b8; font-size: 11px; margin-left: 6px;">{{ $log['timestamp'] }}</span>
                </div>
                <span style="color: #64748b; font-size: 10.5px;">{{ $log['env'] }}</span>
            </div>
            <div style="color: #f1f5f9; font-weight: 600; word-break: break-all;">
                {{ $log['message'] }}
            </div>
            @if($log['trace'])
            <details style="margin-top: 6px; font-size: 11px; color: #94a3b8;">
                <summary style="cursor: pointer; color: #38bdf8;">Lihat Stack Trace</summary>
                <pre style="margin-top: 6px; padding: 8px; background: rgba(0,0,0,0.4); border-radius: 4px; overflow-x: auto; white-space: pre-wrap; font-size: 10.5px; color: #cbd5e1;">{{ $log['trace'] }}</pre>
            </details>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div style="padding: 24px; text-align: center; background-color: var(--admin-muted-bg); border-radius: 8px;">
        <i class="fas fa-check-circle" style="font-size: 32px; color: #059669; margin-bottom: 8px;"></i>
        <h4 style="font-size: 14px; font-weight: 700; color: var(--admin-text);">Sistem Berjalan Normal & Optimal</h4>
        <p style="font-size: 12px; color: var(--admin-muted); margin-top: 4px;">Tidak ada error atau peringatan sistem yang tercatat pada log server.</p>
    </div>
    @endif
</div>
@endsection
