<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\SiteSetting;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NewsPortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Default Admin & Journalists
        $admin = User::firstOrCreate(
            ['email' => 'admin@digiterkini.id'],
            [
                'name' => 'Bima Saputra',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $journalist2 = User::firstOrCreate(
            ['email' => 'redaksi@digiterkini.id'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Categories
        $categoriesData = [
            ['name' => 'Nasional', 'slug' => 'nasional', 'description' => 'Berita aktual seputar peristiwa, kebijakan pemerintah, dan peristiwa penting di seluruh Indonesia.', 'color' => '#cf2e2e', 'order' => 1],
            ['name' => 'Internasional', 'slug' => 'internasional', 'description' => 'Kabar berita mancanegara, geopolitik global, dan hubungan internasional terkini.', 'color' => '#1a56db', 'order' => 2],
            ['name' => 'Politik', 'slug' => 'politik', 'description' => 'Dinamika perpolitikan tanah air, pemilu, pilkada, dan analisis kebijakan publik.', 'color' => '#059669', 'order' => 3],
            ['name' => 'Ekonomi', 'slug' => 'ekonomi', 'description' => 'Perkembangan pasar modal, investasi, perbankan, bisnis, dan ekonomi makro nasional.', 'color' => '#d97706', 'order' => 4],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'description' => 'Informasi kompetisi sepak bola, bulu tangkis, balap motor, dan prestasi atlet Indonesia.', 'color' => '#7c3aed', 'order' => 5],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Inovasi digital, gadget terbaru, kecerdasan buatan, dan tren transformasi teknologi.', 'color' => '#0284c7', 'order' => 6],
            ['name' => 'Otomotif', 'slug' => 'otomotif', 'description' => 'Ulasan kendaraan baru, perkembangan mobil listrik, dan tips perawatan kendaraan.', 'color' => '#dc2626', 'order' => 7],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'description' => 'Panduan gaya hidup sehat, info medis terpercaya, gizi, dan riset kesehatan.', 'color' => '#10b981', 'order' => 8],
            ['name' => 'Travel', 'slug' => 'travel', 'description' => 'Destinasi wisata eksotis Nusantara, rekomendasi kuliner, dan panduan perjalanan liburan.', 'color' => '#f59e0b', 'order' => 9],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::firstOrCreate(['slug' => $c['slug']], $c);
        }

        // 3. Create Tags
        $tagsData = [
            'BendunganMeninting',
            'InfrastrukturPUPR',
            'IrasiPetani',
            'KetahananPangan',
            'LombokBarat',
            'NusaTenggaraBarat',
            'PembangunanDaerah',
            'PeresmianBendungan',
            'PertanianModern',
            'PresidenRI',
            'PresidenPrabowo',
            'HUTRI81',
            'IndonesiaEmas',
            'Kemensetneg',
            'GlobalBond',
            'Danantara',
            'PasarModal',
            'ElNinoGodzilla',
            'SDMUnggul',
            'Industrialisasi',
            'BuluTangkis',
            'KPU',
            'PilkadaSerentak',
            'AIQuantum',
            'InvestasiAsing',
        ];

        $tags = [];
        foreach ($tagsData as $t) {
            $slug = Str::slug($t);
            $tags[$slug] = Tag::firstOrCreate(['slug' => $slug], ['name' => $t]);
        }

        // 4. Articles Data (Rich realistic news articles matching Digiterkini reference)
        $articlesData = [
            // Sticky Featured News
            [
                'title' => '[Sticky Post] Pemerintah Resmi Luncurkan Logo dan Identitas Visual HUT Ke-81 Kemerdekaan RI',
                'slug' => 'pemerintah-resmi-luncurkan-logo-dan-identitas-visual-hut-ke-81-kemerdekaan-ri',
                'category_slug' => 'nasional',
                'excerpt' => 'Pemerintah Republik Indonesia melalui Kementerian Sekretariat Negara (Kemensetneg) resmi meluncurkan logo dan identitas visual peringatan Hari Ulang Tahun (HUT) ke-81 Kemerdekaan RI.',
                'content' => '<p>Pemerintah Republik Indonesia melalui Kementerian Sekretariat Negara (Kemensetneg) resmi meluncurkan logo dan identitas visual peringatan Hari Ulang Tahun (HUT) ke-81 Kemerdekaan Republik Indonesia tahun 2026. Peluncuran ini menjadi momentum penting dalam menegaskan arah pembangunan nasional menuju Indonesia Emas.</p>
                <p>Menteri Sekretaris Negara dalam sambutannya menyampaikan bahwa logo HUT ke-81 merefleksikan semangat gotong royong, keberlanjutan inovasi, dan ketangguhan bangsa Indonesia dalam menghadapi berbagai tantangan global yang semakin dinamis.</p>
                <blockquote>"Identitas visual ini bukan sekadar lambang grafis, melainkan representasi tekad kolektif bangsa kita untuk terus melangkah maju dengan optimisme tinggi," ujar perwakilan Kemensetneg dalam konferensi pers di Jakarta.</blockquote>
                <p>Masyarakat, instansi pemerintah, dan lembaga swasta kini dapat mengunduh pedoman visual resmi HUT ke-81 melalui portal resmi pemerintah untuk digunakan dalam berbagai perayaan dan publikasi resmi.</p>',
                'image' => 'https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Konferensi pers peluncuran logo dan identitas visual resmi HUT Ke-81 RI di Jakarta.',
                'image_source' => 'Biro Pers Sekretariat Presiden',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => true,
                'is_slider' => false,
                'views_count' => 15420,
                'published_at' => now()->subDays(1),
                'tag_slugs' => ['hutri81', 'indonesiaemas', 'kemensetneg', 'presidenri'],
            ],

            // Hero Slider Articles
            [
                'title' => 'Warga Sambut Antusias Peresmian Bendungan Meninting, Lombok Barat',
                'slug' => 'warga-sambut-antusias-peresmian-bendungan-meninting-lombok-barat',
                'category_slug' => 'nasional',
                'excerpt' => 'Suasana penuh semangat menyambut kedatangan Presiden di kawasan Bendungan Meninting Lombok Barat yang menandai kedaulatan air dan irigasi modern di NTB.',
                'content' => '<p>Suasana penuh semangat menyambut kedatangan Presiden di kawasan Bendungan Meninting, Kabupaten Lombok Barat, Provinsi Nusa Tenggara Barat (NTB). Sejak pagi hari, masyarakat dari berbagai desa telah memadati kawasan sekitar bendungan dengan senyum dan lambaian tangan menyambut peresmian infrastruktur air strategis ini.</p>
                <p>Bendungan Meninting yang dibangun oleh Kementerian PUPR memiliki kapasitas tampung sebesar 12 juta meter kubik dan diproyeksikan mampu mengairi lebih dari 1.500 hektar sawah produktif di wilayah Lombok Barat dan sekitarnya.</p>
                <p>Di tengah antusiasme tersebut, para petani asal Desa Penimbung mengungkapkan rasa syukur mendalam karena permasalahan kekurangan pasokan air irigasi yang terjadi selama puluhan tahun kini dapat teratasi dengan baik.</p>
                <p>“Dengan adanya pasokan air yang teratur dari bendungan ini, kami optimistis produktivitas pertanian dapat meningkat dari satu kali panen menjadi dua hingga tiga kali panen dalam setahun,” ujar salah seorang perwakilan kelompok tani setempat.</p>',
                'image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb186c5f7?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Kawasan Bendungan Meninting di Lombok Barat yang baru diresmikan oleh Presiden.',
                'image_source' => 'Biro Pers Kemensetneg',
                'media_type' => 'video',
                'media_badge' => '02:07',
                'video_url' => 'https://www.youtube.com/watch?v=XI09xqDqTsk',
                'video_id' => 'XI09xqDqTsk',
                'is_sticky' => false,
                'is_slider' => true,
                'views_count' => 8930,
                'published_at' => now()->subHours(2),
                'tag_slugs' => ['bendunganmeninting', 'infrastrukturpupr', 'lombokbarat', 'ketahananpangan'],
            ],
            [
                'title' => 'Dari Kesulitan Air Menuju Panen Tiga Kali, Warga Sambut Antusias Peresmian Bendungan Meninting di NTB',
                'slug' => 'dari-kesulitan-air-menuju-panen-tiga-kali-warga-sambut-antusias-peresmian-bendungan-meninting-di-ntb',
                'category_slug' => 'nasional',
                'excerpt' => 'Sarana pengairan irigasi membangkitkan asa para petani NTB untuk meningkatkan produktivitas panen raya secara berkelanjutan.',
                'content' => '<p>Pembangunan infrastruktur ketahanan pangan terus dipercepat guna memperkuat kemandirian pangan nasional. Kehadiran bendungan multifungsi menjadi kunci utama dalam menjamin ketersediaan pasokan air irigasi sepanjang tahun di sentra-sentra produksi pertanian.</p>
                <p>Dengan jaringan kanal dan saluran irigasi sekunder yang tersambung langsung ke lahan-lahan garapan, para petani kini tidak lagi hanya bergantung pada curah hujan musiman untuk memulai masa tanam padi dan palawija.</p>',
                'image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Hamparan area persawahan hijau dengan sistem irigasi modern di Nusa Tenggara Barat.',
                'image_source' => 'Dokumentasi Dinas Pertanian NTB',
                'media_type' => 'photo',
                'media_badge' => '3 Foto',
                'is_sticky' => false,
                'is_slider' => true,
                'views_count' => 6410,
                'published_at' => now()->subHours(4),
                'tag_slugs' => ['irasipetani', 'pertanianmodern', 'nusatenggarabarat'],
            ],
            [
                'title' => 'Seskab Teddy: Presiden Prabowo Terima Menlu Qatar, Bahas Penguatan Investasi dan 50 Tahun Hubungan Diplomatik',
                'slug' => 'seskab-teddy-presiden-prabowo-terima-menlu-qatar-bahas-penguatan-investasi-dan-50-tahun-hubungan-diplomatik',
                'category_slug' => 'nasional',
                'excerpt' => 'Pertemuan bilateral membahas komitmen penguatan investasi sektor energi terbarukan, infrastruktur, dan kemitraan ekonomi strategis.',
                'content' => '<p>Presiden Republik Indonesia menerima kunjungan kehormatan Menteri Luar Negeri Qatar di Istana Merdeka, Jakarta. Pertemuan bilateral tersebut bertepatan dengan momentum peringatan 50 tahun hubungan diplomatik antara Republik Indonesia dan Negara Qatar.</p>
                <p>Sekretaris Kabinet (Seskab) menyampaikan bahwa kedua belah pihak sepakat memperdalam kerja sama ekonomi, khususnya dalam percepatan investasi energi terbarukan, pariwisata ramah lingkungan, serta fasilitas logistik pelabuhan internasional.</p>',
                'image' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Suasana pertemuan bilateral Indonesia dan delegasi Qatar di Istana Kepresidenan Jakarta.',
                'image_source' => 'Setpres Media Center',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => true,
                'views_count' => 5200,
                'published_at' => now()->subHours(8),
                'tag_slugs' => ['investasiasing', 'presidenprabowo', 'internasional'],
            ],
            [
                'title' => 'Global Bond Perdana Danantara Catat Hasil Positif, Bukti Kepercayaan Investor Dunia terhadap Indonesia Tetap Tinggi',
                'slug' => 'global-bond-perdana-danantara-catat-hasil-positif-bukti-kepercayaan-investor-dunia-terhadap-indonesia-tetap-tinggi',
                'category_slug' => 'ekonomi',
                'excerpt' => 'Penerbitan surat utang global perdana Danantara mencatat kelebihan permintaan (oversubscribed) hingga lebih dari 4 kali lipat dari target awal.',
                'content' => '<p>Penerbitan instrumen obligasi global (Global Bond) perdana Badan Pengelola Investasi Danantara mencatatkan hasil gemilang di pasar keuangan internasional. Minat tinggi dari para investor global terbukti dari tingkat oversubscription hingga 4,2 kali lipat dari nominal emisi yang ditawarkan.</p>
                <p>Langkah ini semakin memperkuat pondasi pendanaan proyek-proyek strategis nasional, sekaligus menjadi sinyal kuat pengakuan dunia atas stabilitas makroekonomi dan prospek pertumbuhan ekonomi Indonesia.</p>',
                'image' => 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Grafik pergerakan indeks bursa dan pasar modal global yang menunjukkan tren positif.',
                'image_source' => 'Reuters / Financial Times',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => true,
                'views_count' => 7890,
                'published_at' => now()->subDay(),
                'tag_slugs' => ['globalbond', 'danantara', 'pasarmodal'],
            ],
            [
                'title' => 'Hadapi El Nino Godzilla, Pemerintah Pastikan Kesiapan Cadangan Pangan dan Infrastruktur Pertanian Nasional',
                'slug' => 'hadapi-el-nino-godzilla-pemerintah-pastikan-kesiapan-cadangan-pangan-dan-infrastruktur-pertanian-nasional',
                'category_slug' => 'nasional',
                'excerpt' => 'Kementerian terkait mengintensifkan program pompanisasi air, distribusi bibit tahan kering, dan pengelolaan stok beras di seluruh gudang Bulog.',
                'content' => '<p>Menghadapi anomali cuaca ekstrem El Nino berintensitas tinggi, pemerintah pusat bersama pemerintah daerah bergerak cepat mengamankan cadangan pangan nasional. Langkah mitigasi menyeluruh disiapkan untuk mencegah dampak kekeringan pada lahan-lahan pertanian utama.</p>
                <p>Badan Pangan Nasional (Bapanas) dan Perum Bulog memastikan stok beras pemerintah berada dalam batas sangat aman, melebihi 2 juta ton yang tersebar merata di seluruh jaringan pergudangan di penjuru Nusantara.</p>',
                'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Distribusi bantuan pompa air untuk kelompok tani di sentra lumbung padi nasional.',
                'image_source' => 'Kementerian Pertanian RI',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => true,
                'views_count' => 4890,
                'published_at' => now()->subDays(2),
                'tag_slugs' => ['elninogodzilla', 'ketahananpangan', 'infrastrukturpupr'],
            ],

            // Grid Nasional & Popular Articles
            [
                'title' => 'Presiden Prabowo Instruksikan Perguruan Tinggi Cetak SDM Unggul untuk Percepat Industrialisasi Nasional',
                'slug' => 'presiden-prabowo-instruksikan-perguruan-tinggi-cetak-sdm-unggul-untuk-percepat-industrialisasi-nasional',
                'category_slug' => 'nasional',
                'excerpt' => 'Penguatan kurikulum sains terapan, teknologi manufaktur, dan riset energi baru terbarukan menjadi fokus transformasi perguruan tinggi.',
                'content' => '<p>Presiden menekankan pentingnya link and match antara institusi pendidikan tinggi dan sektor industri manufaktur. Kesiapan talenta muda terampil dipandang sebagai pilar utama dalam mengakselerasi hilirisasi industri dan kemandirian teknologi nasional.</p>',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Suasana wisuda dan riset laboratorium di salah satu kampus riset nasional.',
                'image_source' => 'Humas Kemendiktisaintek',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => false,
                'views_count' => 12890,
                'published_at' => now()->subDays(2),
                'tag_slugs' => ['sdmunggul', 'industrialisasi', 'presidenprabowo'],
            ],
            [
                'title' => 'Seskab Teddy: Program Magang Nasional 2026 Angkatan Kedua Resmi Diluncurkan, Libatkan 150 Ribu Peserta',
                'slug' => 'seskab-teddy-program-magang-nasional-2026-angkatan-kedua-resmi-diluncurkan-libatkan-150-ribu-peserta',
                'category_slug' => 'nasional',
                'excerpt' => 'Program magang bersertifikat di BUMN dan perusahaan multinasional dibuka guna mengasah kompetensi generasi muda siap kerja.',
                'content' => '<p>Pemerintah secara resmi membuka pendaftaran Program Magang Nasional Angkatan Kedua dengan kuota yang diperluas hingga mencapai 150 ribu peserta dari berbagai universitas dan politeknik di seluruh Indonesia.</p>',
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Para peserta program magang mengikuti sesi orientasi di pusat pelatihan.',
                'image_source' => 'Kementerian Ketenagakerjaan',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => false,
                'views_count' => 11200,
                'published_at' => now()->subDays(3),
                'tag_slugs' => ['sdmunggul', 'kemensetneg'],
            ],
            [
                'title' => 'Jamin Transparansi, KPU Batasi Dana Kampanye Pilkada Serentak Maksimal Rp50 Miliar per Paslon',
                'slug' => 'jamin-transparansi-kpu-batasi-dana-kampanye-pilkada-serentak-maksimal-rp50-miliar-per-paslon',
                'category_slug' => 'politik',
                'excerpt' => 'Regulasi ketat batas dana kampanye diberlakukan untuk mewujudkan kontestasi politik yang adil, jujur, dan akuntabel.',
                'content' => '<p>Komisi Pemilihan Umum (KPU) menetapkan aturan pembatasan besaran dana kampanye bagi pasangan calon kepala daerah dalam Pilkada Serentak. Batasan ini dirancang agar transparansi aliran dana dapat diawasi secara terbuka oleh publik dan lembaga pengawas pemilu.</p>',
                'image' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Konferensi pers jajaran komisioner KPU mengenai regulasi transparansi Pilkada.',
                'image_source' => 'Pusat Informasi KPU RI',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => false,
                'views_count' => 9750,
                'published_at' => now()->subDays(3),
                'tag_slugs' => ['kpu', 'pilkadaserentak'],
            ],
            [
                'title' => 'Era Baru AI: Komputasi Prosesor Kuantum Portabel Pertama untuk Komputer Komersial Resmi Diluncurkan',
                'slug' => 'era-baru-ai-komputasi-prosesor-kuantum-portabel-pertama-untuk-komputer-komersial-resmi-diluncurkan',
                'category_slug' => 'teknologi',
                'excerpt' => 'Terobosan arsitektur kuantum suhu ruang menghadirkan kemampuan komputasi ribuan kali lebih efisien untuk aplikasi machine learning tingkat lanjut.',
                'content' => '<p>Dunia teknologi mencatatkan sejarah baru dengan peluncuran chip prosesor kuantum komersial pertama yang mampu beroperasi pada suhu ruangan tanpa memerlukan sistem pendingin kriogenik berskala besar. Inovasi ini membuka babak baru komputasi berkecepatan ultra tinggi untuk permodelan sains dan kecerdasan buatan.</p>',
                'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Visualisasi arsitektur mikroskopis prosesor kuantum portabel.',
                'image_source' => 'Tech Innovation Lab',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => false,
                'views_count' => 8430,
                'published_at' => now()->subDays(4),
                'tag_slugs' => ['aiquantum'],
            ],
            [
                'title' => 'Sejarah Baru! Tunggal Putra Indonesia Raih Gelar Juara di Kejuaraan Dunia Bulu Tangkis 2026',
                'slug' => 'sejarah-baru-tunggal-putra-indonesia-raih-gelar-juara-di-kejuaraan-dunia-bulu-tangkis-2026',
                'category_slug' => 'olahraga',
                'excerpt' => 'Permainan agresif dan taktik menawan mengantarkan podium tertinggi sekaligus mengakhiri penantian panjang gelar juara dunia.',
                'content' => '<p>Prestasi membanggakan kembali dipersembahkan oleh pahlawan olahraga Indonesia di kancah internasional. Melalui pertarungan rubber game sengit selama 85 menit, tunggal putra Merah Putih sukses menundukkan unggulan pertama dunia dan mengamankan medali emas kejuaraan dunia.</p>',
                'image' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Aksi selebrasi kemenangan atlet bulu tangkis Indonesia di podium utama.',
                'image_source' => 'PBSI Media / Badminton Photo',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => false,
                'views_count' => 14300,
                'published_at' => now()->subDays(4),
                'tag_slugs' => ['bulutangkis'],
            ],
            [
                'title' => 'Tren Kendaraan Listrik 2026: Indonesia Perluas Jaringan SPKLU Ultra Fast Charging Antarkota',
                'slug' => 'tren-kendaraan-listrik-2026-indonesia-perluas-jaringan-spklu-ultra-fast-charging-antarkota',
                'category_slug' => 'otomotif',
                'excerpt' => 'Pemasangan fasilitas pengisian daya kilat di ruas jalan tol trans pulau memberikan kenyamanan mobilitas pengguna mobil listrik jarak jauh.',
                'content' => '<p>Kementerian ESDM bersama PLN terus memperluas jaringan Stasiun Pengisian Kendaraan Listrik Umum (SPKLU) dengan teknologi pengisian ultra cepat. Waktu pengisian daya baterai kendaraan hingga 80 persen kini hanya membutuhkan waktu kurang dari 20 menit.</p>',
                'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Fasilitas SPKLU ultra fast charging di rest area jalan tol trans nasional.',
                'image_source' => 'PLN Disjaya Media',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => false,
                'views_count' => 5120,
                'published_at' => now()->subDays(5),
                'tag_slugs' => ['infrastrukturpupr', 'pembangunandaerah'],
            ],
            [
                'title' => 'Riset Medis Terbaru: Konsumsi Pangan Fermentasi Lokal Terbukti Tingkatkan Imunitas Tubuh',
                'slug' => 'riset-medis-terbaru-konsumsi-pangan-fermentasi-lokal-terbukti-tingkatkan-imunitas-tubuh',
                'category_slug' => 'kesehatan',
                'excerpt' => 'Kandungan probiotik alami pada tempe dan makanan tradisional Nusantara membantu menyeimbangkan mikrobioma usus dan daya tahan fisik.',
                'content' => '<p>Studi klinis terbaru yang dipublikasikan dalam jurnal kesehatan internasional menunjukkan bahwa pangan tradisional hasil fermentasi asli Indonesia kaya akan mikroba baik yang efektif menangkal inflamasi dan meningkatkan respons kekebalan seluler tubuh.</p>',
                'image' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Aneka bahan pangan organik bernutrisi tinggi untuk kesehatan pencernaan.',
                'image_source' => 'Health Research Lab',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => false,
                'views_count' => 3890,
                'published_at' => now()->subDays(5),
                'tag_slugs' => ['ketahananpangan'],
            ],
            [
                'title' => 'Pesona Labuan Bajo & Raja Ampat: Masuk Daftar 10 Destinasi Wisata Bahari Terbaik Dunia 2026',
                'slug' => 'pesona-labuan-bajo-raja-ampat-masuk-daftar-10-destinasi-wisata-bahari-terbaik-dunia-2026',
                'category_slug' => 'travel',
                'excerpt' => 'Keindahan panorama bawah laut dan komitmen konservasi ekosistem terumbu karang membawa pariwisata Indonesia kian mendunia.',
                'content' => '<p>Penghargaan pariwisata bergengsi dunia kembali menobatkan dua ikon surga bahari Indonesia, Labuan Bajo dan Raja Ampat, sebagai tujuan wisata paling memukau bagi pelancong mancanegara. Penerapan pariwisata berkelanjutan dinilai sukses menjaga kelestarian biota laut langka.</p>',
                'image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Pemandangan gugusan pulau karst dan air laut toska di kawasan Indonesia timur.',
                'image_source' => 'Wonderful Indonesia',
                'media_type' => 'photo',
                'media_badge' => '5 Foto',
                'is_sticky' => false,
                'is_slider' => false,
                'views_count' => 9180,
                'published_at' => now()->subDays(6),
                'tag_slugs' => ['pembangunandaerah'],
            ],
            [
                'title' => 'KTT Iklim Global Sepakati Komitmen Pendanaan Transisi Energi Hijau untuk Negara Berkembang',
                'slug' => 'ktt-iklim-global-sepakati-komitmen-pendanaan-transisi-energi-hijau-untuk-negara-berkembang',
                'category_slug' => 'internasional',
                'excerpt' => 'Para pemimpin dunia menyetujui skema bantuan teknologi rendah emisi dan dekarbonisasi industri berat.',
                'content' => '<p>Konferensi Tingkat Tinggi Perubahan Iklim yang berlangsung di Jenewa menghasilkan konsensus penting berupa pembentukan dana darurat iklim dan alih teknologi energi baru terbarukan bagi negara-negara berkembang.</p>',
                'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&auto=format&fit=crop&q=80',
                'image_caption' => 'Suasana sidang pleno para delegasi KTT Perubahan Iklim Global.',
                'image_source' => 'UN Press Office',
                'media_type' => 'standard',
                'media_badge' => null,
                'is_sticky' => false,
                'is_slider' => false,
                'views_count' => 6100,
                'published_at' => now()->subDays(7),
                'tag_slugs' => ['internasional'],
            ],
        ];

        foreach ($articlesData as $art) {
            $cat = $categories[$art['category_slug']] ?? $categories['nasional'];
            $article = Article::updateOrCreate(
                ['slug' => $art['slug']],
                [
                    'user_id' => $admin->id,
                    'category_id' => $cat->id,
                    'title' => $art['title'],
                    'excerpt' => $art['excerpt'],
                    'content' => $art['content'],
                    'image' => $art['image'],
                    'image_caption' => $art['image_caption'],
                    'image_source' => $art['image_source'],
                    'media_type' => $art['media_type'],
                    'media_badge' => $art['media_badge'],
                    'video_url' => $art['video_url'] ?? null,
                    'video_id' => $art['video_id'] ?? null,
                    'is_sticky' => $art['is_sticky'],
                    'is_slider' => $art['is_slider'],
                    'views_count' => $art['views_count'],
                    'status' => 'published',
                    'published_at' => $art['published_at'],
                ]
            );

            // Attach tags
            $tagIds = [];
            foreach ($art['tag_slugs'] as $tslug) {
                if (isset($tags[$tslug])) {
                    $tagIds[] = $tags[$tslug]->id;
                }
            }
            $article->tags()->sync($tagIds);

            // Seed sample comments for first few articles
            if ($article->id <= 3) {
                Comment::firstOrCreate(
                    ['article_id' => $article->id, 'email' => 'ahmad@example.com'],
                    [
                        'name' => 'Ahmad Fadhil',
                        'comment' => 'Informasi yang sangat mencerahkan dan komprehensif. Semoga infrastruktur ini membawa manfaat nyata bagi petani dan ekonomi daerah!',
                        'is_approved' => true,
                        'created_at' => now()->subHours(5),
                    ]
                );
                Comment::firstOrCreate(
                    ['article_id' => $article->id, 'email' => 'ratna@example.com'],
                    [
                        'name' => 'Ratna Dewi',
                        'comment' => 'Pemberitaan yang sangat aktual dan berimbang. Sukses terus untuk redaksi Digiterkini!',
                        'is_approved' => true,
                        'created_at' => now()->subHours(2),
                    ]
                );
            }
        }

        // 5. Site Settings
        $settings = [
            'site_name' => 'Digiterkini',
            'site_tagline' => 'Portal Berita Indonesia Terpercaya',
            'site_description' => 'Portal berita Indonesia terpercaya, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.',
            'site_address' => 'Jl. Sudirman Kav. 52–53, Jakarta Pusat 10220',
            'site_phone' => '(012) 3456-7890',
            'site_email' => 'redaksi@digiterkini.id',
            'social_facebook' => 'https://facebook.com',
            'social_twitter' => 'https://twitter.com',
            'social_tiktok' => 'https://tiktok.com',
            'social_youtube' => 'https://youtube.com',
        ];

        foreach ($settings as $k => $v) {
            SiteSetting::updateOrCreate(['key' => $k], ['value' => $v]);
        }
    }
}
