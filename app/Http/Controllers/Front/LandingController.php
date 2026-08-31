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
            'totalCategories'
        ));
    }
}
