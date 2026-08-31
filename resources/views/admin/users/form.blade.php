@extends('layouts.admin')

@php
    $isEdit = isset($user);
@endphp

@section('title', ($isEdit ? 'Edit Pengguna: ' . $user->name : 'Tambah Pengguna Baru') . ' – Admin Panel')
@section('page_title', $isEdit ? 'Edit Data Pengguna' : 'Tambah Pengguna Baru')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $isEdit ? 'Form Edit Pengguna' : 'Form Registrasi Pengguna Baru' }}</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary" style="background-color: var(--admin-muted);">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        @if($errors->any())
            <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 18px;">
                <ul style="padding-left: 18px; margin: 0;">
                    @foreach($errors->all() as $err)
                        <li style="margin-bottom: 4px;">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $isEdit ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">Nama Lengkap <span style="color: #dc2626;">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $isEdit ? $user->name : '') }}"
                    placeholder="Contoh: Redaksi SmartNews"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Alamat Email <span style="color: #dc2626;">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $isEdit ? $user->email : '') }}"
                    placeholder="Contoh: admin@smartnews.id"
                    required
                >
            </div>

            <div class="form-group">
                <label for="role">Hak Akses & Peran (Role) <span style="color: #dc2626;">*</span></label>
                <select name="role" id="role" class="form-control" required style="cursor: pointer; font-weight: 600;">
                    <option value="author" {{ old('role', $isEdit ? $user->role : 'author') === 'author' ? 'selected' : '' }}>
                        ✍️ Wartawan / Jurnalis (Hanya dapat mengelola artikel milik sendiri)
                    </option>
                    <option value="editor" {{ old('role', $isEdit ? $user->role : '') === 'editor' ? 'selected' : '' }}>
                        📝 Editor / Redaktur (Dapat mengelola semua berita, kategori, topik tags, komentar)
                    </option>
                    <option value="admin" {{ old('role', $isEdit ? $user->role : '') === 'admin' ? 'selected' : '' }}>
                        🛡️ Super Admin (Akses penuh seluruh menu, iklan, pengaturan website & pengguna)
                    </option>
                </select>
                <small style="display: block; margin-top: 6px; color: var(--admin-muted); font-size: 12px;">
                    Pilih wewenang dan hak akses dashboard yang sesuai untuk akun ini.
                </small>
            </div>

            <div class="form-group">
                <label for="password">
                    Password {{ $isEdit ? '(Kosongkan jika tidak ingin mengubah)' : '' }}
                    @if(!$isEdit) <span style="color: #dc2626;">*</span> @endif
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="{{ $isEdit ? 'Masukkan password baru...' : 'Minimal 6 karakter' }}"
                    {{ $isEdit ? '' : 'required' }}
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Konfirmasi Password {{ $isEdit ? '(Kosongkan jika tidak ingin mengubah)' : '' }}
                    @if(!$isEdit) <span style="color: #dc2626;">*</span> @endif
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password di atas..."
                    {{ $isEdit ? '' : 'required' }}
                >
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; border-top: 1px solid var(--admin-border); padding-top: 16px;">
                <a href="{{ route('admin.users.index') }}" class="btn" style="background-color: #e2e8f0; color: #334155;">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pengguna' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
