-- ========================================================
-- SmartNews Clean MySQL Production Database Dump
-- Domain: https://smartnews.berandadigital.net
-- Exported at: 2026-08-31 13:24:42
-- ========================================================

SET FOREIGN_KEY_CHECKS=0;

-- Table data for: `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Bima Saputra', 'admin@smartnews.id', '2026-08-31 13:24:27', '$2y$12$PkS.9mTBQNLaCmCT9OgCreyW9zOe7QYbEIkLztbIRC/CHv2syoPQa', NULL, '2026-08-31 13:24:27', '2026-08-31 13:24:27', 'author'),
(2, 'Siti Nurhaliza', 'redaksi@smartnews.id', '2026-08-31 13:24:27', '$2y$12$E0dMgsImWJByoGzGGpckOeKqo220L0U5If3CbcxRfbIdcwd5XSjf6', NULL, '2026-08-31 13:24:27', '2026-08-31 13:24:27', 'author');

-- Table data for: `categories`
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Nasional', 'nasional', 'Berita aktual seputar peristiwa, kebijakan pemerintah, dan peristiwa penting di seluruh Indonesia.', '#cf2e2e', 1, '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(2, 'Internasional', 'internasional', 'Kabar berita mancanegara, geopolitik global, dan hubungan internasional terkini.', '#1a56db', 2, '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(3, 'Politik', 'politik', 'Dinamika perpolitikan tanah air, pemilu, pilkada, dan analisis kebijakan publik.', '#059669', 3, '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(4, 'Ekonomi', 'ekonomi', 'Perkembangan pasar modal, investasi, perbankan, bisnis, dan ekonomi makro nasional.', '#d97706', 4, '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(5, 'Olahraga', 'olahraga', 'Informasi kompetisi sepak bola, bulu tangkis, balap motor, dan prestasi atlet Indonesia.', '#7c3aed', 5, '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(6, 'Teknologi', 'teknologi', 'Inovasi digital, gadget terbaru, kecerdasan buatan, dan tren transformasi teknologi.', '#0284c7', 6, '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(7, 'Otomotif', 'otomotif', 'Ulasan kendaraan baru, perkembangan mobil listrik, dan tips perawatan kendaraan.', '#dc2626', 7, '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(8, 'Kesehatan', 'kesehatan', 'Panduan gaya hidup sehat, info medis terpercaya, gizi, dan riset kesehatan.', '#10b981', 8, '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(9, 'Travel', 'travel', 'Destinasi wisata eksotis Nusantara, rekomendasi kuliner, dan panduan perjalanan liburan.', '#f59e0b', 9, '2026-08-31 13:24:27', '2026-08-31 13:24:27');

-- Table data for: `tags`
INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'BendunganMeninting', 'bendunganmeninting', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(2, 'InfrastrukturPUPR', 'infrastrukturpupr', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(3, 'IrasiPetani', 'irasipetani', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(4, 'KetahananPangan', 'ketahananpangan', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(5, 'LombokBarat', 'lombokbarat', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(6, 'NusaTenggaraBarat', 'nusatenggarabarat', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(7, 'PembangunanDaerah', 'pembangunandaerah', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(8, 'PeresmianBendungan', 'peresmianbendungan', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(9, 'PertanianModern', 'pertanianmodern', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(10, 'PresidenRI', 'presidenri', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(11, 'PresidenPrabowo', 'presidenprabowo', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(12, 'HUTRI81', 'hutri81', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(13, 'IndonesiaEmas', 'indonesiaemas', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(14, 'Kemensetneg', 'kemensetneg', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(15, 'GlobalBond', 'globalbond', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(16, 'Danantara', 'danantara', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(17, 'PasarModal', 'pasarmodal', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(18, 'ElNinoGodzilla', 'elninogodzilla', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(19, 'SDMUnggul', 'sdmunggul', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(20, 'Industrialisasi', 'industrialisasi', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(21, 'BuluTangkis', 'bulutangkis', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(22, 'KPU', 'kpu', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(23, 'PilkadaSerentak', 'pilkadaserentak', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(24, 'AIQuantum', 'aiquantum', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(25, 'InvestasiAsing', 'investasiasing', '2026-08-31 13:24:27', '2026-08-31 13:24:27');

-- Table data for: `articles`
INSERT INTO `articles` (`id`, `user_id`, `category_id`, `title`, `slug`, `excerpt`, `content`, `image`, `image_caption`, `image_source`, `media_type`, `media_badge`, `video_url`, `video_id`, `is_sticky`, `is_slider`, `views_count`, `status`, `published_at`, `created_at`, `updated_at`, `ai_summary`) VALUES
(1, 1, 1, '[Sticky Post] Pemerintah Resmi Luncurkan Logo dan Identitas Visual HUT Ke-81 Kemerdekaan RI', 'pemerintah-resmi-luncurkan-logo-dan-identitas-visual-hut-ke-81-kemerdekaan-ri', 'Pemerintah Republik Indonesia melalui Kementerian Sekretariat Negara (Kemensetneg) resmi meluncurkan logo dan identitas visual peringatan Hari Ulang Tahun (HUT) ke-81 Kemerdekaan RI.', '<p>Pemerintah Republik Indonesia melalui Kementerian Sekretariat Negara (Kemensetneg) resmi meluncurkan logo dan identitas visual peringatan Hari Ulang Tahun (HUT) ke-81 Kemerdekaan Republik Indonesia tahun 2026. Peluncuran ini menjadi momentum penting dalam menegaskan arah pembangunan nasional menuju Indonesia Emas.</p>
                <p>Menteri Sekretaris Negara dalam sambutannya menyampaikan bahwa logo HUT ke-81 merefleksikan semangat gotong royong, keberlanjutan inovasi, dan ketangguhan bangsa Indonesia dalam menghadapi berbagai tantangan global yang semakin dinamis.</p>
                <blockquote>"Identitas visual ini bukan sekadar lambang grafis, melainkan representasi tekad kolektif bangsa kita untuk terus melangkah maju dengan optimisme tinggi," ujar perwakilan Kemensetneg dalam konferensi pers di Jakarta.</blockquote>
                <p>Masyarakat, instansi pemerintah, dan lembaga swasta kini dapat mengunduh pedoman visual resmi HUT ke-81 melalui portal resmi pemerintah untuk digunakan dalam berbagai perayaan dan publikasi resmi.</p>', 'https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?w=1200&auto=format&fit=crop&q=80', 'Konferensi pers peluncuran logo dan identitas visual resmi HUT Ke-81 RI di Jakarta.', 'Biro Pers Sekretariat Presiden', 'standard', NULL, NULL, NULL, 1, 0, 15420, 'published', '2026-08-30 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(2, 1, 1, 'Warga Sambut Antusias Peresmian Bendungan Meninting, Lombok Barat', 'warga-sambut-antusias-peresmian-bendungan-meninting-lombok-barat', 'Suasana penuh semangat menyambut kedatangan Presiden di kawasan Bendungan Meninting Lombok Barat yang menandai kedaulatan air dan irigasi modern di NTB.', '<p>Suasana penuh semangat menyambut kedatangan Presiden di kawasan Bendungan Meninting, Kabupaten Lombok Barat, Provinsi Nusa Tenggara Barat (NTB). Sejak pagi hari, masyarakat dari berbagai desa telah memadati kawasan sekitar bendungan dengan senyum dan lambaian tangan menyambut peresmian infrastruktur air strategis ini.</p>
                <p>Bendungan Meninting yang dibangun oleh Kementerian PUPR memiliki kapasitas tampung sebesar 12 juta meter kubik dan diproyeksikan mampu mengairi lebih dari 1.500 hektar sawah produktif di wilayah Lombok Barat dan sekitarnya.</p>
                <p>Di tengah antusiasme tersebut, para petani asal Desa Penimbung mengungkapkan rasa syukur mendalam karena permasalahan kekurangan pasokan air irigasi yang terjadi selama puluhan tahun kini dapat teratasi dengan baik.</p>
                <p>“Dengan adanya pasokan air yang teratur dari bendungan ini, kami optimistis produktivitas pertanian dapat meningkat dari satu kali panen menjadi dua hingga tiga kali panen dalam setahun,” ujar salah seorang perwakilan kelompok tani setempat.</p>', 'https://images.unsplash.com/photo-1541888946425-d0fbb186c5f7?w=1200&auto=format&fit=crop&q=80', 'Kawasan Bendungan Meninting di Lombok Barat yang baru diresmikan oleh Presiden.', 'Biro Pers Kemensetneg', 'video', '02:07', 'https://www.youtube.com/watch?v=XI09xqDqTsk', 'XI09xqDqTsk', 0, 1, 8930, 'published', '2026-08-31 11:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(3, 1, 1, 'Dari Kesulitan Air Menuju Panen Tiga Kali, Warga Sambut Antusias Peresmian Bendungan Meninting di NTB', 'dari-kesulitan-air-menuju-panen-tiga-kali-warga-sambut-antusias-peresmian-bendungan-meninting-di-ntb', 'Sarana pengairan irigasi membangkitkan asa para petani NTB untuk meningkatkan produktivitas panen raya secara berkelanjutan.', '<p>Pembangunan infrastruktur ketahanan pangan terus dipercepat guna memperkuat kemandirian pangan nasional. Kehadiran bendungan multifungsi menjadi kunci utama dalam menjamin ketersediaan pasokan air irigasi sepanjang tahun di sentra-sentra produksi pertanian.</p>
                <p>Dengan jaringan kanal dan saluran irigasi sekunder yang tersambung langsung ke lahan-lahan garapan, para petani kini tidak lagi hanya bergantung pada curah hujan musiman untuk memulai masa tanam padi dan palawija.</p>', 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1200&auto=format&fit=crop&q=80', 'Hamparan area persawahan hijau dengan sistem irigasi modern di Nusa Tenggara Barat.', 'Dokumentasi Dinas Pertanian NTB', 'photo', '3 Foto', NULL, NULL, 0, 1, 6410, 'published', '2026-08-31 09:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(4, 1, 1, 'Seskab Teddy: Presiden Prabowo Terima Menlu Qatar, Bahas Penguatan Investasi dan 50 Tahun Hubungan Diplomatik', 'seskab-teddy-presiden-prabowo-terima-menlu-qatar-bahas-penguatan-investasi-dan-50-tahun-hubungan-diplomatik', 'Pertemuan bilateral membahas komitmen penguatan investasi sektor energi terbarukan, infrastruktur, dan kemitraan ekonomi strategis.', '<p>Presiden Republik Indonesia menerima kunjungan kehormatan Menteri Luar Negeri Qatar di Istana Merdeka, Jakarta. Pertemuan bilateral tersebut bertepatan dengan momentum peringatan 50 tahun hubungan diplomatik antara Republik Indonesia dan Negara Qatar.</p>
                <p>Sekretaris Kabinet (Seskab) menyampaikan bahwa kedua belah pihak sepakat memperdalam kerja sama ekonomi, khususnya dalam percepatan investasi energi terbarukan, pariwisata ramah lingkungan, serta fasilitas logistik pelabuhan internasional.</p>', 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1200&auto=format&fit=crop&q=80', 'Suasana pertemuan bilateral Indonesia dan delegasi Qatar di Istana Kepresidenan Jakarta.', 'Setpres Media Center', 'standard', NULL, NULL, NULL, 0, 1, 5200, 'published', '2026-08-31 05:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(5, 1, 4, 'Global Bond Perdana Danantara Catat Hasil Positif, Bukti Kepercayaan Investor Dunia terhadap Indonesia Tetap Tinggi', 'global-bond-perdana-danantara-catat-hasil-positif-bukti-kepercayaan-investor-dunia-terhadap-indonesia-tetap-tinggi', 'Penerbitan surat utang global perdana Danantara mencatat kelebihan permintaan (oversubscribed) hingga lebih dari 4 kali lipat dari target awal.', '<p>Penerbitan instrumen obligasi global (Global Bond) perdana Badan Pengelola Investasi Danantara mencatatkan hasil gemilang di pasar keuangan internasional. Minat tinggi dari para investor global terbukti dari tingkat oversubscription hingga 4,2 kali lipat dari nominal emisi yang ditawarkan.</p>
                <p>Langkah ini semakin memperkuat pondasi pendanaan proyek-proyek strategis nasional, sekaligus menjadi sinyal kuat pengakuan dunia atas stabilitas makroekonomi dan prospek pertumbuhan ekonomi Indonesia.</p>', 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?w=1200&auto=format&fit=crop&q=80', 'Grafik pergerakan indeks bursa dan pasar modal global yang menunjukkan tren positif.', 'Reuters / Financial Times', 'standard', NULL, NULL, NULL, 0, 1, 7890, 'published', '2026-08-30 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(6, 1, 1, 'Hadapi El Nino Godzilla, Pemerintah Pastikan Kesiapan Cadangan Pangan dan Infrastruktur Pertanian Nasional', 'hadapi-el-nino-godzilla-pemerintah-pastikan-kesiapan-cadangan-pangan-dan-infrastruktur-pertanian-nasional', 'Kementerian terkait mengintensifkan program pompanisasi air, distribusi bibit tahan kering, dan pengelolaan stok beras di seluruh gudang Bulog.', '<p>Menghadapi anomali cuaca ekstrem El Nino berintensitas tinggi, pemerintah pusat bersama pemerintah daerah bergerak cepat mengamankan cadangan pangan nasional. Langkah mitigasi menyeluruh disiapkan untuk mencegah dampak kekeringan pada lahan-lahan pertanian utama.</p>
                <p>Badan Pangan Nasional (Bapanas) dan Perum Bulog memastikan stok beras pemerintah berada dalam batas sangat aman, melebihi 2 juta ton yang tersebar merata di seluruh jaringan pergudangan di penjuru Nusantara.</p>', 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1200&auto=format&fit=crop&q=80', 'Distribusi bantuan pompa air untuk kelompok tani di sentra lumbung padi nasional.', 'Kementerian Pertanian RI', 'standard', NULL, NULL, NULL, 0, 1, 4890, 'published', '2026-08-29 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(7, 1, 1, 'Presiden Prabowo Instruksikan Perguruan Tinggi Cetak SDM Unggul untuk Percepat Industrialisasi Nasional', 'presiden-prabowo-instruksikan-perguruan-tinggi-cetak-sdm-unggul-untuk-percepat-industrialisasi-nasional', 'Penguatan kurikulum sains terapan, teknologi manufaktur, dan riset energi baru terbarukan menjadi fokus transformasi perguruan tinggi.', '<p>Presiden menekankan pentingnya link and match antara institusi pendidikan tinggi dan sektor industri manufaktur. Kesiapan talenta muda terampil dipandang sebagai pilar utama dalam mengakselerasi hilirisasi industri dan kemandirian teknologi nasional.</p>', 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1200&auto=format&fit=crop&q=80', 'Suasana wisuda dan riset laboratorium di salah satu kampus riset nasional.', 'Humas Kemendiktisaintek', 'standard', NULL, NULL, NULL, 0, 0, 12890, 'published', '2026-08-29 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(8, 1, 1, 'Seskab Teddy: Program Magang Nasional 2026 Angkatan Kedua Resmi Diluncurkan, Libatkan 150 Ribu Peserta', 'seskab-teddy-program-magang-nasional-2026-angkatan-kedua-resmi-diluncurkan-libatkan-150-ribu-peserta', 'Program magang bersertifikat di BUMN dan perusahaan multinasional dibuka guna mengasah kompetensi generasi muda siap kerja.', '<p>Pemerintah secara resmi membuka pendaftaran Program Magang Nasional Angkatan Kedua dengan kuota yang diperluas hingga mencapai 150 ribu peserta dari berbagai universitas dan politeknik di seluruh Indonesia.</p>', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&auto=format&fit=crop&q=80', 'Para peserta program magang mengikuti sesi orientasi di pusat pelatihan.', 'Kementerian Ketenagakerjaan', 'standard', NULL, NULL, NULL, 0, 0, 11200, 'published', '2026-08-28 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(9, 1, 3, 'Jamin Transparansi, KPU Batasi Dana Kampanye Pilkada Serentak Maksimal Rp50 Miliar per Paslon', 'jamin-transparansi-kpu-batasi-dana-kampanye-pilkada-serentak-maksimal-rp50-miliar-per-paslon', 'Regulasi ketat batas dana kampanye diberlakukan untuk mewujudkan kontestasi politik yang adil, jujur, dan akuntabel.', '<p>Komisi Pemilihan Umum (KPU) menetapkan aturan pembatasan besaran dana kampanye bagi pasangan calon kepala daerah dalam Pilkada Serentak. Batasan ini dirancang agar transparansi aliran dana dapat diawasi secara terbuka oleh publik dan lembaga pengawas pemilu.</p>', 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=1200&auto=format&fit=crop&q=80', 'Konferensi pers jajaran komisioner KPU mengenai regulasi transparansi Pilkada.', 'Pusat Informasi KPU RI', 'standard', NULL, NULL, NULL, 0, 0, 9750, 'published', '2026-08-28 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(10, 1, 6, 'Era Baru AI: Komputasi Prosesor Kuantum Portabel Pertama untuk Komputer Komersial Resmi Diluncurkan', 'era-baru-ai-komputasi-prosesor-kuantum-portabel-pertama-untuk-komputer-komersial-resmi-diluncurkan', 'Terobosan arsitektur kuantum suhu ruang menghadirkan kemampuan komputasi ribuan kali lebih efisien untuk aplikasi machine learning tingkat lanjut.', '<p>Dunia teknologi mencatatkan sejarah baru dengan peluncuran chip prosesor kuantum komersial pertama yang mampu beroperasi pada suhu ruangan tanpa memerlukan sistem pendingin kriogenik berskala besar. Inovasi ini membuka babak baru komputasi berkecepatan ultra tinggi untuk permodelan sains dan kecerdasan buatan.</p>', 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=1200&auto=format&fit=crop&q=80', 'Visualisasi arsitektur mikroskopis prosesor kuantum portabel.', 'Tech Innovation Lab', 'standard', NULL, NULL, NULL, 0, 0, 8430, 'published', '2026-08-27 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(11, 1, 5, 'Sejarah Baru! Tunggal Putra Indonesia Raih Gelar Juara di Kejuaraan Dunia Bulu Tangkis 2026', 'sejarah-baru-tunggal-putra-indonesia-raih-gelar-juara-di-kejuaraan-dunia-bulu-tangkis-2026', 'Permainan agresif dan taktik menawan mengantarkan podium tertinggi sekaligus mengakhiri penantian panjang gelar juara dunia.', '<p>Prestasi membanggakan kembali dipersembahkan oleh pahlawan olahraga Indonesia di kancah internasional. Melalui pertarungan rubber game sengit selama 85 menit, tunggal putra Merah Putih sukses menundukkan unggulan pertama dunia dan mengamankan medali emas kejuaraan dunia.</p>', 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=1200&auto=format&fit=crop&q=80', 'Aksi selebrasi kemenangan atlet bulu tangkis Indonesia di podium utama.', 'PBSI Media / Badminton Photo', 'standard', NULL, NULL, NULL, 0, 0, 14300, 'published', '2026-08-27 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(12, 1, 7, 'Tren Kendaraan Listrik 2026: Indonesia Perluas Jaringan SPKLU Ultra Fast Charging Antarkota', 'tren-kendaraan-listrik-2026-indonesia-perluas-jaringan-spklu-ultra-fast-charging-antarkota', 'Pemasangan fasilitas pengisian daya kilat di ruas jalan tol trans pulau memberikan kenyamanan mobilitas pengguna mobil listrik jarak jauh.', '<p>Kementerian ESDM bersama PLN terus memperluas jaringan Stasiun Pengisian Kendaraan Listrik Umum (SPKLU) dengan teknologi pengisian ultra cepat. Waktu pengisian daya baterai kendaraan hingga 80 persen kini hanya membutuhkan waktu kurang dari 20 menit.</p>', 'https://images.unsplash.com/photo-1563720223185-11003d516935?w=1200&auto=format&fit=crop&q=80', 'Fasilitas SPKLU ultra fast charging di rest area jalan tol trans nasional.', 'PLN Disjaya Media', 'standard', NULL, NULL, NULL, 0, 0, 5120, 'published', '2026-08-26 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(13, 1, 8, 'Riset Medis Terbaru: Konsumsi Pangan Fermentasi Lokal Terbukti Tingkatkan Imunitas Tubuh', 'riset-medis-terbaru-konsumsi-pangan-fermentasi-lokal-terbukti-tingkatkan-imunitas-tubuh', 'Kandungan probiotik alami pada tempe dan makanan tradisional Nusantara membantu menyeimbangkan mikrobioma usus dan daya tahan fisik.', '<p>Studi klinis terbaru yang dipublikasikan dalam jurnal kesehatan internasional menunjukkan bahwa pangan tradisional hasil fermentasi asli Indonesia kaya akan mikroba baik yang efektif menangkal inflamasi dan meningkatkan respons kekebalan seluler tubuh.</p>', 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=1200&auto=format&fit=crop&q=80', 'Aneka bahan pangan organik bernutrisi tinggi untuk kesehatan pencernaan.', 'Health Research Lab', 'standard', NULL, NULL, NULL, 0, 0, 3890, 'published', '2026-08-26 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(14, 1, 9, 'Pesona Labuan Bajo & Raja Ampat: Masuk Daftar 10 Destinasi Wisata Bahari Terbaik Dunia 2026', 'pesona-labuan-bajo-raja-ampat-masuk-daftar-10-destinasi-wisata-bahari-terbaik-dunia-2026', 'Keindahan panorama bawah laut dan komitmen konservasi ekosistem terumbu karang membawa pariwisata Indonesia kian mendunia.', '<p>Penghargaan pariwisata bergengsi dunia kembali menobatkan dua ikon surga bahari Indonesia, Labuan Bajo dan Raja Ampat, sebagai tujuan wisata paling memukau bagi pelancong mancanegara. Penerapan pariwisata berkelanjutan dinilai sukses menjaga kelestarian biota laut langka.</p>', 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?w=1200&auto=format&fit=crop&q=80', 'Pemandangan gugusan pulau karst dan air laut toska di kawasan Indonesia timur.', 'Wonderful Indonesia', 'photo', '5 Foto', NULL, NULL, 0, 0, 9180, 'published', '2026-08-25 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL),
(15, 1, 2, 'KTT Iklim Global Sepakati Komitmen Pendanaan Transisi Energi Hijau untuk Negara Berkembang', 'ktt-iklim-global-sepakati-komitmen-pendanaan-transisi-energi-hijau-untuk-negara-berkembang', 'Para pemimpin dunia menyetujui skema bantuan teknologi rendah emisi dan dekarbonisasi industri berat.', '<p>Konferensi Tingkat Tinggi Perubahan Iklim yang berlangsung di Jenewa menghasilkan konsensus penting berupa pembentukan dana darurat iklim dan alih teknologi energi baru terbarukan bagi negara-negara berkembang.</p>', 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&auto=format&fit=crop&q=80', 'Suasana sidang pleno para delegasi KTT Perubahan Iklim Global.', 'UN Press Office', 'standard', NULL, NULL, NULL, 0, 0, 6100, 'published', '2026-08-24 13:24:27', '2026-08-31 13:24:27', '2026-08-31 13:24:27', NULL);

-- Table data for: `article_tag`
INSERT INTO `article_tag` (`id`, `article_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 1, 12, NULL, NULL),
(2, 1, 13, NULL, NULL),
(3, 1, 14, NULL, NULL),
(4, 1, 10, NULL, NULL),
(5, 2, 1, NULL, NULL),
(6, 2, 2, NULL, NULL),
(7, 2, 5, NULL, NULL),
(8, 2, 4, NULL, NULL),
(9, 3, 3, NULL, NULL),
(10, 3, 9, NULL, NULL),
(11, 3, 6, NULL, NULL),
(12, 4, 25, NULL, NULL),
(13, 4, 11, NULL, NULL),
(14, 5, 15, NULL, NULL),
(15, 5, 16, NULL, NULL),
(16, 5, 17, NULL, NULL),
(17, 6, 18, NULL, NULL),
(18, 6, 4, NULL, NULL),
(19, 6, 2, NULL, NULL),
(20, 7, 19, NULL, NULL),
(21, 7, 20, NULL, NULL),
(22, 7, 11, NULL, NULL),
(23, 8, 19, NULL, NULL),
(24, 8, 14, NULL, NULL),
(25, 9, 22, NULL, NULL),
(26, 9, 23, NULL, NULL),
(27, 10, 24, NULL, NULL),
(28, 11, 21, NULL, NULL),
(29, 12, 2, NULL, NULL),
(30, 12, 7, NULL, NULL),
(31, 13, 4, NULL, NULL),
(32, 14, 7, NULL, NULL);

