@extends('layouts.app')

@section('title', 'Daftar Akun – SmartNews')

@section('content')
<main id="mainContent" class="main-layout">
    <div class="container" style="max-width: 500px; margin-top: 30px;">
        <div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 32px; box-shadow: var(--shadow-md);">
            
            <div style="text-align: center; margin-bottom: 24px;">
                <a href="{{ route('home') }}" style="display: inline-block; margin-bottom: 12px;">
                    <img src="{{ asset('images/logo.svg') }}" alt="SmartNews Logo" class="site-logo-main" style="height: 44px; margin: 0 auto;">
                </a>
                <h2 style="font-size: 20px; font-weight: 700; margin-top: 8px;">Daftar Akun Baru</h2>
                <p style="font-size: 13px; color: var(--text-muted);">Bergabunglah dengan komunitas pembaca & jurnalis SmartNews</p>
            </div>

            @if($errors->any())
                <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: var(--radius-md); margin-bottom: 18px; font-size: 13.5px;">
                    <ul style="list-style: disc; margin-left: 16px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Bima Saputra" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi (Min. 8 Karakter)</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-submit" style="width: 100%; padding: 12px; margin-top: 10px;">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>
            </form>

            <div style="text-align: center; margin-top: 20px; font-size: 13px; color: var(--text-muted);">
                Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--color-primary); font-weight: 600;">Masuk di sini</a>
            </div>

        </div>
    </div>
</main>
@endsection
