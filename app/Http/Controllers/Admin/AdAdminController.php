<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdAdminController extends Controller
{
    /**
     * Ad placement locations definition
     */
    public static function getSlots()
    {
        return [
            'header' => [
                'name' => 'Header Banner (Atas Halaman)',
                'desc' => 'Tampil di bagian atas website di bawah navigasi & breaking news. Sangat optimal untuk branding.',
                'size_guide' => 'Rekomendasi: 728x90 (Desktop) / 320x100 (Mobile)',
                'location' => 'Semua Halaman (Header)',
            ],
            'home_feed' => [
                'name' => 'Homepage In-Feed (Sela-sela Berita Terkini)',
                'desc' => 'Tampil menyatu di dalam daftar berita beranda (antara item berita). CTR & impresi sangat tinggi.',
                'size_guide' => 'Rekomendasi: 728x90 (Responsive) / 336x280 (Mobile Banner)',
                'location' => 'Beranda (News Feed)',
            ],
            'sidebar' => [
                'name' => 'Sidebar Banner (Kolom Samping)',
                'desc' => 'Tampil di kolom samping (sidebar) desktop & bawah pada mobile.',
                'size_guide' => 'Rekomendasi: 300x250 (Medium Rectangle) / 300x600 (Half Page)',
                'location' => 'Beranda, Kategori, Tag & Single Artikel',
            ],
            'article_top' => [
                'name' => 'Artikel: Atas Konten (Top of Article)',
                'desc' => 'Tampil di awal artikel sebelum isi berita (di bawah foto/ringkasan AI).',
                'size_guide' => 'Rekomendasi: 728x90 (Desktop) / 300x250 (Mobile)',
                'location' => 'Halaman Baca Berita (Single Article)',
            ],
            'article_middle' => [
                'name' => 'Artikel: Di Tengah Paragraf (In-Content)',
                'desc' => 'Tampil otomatis di tengah-tengah paragraf artikel berita (setelah paragraf 2/3). Penempatan paling menguntungkan (Highest CTR).',
                'size_guide' => 'Rekomendasi: 300x250 / 336x280 / Responsive Banner',
                'location' => 'Halaman Baca Berita (Di Tengah Teks)',
            ],
            'article_bottom' => [
                'name' => 'Artikel: Bawah Konten (Bottom of Article)',
                'desc' => 'Tampil tepat setelah paragraf penutup artikel sebelum kolom komentar.',
                'size_guide' => 'Rekomendasi: 728x90 / 300x250 / 320x100',
                'location' => 'Halaman Baca Berita (Penutup)',
            ],
        ];
    }

    public function index()
    {
        $slots = self::getSlots();
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        return view('admin.ads.index', compact('slots', 'settings'));
    }

    public function update(Request $request)
    {
        $slots = self::getSlots();
        $uploadPath = public_path('uploads/ads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach ($slots as $slotKey => $slotInfo) {
            // Enabled toggle
            $enabledKey = "ad_{$slotKey}_enabled";
            $isEnabled = $request->has($enabledKey) ? '1' : '0';
            SiteSetting::set($enabledKey, $isEnabled);

            // Ad Type: image or code
            $typeKey = "ad_{$slotKey}_type";
            $type = $request->input($typeKey, 'image');
            SiteSetting::set($typeKey, $type);

            // Destination Link URL
            $urlKey = "ad_{$slotKey}_url";
            SiteSetting::set($urlKey, $request->input($urlKey, ''));

            // Target blank
            $targetKey = "ad_{$slotKey}_target";
            $target = $request->has($targetKey) ? '_blank' : '_self';
            SiteSetting::set($targetKey, $target);

            // HTML / AdSense Script Code
            $codeKey = "ad_{$slotKey}_code";
            SiteSetting::set($codeKey, $request->input($codeKey, ''));

            // Image File Upload
            $fileInputKey = "ad_{$slotKey}_image_file";
            if ($request->hasFile($fileInputKey)) {
                $file = $request->file($fileInputKey);
                $filename = "ad_{$slotKey}_" . time() . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                SiteSetting::set("ad_{$slotKey}_image", $filename);
            }
        }

        return redirect()->route('admin.ads.index')->with('success', 'Pengaturan penempatan iklan berhasil diperbarui dan diterapkan ke seluruh website!');
    }
}