-- Table data for: `comments`
INSERT INTO `comments` (`id`, `article_id`, `name`, `email`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ahmad Fadhil', 'ahmad@example.com', 'Informasi yang sangat mencerahkan dan komprehensif. Semoga infrastruktur ini membawa manfaat nyata bagi petani dan ekonomi daerah!', 1, '2026-08-31 08:24:27', '2026-08-31 13:24:27'),
(2, 1, 'Ratna Dewi', 'ratna@example.com', 'Pemberitaan yang sangat aktual dan berimbang. Sukses terus untuk redaksi SmartNews!', 1, '2026-08-31 11:24:27', '2026-08-31 13:24:27'),
(3, 2, 'Ahmad Fadhil', 'ahmad@example.com', 'Informasi yang sangat mencerahkan dan komprehensif. Semoga infrastruktur ini membawa manfaat nyata bagi petani dan ekonomi daerah!', 1, '2026-08-31 08:24:27', '2026-08-31 13:24:27'),
(4, 2, 'Ratna Dewi', 'ratna@example.com', 'Pemberitaan yang sangat aktual dan berimbang. Sukses terus untuk redaksi SmartNews!', 1, '2026-08-31 11:24:27', '2026-08-31 13:24:27'),
(5, 3, 'Ahmad Fadhil', 'ahmad@example.com', 'Informasi yang sangat mencerahkan dan komprehensif. Semoga infrastruktur ini membawa manfaat nyata bagi petani dan ekonomi daerah!', 1, '2026-08-31 08:24:27', '2026-08-31 13:24:27'),
(6, 3, 'Ratna Dewi', 'ratna@example.com', 'Pemberitaan yang sangat aktual dan berimbang. Sukses terus untuk redaksi SmartNews!', 1, '2026-08-31 11:24:27', '2026-08-31 13:24:27');

-- Table data for: `site_settings`
INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'SmartNews', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(2, 'site_tagline', 'Portal Berita Terpercaya & Cerdas', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(3, 'site_description', 'Portal berita Indonesia terpercaya, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(4, 'contact_address', 'Jl. Sarjana, Timbangan, Ogan Ilir 30862', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(5, 'contact_phone', '(012) 3456-7890', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(6, 'contact_email', 'redaksi@smartnews.id', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(7, 'social_facebook', 'https://facebook.com', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(8, 'social_twitter', 'https://twitter.com', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(9, 'social_tiktok', 'https://tiktok.com', '2026-08-31 13:24:27', '2026-08-31 13:24:27'),
(10, 'social_youtube', 'https://youtube.com', '2026-08-31 13:24:27', '2026-08-31 13:24:27');

SET FOREIGN_KEY_CHECKS=1;
