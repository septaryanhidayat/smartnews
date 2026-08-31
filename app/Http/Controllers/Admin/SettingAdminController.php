<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingAdminController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'required|string|max:500',
            'site_keywords' => 'nullable|string|max:500',
            'google_site_verification' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_tiktok' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'site_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'site_logo_dark' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'site_favicon' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,ico|max:1024',
            'hero_slider_count' => 'nullable|integer|min:1|max:10',
        ], [
            'site_name.required' => 'Nama website wajib diisi.',
            'site_description.required' => 'Deskripsi website untuk SEO wajib diisi.',
            'site_logo.mimes' => 'Format logo utama harus berupa gambar (JPG, PNG, WebP, SVG).',
            'site_logo.max' => 'Ukuran logo utama maksimal 3MB.',
            'site_logo_dark.mimes' => 'Format logo gelap harus berupa gambar (JPG, PNG, WebP, SVG).',
            'site_logo_dark.max' => 'Ukuran logo gelap maksimal 3MB.',
            'site_favicon.max' => 'Ukuran favicon maksimal 1MB.',
            'hero_slider_count.integer' => 'Jumlah berita slider harus berupa angka.',
            'hero_slider_count.min' => 'Jumlah berita slider minimal 1.',
            'hero_slider_count.max' => 'Jumlah berita slider maksimal 10.',
        ]);

        $uploadPath = public_path('uploads/settings');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Handle Site Logo Upload
        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $filename = 'logo_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            SiteSetting::set('site_logo', $filename);
        }

        // Handle Dark / White Logo Upload
        if ($request->hasFile('site_logo_dark')) {
            $file = $request->file('site_logo_dark');
            $filename = 'logo_dark_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            SiteSetting::set('site_logo_dark', $filename);
        }

        // Handle Favicon Upload
        if ($request->hasFile('site_favicon')) {
            $file = $request->file('site_favicon');
            $filename = 'favicon_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            SiteSetting::set('site_favicon', $filename);
        }

        // Text Fields
        $fields = [
            'site_name',
            'site_tagline',
            'site_description',
            'site_keywords',
            'google_site_verification',
            'hero_slider_count',
            'contact_email',
            'contact_phone',
            'contact_address',
            'social_facebook',
            'social_twitter',
            'social_instagram',
            'social_tiktok',
            'social_youtube',
        ];

        foreach ($fields as $field) {
            SiteSetting::set($field, $request->input($field, ''));
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan website, logo, dan SEO berhasil disimpan.');
    }
}
