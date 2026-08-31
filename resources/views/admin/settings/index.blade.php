@extends('layouts.admin')

@section('title', 'Pengaturan Website & SEO – Admin Panel')
@section('page_title', 'Pengaturan Website, Logo & SEO')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 22px; font-weight: 500;">
            <div style="font-weight: 700; margin-bottom: 6px;"><i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan validasi:</div>
            <ul style="padding-left: 20px; margin: 0;">
                @foreach($errors->all() as $err)
                    <li style="margin-bottom: 3px;">{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- 1. IDENTITAS & UPLOAD LOGO -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title"><i class="fas fa-image" style="color: var(--admin-primary); margin-right: 6px;"></i> Identitas & Logo Website</h3>
                    <p style="font-size: 12.5px; color: var(--admin-muted); margin-top: 4px;">Pilih file gambar logo dan favicon dari komputer Anda.</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px;">
                
                <!-- Logo Utama -->
                <div style="background-color: #f8fafc; border: 1px dashed var(--admin-border); border-radius: 8px; padding: 16px; text-align: center;">
                    <label style="display: block; font-weight: 700; font-size: 13px; margin-bottom: 8px;">Logo Utama (Light Mode)</label>
                    <div style="height: 60px; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; padding: 6px; margin-bottom: 10px;">
                        <img src="{{ site_logo() }}" alt="Logo Preview" id="previewSiteLogo" style="max-height: 44px; max-width: 100%; object-fit: contain;">
                    </div>
                    <input type="file" name="site_logo" id="inputSiteLogo" class="form-control" style="font-size: 12px; padding: 6px;" accept="image/*" onchange="previewImg(this, 'previewSiteLogo')">
                    <span style="font-size: 11px; color: var(--admin-muted); display: block; margin-top: 4px;">PNG, SVG, WebP, JPG</span>
                </div>

                <!-- Logo Dark / Footer -->
                <div style="background-color: #f8fafc; border: 1px dashed var(--admin-border); border-radius: 8px; padding: 16px; text-align: center;">
                    <label style="display: block; font-weight: 700; font-size: 13px; margin-bottom: 8px;">Logo Putih (Dark & Footer)</label>
                    <div style="height: 60px; background-color: #0b0f19; border: 1px solid #1e293b; border-radius: 6px; display: flex; align-items: center; justify-content: center; padding: 6px; margin-bottom: 10px;">
                        <img src="{{ site_logo_dark() }}" alt="Dark Logo Preview" id="previewSiteLogoDark" style="max-height: 44px; max-width: 100%; object-fit: contain;">
                    </div>
                    <input type="file" name="site_logo_dark" id="inputSiteLogoDark" class="form-control" style="font-size: 12px; padding: 6px;" accept="image/*" onchange="previewImg(this, 'previewSiteLogoDark')">
                    <span style="font-size: 11px; color: var(--admin-muted); display: block; margin-top: 4px;">PNG, SVG, WebP, JPG</span>
                </div>

                <!-- Favicon -->
                <div style="background-color: #f8fafc; border: 1px dashed var(--admin-border); border-radius: 8px; padding: 16px; text-align: center;">
                    <label style="display: block; font-weight: 700; font-size: 13px; margin-bottom: 8px;">Favicon Tab Browser</label>
                    <div style="height: 60px; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; padding: 6px; margin-bottom: 10px;">
                        <img src="{{ site_favicon() }}" alt="Favicon Preview" id="previewSiteFavicon" style="max-height: 36px; max-width: 36px; object-fit: contain;">
                    </div>
                    <input type="file" name="site_favicon" id="inputSiteFavicon" class="form-control" style="font-size: 12px; padding: 6px;" accept="image/*" onchange="previewImg(this, 'previewSiteFavicon')">
                    <span style="font-size: 11px; color: var(--admin-muted); display: block; margin-top: 4px;">ICO, PNG, SVG (32x32px)</span>
                </div>

            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="site_name">Nama Portal Berita <span style="color: #dc2626;">*</span></label>
                    <input
                        type="text"
                        id="site_name"
                        name="site_name"
                        class="form-control"
                        value="{{ old('site_name', $settings['site_name'] ?? 'SmartNews') }}"
                        placeholder="Contoh: SmartNews"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="site_tagline">Slogan / Tagline Portal</label>
                    <input
                        type="text"
                        id="site_tagline"
                        name="site_tagline"
                        class="form-control"
                        value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Portal Berita Terpercaya & Cerdas') }}"
                        placeholder="Contoh: Portal Berita Terpercaya & Cerdas"
                    >
                </div>
            </div>
        </div>

        <!-- 2. PENGATURAN TAMPILAN BERITA SLIDER / HEADLINE ATAS -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title"><i class="fas fa-sliders-h" style="color: #6366f1; margin-right: 6px;"></i> Pengaturan Slider Berita Headline (Bagian Atas)</h3>
                    <p style="font-size: 12.5px; color: var(--admin-muted); margin-top: 4px;">Atur jumlah kartu berita yang tampil berdampingan pada slider atas di layar komputer/desktop.</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="hero_slider_count">
                        Jumlah Berita Ditampilkan Sekaligus (Desktop)
                        <span style="font-weight: normal; font-size: 12px; color: var(--admin-muted);">(Default: 3)</span>
                    </label>
                    <select id="hero_slider_count" name="hero_slider_count" class="form-control" style="font-weight: 600;">
                        @php
                            $currentCount = (int) old('hero_slider_count', $settings['hero_slider_count'] ?? 3);
                        @endphp
                        <option value="2" {{ $currentCount == 2 ? 'selected' : '' }}>2 Berita (Ekstra Lebar)</option>
                        <option value="3" {{ $currentCount == 3 ? 'selected' : '' }}>3 Berita (Standar / Default)</option>
                        <option value="4" {{ $currentCount == 4 ? 'selected' : '' }}>4 Berita (Sedang)</option>
                        <option value="5" {{ $currentCount == 5 ? 'selected' : '' }}>5 Berita (Ramping)</option>
                        <option value="6" {{ $currentCount == 6 ? 'selected' : '' }}>6 Berita (Kompak)</option>
                        <option value="7" {{ $currentCount == 7 ? 'selected' : '' }}>7 Berita (Padat)</option>
                        <option value="8" {{ $currentCount == 8 ? 'selected' : '' }}>8 Berita (Mini)</option>
                    </select>
                </div>

                <div style="background-color: #f1f5f9; border-left: 4px solid #6366f1; border-radius: 6px; padding: 12px 16px; font-size: 12.5px; color: #334155; line-height: 1.5;">
                    <strong style="display: block; color: #1e293b; margin-bottom: 3px;"><i class="fas fa-info-circle" style="color: #6366f1;"></i> Penyesuaian Otomatis:</strong>
                    Semakin banyak jumlah berita yang dipilih (misal 5 atau 7), ukuran kartu, foto, dan ukuran teks judul berita akan otomatis mengecil dan meramping agar pas dan rapi dalam 1 baris tampilan.
                </div>
            </div>
        </div>

        <!-- 3. PENGATURAN PEMUATAN BERITA (LOAD MORE & PAGINATION) -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title"><i class="fas fa-sync-alt" style="color: #0284c7; margin-right: 6px;"></i> Metode Pemuatan Berita Beranda (Feed Pagination)</h3>
                    <p style="font-size: 12.5px; color: var(--admin-muted); margin-top: 4px;">Pilih bagaimana pengunjung memuat daftar berita berikutnya di halaman utama (Berita Terkini).</p>
                </div>
            </div>

            @php
                $currentPagType = old('pagination_type', $settings['pagination_type'] ?? 'button');
            @endphp
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                <label style="border: 2px solid {{ $currentPagType === 'button' ? '#0284c7' : 'var(--admin-border)' }}; background-color: {{ $currentPagType === 'button' ? '#f0f9ff' : 'var(--admin-card-bg)' }}; border-radius: 10px; padding: 16px; cursor: pointer; display: flex; flex-direction: column; gap: 8px; transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-weight: 700; font-size: 14px; color: #0f172a;"><i class="fas fa-hand-pointer" style="color: #0284c7; margin-right: 4px;"></i> Tombol Klik</span>
                        <input type="radio" name="pagination_type" value="button" {{ $currentPagType === 'button' ? 'checked' : '' }}>
                    </div>
                    <p style="font-size: 12px; color: var(--admin-muted); margin: 0; line-height: 1.4;">Pengunjung mengklik tombol <strong>"Muat Lainnya"</strong> untuk memuat artikel selanjutnya.</p>
                </label>

                <label style="border: 2px solid {{ $currentPagType === 'infinite' ? '#0284c7' : 'var(--admin-border)' }}; background-color: {{ $currentPagType === 'infinite' ? '#f0f9ff' : 'var(--admin-card-bg)' }}; border-radius: 10px; padding: 16px; cursor: pointer; display: flex; flex-direction: column; gap: 8px; transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-weight: 700; font-size: 14px; color: #0f172a;"><i class="fas fa-arrows-alt-v" style="color: #0284c7; margin-right: 4px;"></i> Otomatis Scroll</span>
                        <input type="radio" name="pagination_type" value="infinite" {{ $currentPagType === 'infinite' ? 'checked' : '' }}>
                    </div>
                    <p style="font-size: 12px; color: var(--admin-muted); margin: 0; line-height: 1.4;">Berita otomatis termuat tanpa henti saat pengunjung menggulir layar ke bawah (Infinite Scroll).</p>
                </label>

                <label style="border: 2px solid {{ $currentPagType === 'pagination' ? '#0284c7' : 'var(--admin-border)' }}; background-color: {{ $currentPagType === 'pagination' ? '#f0f9ff' : 'var(--admin-card-bg)' }}; border-radius: 10px; padding: 16px; cursor: pointer; display: flex; flex-direction: column; gap: 8px; transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-weight: 700; font-size: 14px; color: #0f172a;"><i class="fas fa-list-ol" style="color: #0284c7; margin-right: 4px;"></i> Nomor Halaman</span>
                        <input type="radio" name="pagination_type" value="pagination" {{ $currentPagType === 'pagination' ? 'checked' : '' }}>
                    </div>
                    <p style="font-size: 12px; color: var(--admin-muted); margin: 0; line-height: 1.4;">Navigasi nomor halaman tradisional (1, 2, 3... Selanjutnya) yang ramah navigasi langsung.</p>
                </label>
            </div>
        </div>

        <!-- 4. PENGATURAN SEO, META & OPEN GRAPH -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title"><i class="fas fa-search" style="color: #059669; margin-right: 6px;"></i> Optimasi SEO & Open Graph (Social Sharing)</h3>
                    <p style="font-size: 12.5px; color: var(--admin-muted); margin-top: 4px;">Deskripsi dan kata kunci ini akan ditampilkan pada hasil pencarian Google dan saat link dibagikan ke WhatsApp/Facebook/Twitter.</p>
                </div>
            </div>

            <div class="form-group">
                <label for="site_description">
                    Deskripsi Website untuk SEO (Meta Description) <span style="color: #dc2626;">*</span>
                    <span style="font-weight: normal; font-size: 12px; color: var(--admin-muted);">(Disarankan 140–160 karakter untuk Google)</span>
                </label>
                <textarea
                    id="site_description"
                    name="site_description"
                    class="form-control"
                    rows="3"
                    placeholder="Masukkan ringkasan singkat portal berita Anda..."
                    required
                >{{ old('site_description', $settings['site_description'] ?? 'SmartNews - Portal berita Indonesia terpercaya, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.') }}</textarea>
            </div>

            <div class="form-group">
                <label for="site_keywords">
                    Kata Kunci SEO (Meta Keywords)
                    <span style="font-weight: normal; font-size: 12px; color: var(--admin-muted);">(Pisahkan dengan koma)</span>
                </label>
                <input
                    type="text"
                    id="site_keywords"
                    name="site_keywords"
                    class="form-control"
                    value="{{ old('site_keywords', $settings['site_keywords'] ?? 'smartnews, berita terkini, berita indonesia, portal berita, nasional, politik, ekonomi, teknologi, olahraga') }}"
                    placeholder="berita terkini, berita hari ini, kabar nasional, politik indonesia"
                >
            </div>

            <div class="form-group">
                <label for="google_site_verification">
                    Google Site Verification Code (Opsional)
                    <span style="font-weight: normal; font-size: 12px; color: var(--admin-muted);">(Dari Google Search Console)</span>
                </label>
                <input
                    type="text"
                    id="google_site_verification"
                    name="google_site_verification"
                    class="form-control"
                    value="{{ old('google_site_verification', $settings['google_site_verification'] ?? '') }}"
                    placeholder="Contoh: _xYz1234567890abcdef..."
                >
            </div>
        </div>

        <!-- 3. KONTAK & MEDIA SOSIAL -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title"><i class="fas fa-address-book" style="color: #d97706; margin-right: 6px;"></i> Kontak Redaksi & Tautan Media Sosial</h3>
                    <p style="font-size: 12.5px; color: var(--admin-muted); margin-top: 4px;">Informasi ini akan muncul pada footer dan halaman kontak portal.</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label for="contact_email"><i class="fas fa-envelope"></i> Email Redaksi</label>
                    <input
                        type="email"
                        id="contact_email"
                        name="contact_email"
                        class="form-control"
                        value="{{ old('contact_email', $settings['contact_email'] ?? 'redaksi@smartnews.id') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="contact_phone"><i class="fas fa-phone"></i> Nomor Telepon</label>
                    <input
                        type="text"
                        id="contact_phone"
                        name="contact_phone"
                        class="form-control"
                        value="{{ old('contact_phone', $settings['contact_phone'] ?? '(012) 3456-7890') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="contact_address"><i class="fas fa-map-marker-alt"></i> Alamat Redaksi</label>
                    <input
                        type="text"
                        id="contact_address"
                        name="contact_address"
                        class="form-control"
                        value="{{ old('contact_address', $settings['contact_address'] ?? 'Jl. Sarjana, Timbangan, Ogan Ilir 30862') }}"
                    >
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                <div class="form-group">
                    <label for="social_facebook"><i class="fab fa-facebook-f" style="color: #1877f2;"></i> URL Facebook</label>
                    <input
                        type="url"
                        id="social_facebook"
                        name="social_facebook"
                        class="form-control"
                        value="{{ old('social_facebook', $settings['social_facebook'] ?? 'https://facebook.com') }}"
                        placeholder="https://facebook.com/..."
                    >
                </div>

                <div class="form-group">
                    <label for="social_twitter"><i class="fab fa-x-twitter"></i> URL Twitter / X</label>
                    <input
                        type="url"
                        id="social_twitter"
                        name="social_twitter"
                        class="form-control"
                        value="{{ old('social_twitter', $settings['social_twitter'] ?? 'https://twitter.com') }}"
                        placeholder="https://x.com/..."
                    >
                </div>

                <div class="form-group">
                    <label for="social_instagram"><i class="fab fa-instagram" style="color: #e1306c;"></i> URL Instagram</label>
                    <input
                        type="url"
                        id="social_instagram"
                        name="social_instagram"
                        class="form-control"
                        value="{{ old('social_instagram', $settings['social_instagram'] ?? 'https://instagram.com') }}"
                        placeholder="https://instagram.com/..."
                    >
                </div>

                <div class="form-group">
                    <label for="social_tiktok"><i class="fab fa-tiktok"></i> URL TikTok</label>
                    <input
                        type="url"
                        id="social_tiktok"
                        name="social_tiktok"
                        class="form-control"
                        value="{{ old('social_tiktok', $settings['social_tiktok'] ?? 'https://tiktok.com') }}"
                        placeholder="https://tiktok.com/@..."
                    >
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 40px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 15px; font-weight: 700;">
                <i class="fas fa-save"></i> Simpan Semua Pengaturan
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script>
    function previewImg(input, targetId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(targetId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
