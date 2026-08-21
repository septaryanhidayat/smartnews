@extends('layouts.admin')

@section('page_title', 'Kelola Komentar Pembaca')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Seluruh Komentar ({{ $comments->total() }})</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>Pengirim</th>
                <th>Komentar</th>
                <th>Pada Artikel</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $comment)
            <tr>
                <td>
                    <strong>{{ $comment->name }}</strong>
                    <div style="font-size: 11px; color: var(--admin-muted);">{{ $comment->email }}</div>
                </td>
                <td style="max-width: 320px;">
                    <p style="font-size: 13px; line-height: 1.4;">{{ $comment->comment }}</p>
                </td>
                <td>
                    <a href="{{ route('article.show', $comment->article->slug) }}" target="_blank" style="color: var(--admin-primary); font-weight: 600; font-size: 13px;">
                        {{ Str::limit($comment->article->title, 35) }}
                    </a>
                </td>
                <td style="font-size: 12px; color: var(--admin-muted);">
                    {{ $comment->created_at->diffForHumans() }}
                </td>
                <td>
                    @if($comment->is_approved)
                        <span class="badge badge-success">Disetujui</span>
                    @else
                        <span class="badge badge-danger">Ditahan</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.comments.toggle', $comment->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $comment->is_approved ? 'btn-danger' : 'btn-success' }}" title="{{ $comment->is_approved ? 'Sembunyikan' : 'Setujui' }}">
                            <i class="fas {{ $comment->is_approved ? 'fa-eye-slash' : 'fa-check' }}"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus komentar ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: var(--admin-muted);">
                    Belum ada komentar dari pembaca.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $comments->links() }}
    </div>
</div>
@endsection
