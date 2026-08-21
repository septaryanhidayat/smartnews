<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($page = 'tentang-kami')
    {
        $pages = [
            'tentang-kami' => [
                'title' => 'Tentang Kami',
                'subtitle' => 'Mengenal Lebih Dekat Portal Berita Digiterkini',
                'content' => '<p><strong>Digiterkini</strong> adalah portal berita digital Indonesia terpercaya yang didirikan dengan komitmen menyajikan informasi terkini, akurat, mendalam, dan berimbang bagi seluruh lapisan masyarakat.</p>
                <p>Di tengah derasnya arus informasi di era digital, Digiterkini mengedepankan jurnalisme berkualitas, memegang teguh kode etik jurnalistik, dan memverifikasi setiap data sebelum dipublikasikan ke publik.</p>
                <h3>Visi Kami</h3>
                <p>Menjadi media digital rujukan utama masyarakat Indonesia dalam memperoleh berita aktual, independen, dan berintegritas tinggi.</p>
                <h3>Misi Kami</h3>
                <ul>
                    <li>Menyajikan berita tercepat dengan tetap memprioritaskan akurasi dan keberimbangan fakta.</li>
                    <li>Mengedukasi dan mencerahkan publik melalui liputan mendalam dan analisis yang tajam.</li>
                    <li>Mendukung keterbukaan informasi publik dan demokrasi yang sehat di Indonesia.</li>
                </ul>',
            ],
            'disclaimer' => [
                'title' => 'Disclaimer',
                'subtitle' => 'Pernyataan Penyangkalan dan Batasan Tanggung Jawab',
                'content' => '<p>Seluruh materi dan artikel berita yang dipublikasikan di portal <strong>Digiterkini</strong> disajikan untuk tujuan informasi umum yang sah. Kami senantiasa berupaya memastikan ketepatan dan kelengkapan informasi yang disampaikan.</p>
                <p>Digiterkini tidak bertanggung jawab atas segala kerugian materiil maupun immateriil yang timbul secara langsung maupun tidak langsung akibat penggunaan informasi dari situs ini.</p>',
            ],
            'redaksi' => [
                'title' => 'Susunan Redaksi',
                'subtitle' => 'Struktur Dewan Redaksi & Manajemen Digiterkini',
                'content' => '<h3>Dewan Redaksi</h3>
                <p><strong>Pemimpin Redaksi:</strong> Bima Saputra, M.I.Kom.<br>
                <strong>Wakil Pemimpin Redaksi:</strong> Siti Nurhaliza, S.Sos.<br>
                <strong>Redaktur Pelaksana:</strong> Hendra Gunawan, S.I.Kom.<br>
                <strong>Redaktur Nasional:</strong> Ahmad Fauzi<br>
                <strong>Redaktur Ekonomi & Bisnis:</strong> Diana Kartika<br>
                <strong>Redaktur Teknologi & Sains:</strong> Kevin Pratama</p>
                <h3>Manajemen & Teknologi</h3>
                <p><strong>Direktur Utama:</strong> Digitalkit Media Nusantara<br>
                <strong>Kepala IT & Pengembangan:</strong> Tim Antigravity Tech</p>',
            ],
            'pedoman-media-siber' => [
                'title' => 'Pedoman Media Siber',
                'subtitle' => 'Kepatuhan terhadap Standar Dewan Pers Indonesia',
                'content' => '<p>Kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers adalah hak asasi manusia yang dilindungi oleh Pancasila, Undang-Undang Dasar 1945, dan Deklarasi Universal Hak Asasi Manusia PBB.</p>
                <p>Digiterkini mematuhi sepenuhnya Pedoman Pemberitaan Media Siber yang ditetapkan oleh Dewan Pers Republik Indonesia dalam setiap kegiatan jurnalistik, termasuk verifikasi berita, hak jawab, dan ralat pemberitaan.</p>',
            ],
            'kontak' => [
                'title' => 'Hubungi Kami',
                'subtitle' => 'Saluran Komunikasi Redaksi & Layanan Iklan',
                'content' => '<p>Untuk keperluan rilis pers, hak jawab, kritik, saran, serta penawaran kerja sama iklan, silakan menghubungi kantor redaksi kami:</p>
                <p><strong>Alamat Kantor:</strong><br>Jl. Sudirman Kav. 52–53, Jakarta Pusat 10220</p>
                <p><strong>Telepon:</strong> (012) 3456-7890<br>
                <strong>Email Redaksi:</strong> redaksi@digiterkini.id<br>
                <strong>Email Bisnis & Iklan:</strong> iklan@digiterkini.id</p>',
            ],
        ];

        $pageData = $pages[$page] ?? $pages['tentang-kami'];

        $trendingTags = Tag::withCount('articles')->orderBy('articles_count', 'desc')->take(10)->get();

        $popularArticles = Article::with(['category', 'user'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        $sidebarLatest = Article::with(['category', 'user'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $popularTags = Tag::has('articles')
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(15)
            ->get();

        $navCategories = Category::orderBy('order', 'asc')->get();

        return view('front.page', compact(
            'pageData',
            'trendingTags',
            'popularArticles',
            'sidebarLatest',
            'popularTags',
            'navCategories'
        ));
    }
}
