<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the high-converting sales landing page for SmartNews CMS
     */
    public function index()
    {
        $siteName = setting('site_name', 'SmartNews');
        $contactPhone = setting('contact_phone', '081234567890');
        $contactEmail = setting('contact_email', 'info@berandadigital.net');
        
        // Clean phone number for WhatsApp URL (convert 08xx to 628xx)
        $waNumber = preg_replace('/[^0-9]/', '', $contactPhone);
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        } elseif (empty($waNumber)) {
            $waNumber = '6281234567890';
        }

        // WhatsApp URLs for the 3 packages
        $waMsgPkg1 = rawurlencode("Halo Tim SmartNews, saya ingin memesan *Paket 1: Source Code Only (Rp 1.500.000)*. Mohon info nomor rekening / cara pembayarannya.");
        $waMsgPkg2 = rawurlencode("Halo Tim SmartNews, saya ingin memesan *Paket 2: Siap Pakai + Hosting & Domain (Rp 3.000.000)*. Mohon bantu pilihkan domain & proses instalasinya.");
        $waMsgPkg3 = rawurlencode("Halo Tim SmartNews, saya ingin memesan *Paket 3: VIP Lifetime Update & Full Servis (Rp 5.000.000)*. Mohon info panduan & mulai setupnya.");

        $waUrlPkg1 = "https://api.whatsapp.com/send?phone={$waNumber}&text={$waMsgPkg1}";
        $waUrlPkg2 = "https://api.whatsapp.com/send?phone={$waNumber}&text={$waMsgPkg2}";
        $waUrlPkg3 = "https://api.whatsapp.com/send?phone={$waNumber}&text={$waMsgPkg3}";
        $waOrderUrl = $waUrlPkg2; // Default popular package

        // Sample article stats for social proof
        $totalArticles = Article::count();
        $totalCategories = Category::count();

        // Real articles for live UI showcase
        $featuredArticle = Article::with('category')->where('is_published', 1)->latest()->first();
        $previewArticles = Article::with('category')->where('is_published', 1)->latest()->skip(1)->take(2)->get();

        // Tripay payment channels
        $tripayChannels = \App\Services\TripayService::getChannels();

        return view('front.landing', compact(
            'siteName',
            'contactPhone',
            'contactEmail',
            'waNumber',
            'waOrderUrl',
            'waUrlPkg1',
            'waUrlPkg2',
            'waUrlPkg3',
            'totalArticles',
            'totalCategories',
            'featuredArticle',
            'previewArticles',
            'tripayChannels'
        ));
    }

    /**
     * Process Instant Tripay Checkout Order
     */
    public function tripayCheckout(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|in:pkg1,pkg2,pkg3',
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
            'customer_phone' => 'required|string|max:20',
            'payment_method' => 'required|string',
        ]);

        $packages = [
            'pkg1' => ['name' => 'Paket Starter (Source Code Saja)', 'price' => 1500000],
            'pkg2' => ['name' => 'Paket Pro (Siap Pakai + Hosting & Domain)', 'price' => 3000000],
            'pkg3' => ['name' => 'Paket Enterprise VIP (Lifetime Update & Full Servis)', 'price' => 5000000],
        ];

        $pkg = $packages[$validated['package_id']] ?? $packages['pkg2'];

        $result = \App\Services\TripayService::createClosedTransaction([
            'package_id' => $validated['package_id'],
            'package_name' => $pkg['name'],
            'amount' => $pkg['price'],
            'method' => $validated['payment_method'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
        ]);

        if (!empty($result['checkout_url'])) {
            return redirect()->away($result['checkout_url']);
        }

        // Direct WhatsApp Invoice Redirection with order & channel details
        $contactPhone = setting('contact_phone', '081234567890');
        $waNumber = preg_replace('/[^0-9]/', '', $contactPhone);
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }
        if (empty($waNumber)) {
            $waNumber = '6281234567890';
        }

        $waText = rawurlencode(
            "Halo Admin SmartNews, saya melakukan pemesanan via Checkout Tripay:\n\n" .
            "📦 Paket: " . $pkg['name'] . "\n" .
            "💰 Total: Rp " . number_format($pkg['price'], 0, ',', '.') . "\n" .
            "💳 Metode Bayar: " . $validated['payment_method'] . "\n" .
            "👤 Nama: " . $validated['customer_name'] . "\n" .
            "📧 Email: " . $validated['customer_email'] . "\n" .
            "📱 No HP: " . $validated['customer_phone'] . "\n" .
            "🔖 Ref: " . ($result['merchant_ref'] ?? 'SN-' . time()) . "\n\n" .
            "Mohon instruksi pembayaran & nomor VA / QRIS untuk segera saya selesaikan. Terima kasih!"
        );

        return redirect()->away("https://api.whatsapp.com/send?phone={$waNumber}&text={$waText}");
    }
}
