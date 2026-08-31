@extends('layouts.app')

@section('title', 'Login Pengguna – SmartNews')

@section('content')
<main id="mainContent" class="main-layout">
    <div class="container" style="max-width: 480px; margin-top: 30px;">
        <div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 32px; box-shadow: var(--shadow-md);">
            
            <div style="text-align: center; margin-bottom: 24px;">
                <a href="{{ route('home') }}" style="display: inline-block; margin-bottom: 12px;">
                    <img src="{{ asset('images/logo.svg') }}" alt="SmartNews Logo" class="site-logo-main" style="height: 44px; margin: 0 auto;">
                </a>
                <h2 style="font-size: 20px; font-weight: 700; margin-top: 8px;">Masuk ke Akun Redaksi</h2>
                <p style="font-size: 13px; color: var(--text-muted);">Gunakan email dan password terdaftar Anda</p>
            </div>

            @if($errors->any())
                <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: var(--radius-md); margin-bottom: 18px; font-size: 13.5px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', 'admin@smartnews.id') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="form-control" value="password" required>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; font-size: 13px;">
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                        <input type="checkbox" name="remember" value="1"> Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-submit" style="width: 100%; padding: 12px;">
                    <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                </button>
            </form>

            <div style="text-align: center; margin-top: 20px; font-size: 13px; color: var(--text-muted);">
                Belum punya akun? <a href="{{ route('register') }}" style="color: var(--color-primary); font-weight: 600;">Daftar Akun Baru</a>
            </div>
            
            <div style="margin-top: 18px; padding: 10px; background-color: var(--bg-muted); border-radius: var(--radius-sm); font-size: 12px; text-align: center; color: var(--text-muted);">
                Demo Admin: <strong>admin@smartnews.id</strong> | Password: <strong>password</strong>
            </div>

        </div>
    </div>
</main>
@endsection
