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

        $waMessage = rawurlencode("Halo Tim SmartNews, saya tertarik untuk memesan Paket Lengkap Website Portal Berita Media Online SmartNews (Rp 3 Juta). Mohon info prosedur pemesanan & pilihan domainnya.");
        $waOrderUrl = "https://api.whatsapp.com/send?phone={$waNumber}&text={$waMessage}";

        // Sample article stats for social proof
        $totalArticles = Article::count();
        $totalCategories = Category::count();

        return view('front.landing', compact(
            'siteName',
            'contactPhone',
            'contactEmail',
            'waOrderUrl',
            'totalArticles',
            'totalCategories'
        ));
    }
}
