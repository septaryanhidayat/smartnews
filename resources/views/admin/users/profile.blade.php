@extends('layouts.admin')

@section('title', 'Pengaturan Profil - Admin Panel')
@section('page_title', 'Pengaturan Profil Akun')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">Profil & Keamanan Akun</h3>
                <p style="font-size: 12.5px; color: var(--admin-muted); margin-top: 4px;">Ubah nama profil, alamat email, dan ganti password akun Anda.</p>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 50%; background-color: #3b82f6; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px;">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 18px;">
                <ul style="padding-left: 18px; margin: 0;">
                    @foreach($errors->all() as $err)
                        <li style="margin-bottom: 4px;">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 14px; color: var(--admin-primary); display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-user-circle"></i> Informasi Dasar
            </h4>

            <div class="form-group">
                <label for="name">Nama Lengkap <span style="color: #dc2626;">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $user->name) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Alamat Email Login <span style="color: #dc2626;">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $user->email) }}"
                    required
                >
            </div>

            <h4 style="font-size: 14px; font-weight: 700; margin: 24px 0 14px; color: var(--admin-primary); display: flex; align-items: center; gap: 6px; border-top: 1px solid var(--admin-border); padding-top: 18px;">
                <i class="fas fa-lock"></i> Ganti Password (Opsional)
            </h4>
            <p style="font-size: 12.5px; color: var(--admin-muted); margin-bottom: 14px;">Kosongkan form password di bawah jika Anda tidak bermaksud mengganti password.</p>

            <div class="form-group">
                <label for="current_password">Password Saat Ini</label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    class="form-control"
                    placeholder="Masukkan password saat ini untuk verifikasi"
                >
            </div>

            <div class="form-group">
                <label for="new_password">Password Baru</label>
                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    class="form-control"
                    placeholder="Minimal 6 karakter"
                >
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                <input
                    type="password"
                    id="new_password_confirmation"
                    name="new_password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password baru"
                >
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; border-top: 1px solid var(--admin-border); padding-top: 16px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Perbarui Profil Saya
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
