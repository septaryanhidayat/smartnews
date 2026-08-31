@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Admin Panel')
@section('page_title', 'Kelola Pengguna (User Management)')

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Daftar Pengguna & Penulis</h3>
            <p style="font-size: 12.5px; color: var(--admin-muted); margin-top: 4px;">Kelola akun administrator, editor, dan jurnalis portal berita.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 18px; font-weight: 600;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Nama Pengguna</th>
                    <th>Alamat Email</th>
                    <th>Peran / Role</th>
                    <th>Jumlah Berita</th>
                    <th>Tanggal Terdaftar</th>
                    <th style="width: 140px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="font-weight: 700; color: var(--admin-muted);">#{{ $user->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #e0e7ff; color: #3730a3; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 14px;">
                                        {{ $user->name }}
                                        @if($user->id === Auth::id())
                                            <span class="badge badge-info" style="margin-left: 4px;">Akun Anda</span>
                                        @endif
                                    </div>
                                    <div style="font-size: 12px; color: var(--admin-muted);">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-family: monospace; font-size: 13px; color: #334155;">{{ $user->email }}</span>
                        </td>
                        <td>
                            {!! $user->role_badge_html !!}
                        </td>
                        <td>
                            <span class="badge badge-success" style="font-size: 12px;">
                                <i class="fas fa-newspaper"></i> {{ $user->articles_count }} Artikel
                            </span>
                        </td>
                        <td style="font-size: 12.5px; color: var(--admin-muted);">
                            {{ $user->created_at ? $user->created_at->translatedFormat('d M Y, H:i') : '-' }}
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 6px;">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Edit Pengguna">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Pengguna">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 32px; color: var(--admin-muted);">
                            <i class="fas fa-users" style="font-size: 32px; margin-bottom: 8px; opacity: 0.5;"></i>
                            <p>Belum ada data pengguna lainnya.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div style="margin-top: 20px;">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
