@extends('layouts.admin')

@section('title', 'Manajemen Iklan (Ads Management) - SmartNews Admin')
@section('page_title', 'Manajemen Iklan (Ads Management)')

@section('content')
<div style="max-width: 1200px;">
    
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; margin: 0 0 6px 0; color: var(--admin-text, #1e293b);">
                <i class="fas fa-ad" style="color: var(--admin-primary, #1a56db);"></i> Penempatan Iklan & Monetisasi
            </h2>
            <p style="color: var(--admin-muted, #64748b); font-size: 14px; margin: 0;">
                Kelola slot iklan banner gambar sponsor maupun kode skrip Google AdSense pada posisi paling strategis di seluruh website.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.ads.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(540px, 1fr)); gap: 24px;">
            @foreach($slots as $slotKey => $slot)
                @php
                    $isEnabled = ($settings["ad_{$slotKey}_enabled"] ?? '0') === '1';
                    $type = $settings["ad_{$slotKey}_type"] ?? 'image';
                    $image = $settings["ad_{$slotKey}_image"] ?? '';
                    $url = $settings["ad_{$slotKey}_url"] ?? '';
                    $target = $settings["ad_{$slotKey}_target"] ?? '_blank';
                    $code = $settings["ad_{$slotKey}_code"] ?? '';
                @endphp

                <div class="card" style="margin-bottom: 0; display: flex; flex-direction: column; justify-content: space-between; border-top: 4px solid {{ $isEnabled ? '#10b981' : '#cbd5e1' }};">
                    <div>
                        <!-- Card Header with Toggle Switch -->
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--admin-border, #e2e8f0); gap: 12px;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                    <h3 style="font-size: 16px; font-weight: 700; margin: 0; color: var(--admin-text, #1e293b);">
                                        {{ $slot['name'] }}
                                    </h3>
                                </div>
                                <span class="badge" style="background-color: #e0f2fe; color: #0369a1; font-size: 10.5px;">
                                    <i class="fas fa-map-marker-alt"></i> {{ $slot['location'] }}
                                </span>
                            </div>

                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none;">
                                <span style="font-size: 12px; font-weight: 700; color: {{ $isEnabled ? '#059669' : '#64748b' }};">
                                    {{ $isEnabled ? 'AKTIF (ON)' : 'NONAKTIF (OFF)' }}
                                </span>
                                <input type="checkbox" name="ad_{{ $slotKey }}_enabled" value="1" {{ $isEnabled ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer; accent-color: #10b981;">
                            </label>
                        </div>

                        <p style="font-size: 13px; color: var(--admin-muted, #64748b); margin-bottom: 16px; line-height: 1.5;">
                            {{ $slot['desc'] }}
                        </p>

                        <div style="background-color: #f8fafc; padding: 8px 12px; border-radius: 6px; margin-bottom: 16px; font-size: 12px; color: #475569; border-left: 3px solid #3b82f6;">
                            <i class="fas fa-info-circle" style="color: #3b82f6;"></i> <strong>Panduan Ukuran:</strong> {{ $slot['size_guide'] }}
                        </div>

                        <!-- Ad Type Radio Selection -->
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 600; font-size: 13px; margin-bottom: 8px; display: block;">Tipe Iklan:</label>
                            <div style="display: flex; gap: 20px;">
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                                    <input type="radio" name="ad_{{ $slotKey }}_type" value="image" {{ $type === 'image' ? 'checked' : '' }} onchange="toggleAdType('{{ $slotKey }}', 'image')">
                                    <i class="fas fa-image" style="color: #3b82f6;"></i> Banner Gambar Kustom
                                </label>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
                                    <input type="radio" name="ad_{{ $slotKey }}_type" value="code" {{ $type === 'code' ? 'checked' : '' }} onchange="toggleAdType('{{ $slotKey }}', 'code')">
                                    <i class="fas fa-code" style="color: #8b5cf6;"></i> Script AdSense / Embed HTML
                                </label>
                            </div>
                        </div>

                        <!-- 1. Image Banner Fields -->
                        <div id="ad_image_wrap_{{ $slotKey }}" style="display: {{ $type === 'image' ? 'block' : 'none' }}; border: 1px solid var(--admin-border, #e2e8f0); padding: 14px; border-radius: 8px; background-color: #ffffff; margin-bottom: 14px;">
                            @if(!empty($image) && file_exists(public_path('uploads/ads/' . $image)))
                                <div style="margin-bottom: 12px;">
                                    <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 4px;">Banner Saat Ini:</span>
                                    <div style="max-height: 120px; overflow: hidden; border-radius: 6px; border: 1px solid #e2e8f0; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset('uploads/ads/' . $image) }}" alt="Preview Ad" style="max-width: 100%; max-height: 120px; object-fit: contain;">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group" style="margin-bottom: 12px;">
                                <label for="ad_{{ $slotKey }}_image_file" style="font-size: 12.5px; font-weight: 600;">Upload Gambar Banner Baru</label>
                                <input type="file" id="ad_{{ $slotKey }}_image_file" name="ad_{{ $slotKey }}_image_file" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
                                <small style="color: #64748b; font-size: 11px;">Format: JPG, PNG, WebP, GIF. Maks 3MB.</small>
                            </div>

                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="ad_{{ $slotKey }}_url" style="font-size: 12.5px; font-weight: 600;">URL Link Tujuan (Saat Iklan Diklik)</label>
                                <input type="url" id="ad_{{ $slotKey }}_url" name="ad_{{ $slotKey }}_url" class="form-control" value="{{ $url }}" placeholder="https://tokopedia.com/sponsor-link">
                            </div>

                            <label style="display: flex; align-items: center; gap: 6px; font-size: 12.5px; cursor: pointer; color: #475569;">
                                <input type="checkbox" name="ad_{{ $slotKey }}_target" value="_blank" {{ $target === '_blank' ? 'checked' : '' }}>
                                Buka tautan di tab baru (target="_blank")
                            </label>
                        </div>

                        <!-- 2. Code / Script Fields -->
                        <div id="ad_code_wrap_{{ $slotKey }}" style="display: {{ $type === 'code' ? 'block' : 'none' }}; border: 1px solid var(--admin-border, #e2e8f0); padding: 14px; border-radius: 8px; background-color: #ffffff; margin-bottom: 14px;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="ad_{{ $slotKey }}_code" style="font-size: 12.5px; font-weight: 600;">Kode Skrip Iklan (AdSense / Javascript / HTML)</label>
                                <textarea id="ad_{{ $slotKey }}_code" name="ad_{{ $slotKey }}_code" class="form-control" rows="5" style="font-family: monospace; font-size: 12px;" placeholder="<script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>&#10;<!-- Ad Slot -->&#10;<ins class='adsbygoogle' ...></ins>&#10;<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>">{{ $code }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 30px; position: sticky; bottom: 20px; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 16px 24px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); border: 1px solid #cbd5e1; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; z-index: 100;">
            <div style="font-size: 13px; color: #475569;">
                <i class="fas fa-shield-alt" style="color: #10b981;"></i> Perubahan status aktif/nonaktif dan banner iklan langsung berlaku di seluruh halaman website.
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-weight: 700; font-size: 15px;">
                <i class="fas fa-save"></i> Simpan Semua Pengaturan Iklan
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
function toggleAdType(slotKey, selectedType) {
    const imgWrap = document.getElementById('ad_image_wrap_' + slotKey);
    const codeWrap = document.getElementById('ad_code_wrap_' + slotKey);
    if (imgWrap && codeWrap) {
        if (selectedType === 'image') {
            imgWrap.style.display = 'block';
            codeWrap.style.display = 'none';
        } else {
            imgWrap.style.display = 'none';
            codeWrap.style.display = 'block';
        }
    }
}
</script>
@endpush
@endsection
