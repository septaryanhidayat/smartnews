-- ========================================================
-- SmartNews Portal - MySQL Database Dump for cPanel
-- Generated: 2026-08-21 17:29:53
-- Target Engine: MySQL 5.7+ / MySQL 8.0+ / MariaDB 10.3+
-- ========================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- --------------------------------------------------------
-- Struktur tabel: `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Bima Saputra', 'admin@digiterkini.id', '2026-08-21 16:55:01', '$2y$12$CVe80cASXFM1l4LwNCyXF.2PYJqdUsMi3T78CQs7FAQjXyboH9C7O', NULL, '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(2, 'Siti Nurhaliza', 'redaksi@digiterkini.id', '2026-08-21 16:55:01', '$2y$12$K3.8zQ/XyeELgoALhRLsfOX89eag3p8YGqG0VFsdYe7z9EByTAdKu', NULL, '2026-08-21 16:55:01', '2026-08-21 16:55:01');

-- --------------------------------------------------------
-- Struktur tabel: `categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '#1a56db',
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Nasional', 'nasional', 'Berita aktual seputar peristiwa, kebijakan pemerintah, dan peristiwa penting di seluruh Indonesia.', '#cf2e2e', 1, '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(2, 'Internasional', 'internasional', 'Kabar berita mancanegara, geopolitik global, dan hubungan internasional terkini.', '#1a56db', 2, '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(3, 'Politik', 'politik', 'Dinamika perpolitikan tanah air, pemilu, pilkada, dan analisis kebijakan publik.', '#059669', 3, '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(4, 'Ekonomi', 'ekonomi', 'Perkembangan pasar modal, investasi, perbankan, bisnis, dan ekonomi makro nasional.', '#d97706', 4, '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(5, 'Olahraga', 'olahraga', 'Informasi kompetisi sepak bola, bulu tangkis, balap motor, dan prestasi atlet Indonesia.', '#7c3aed', 5, '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(6, 'Teknologi', 'teknologi', 'Inovasi digital, gadget terbaru, kecerdasan buatan, dan tren transformasi teknologi.', '#0284c7', 6, '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(7, 'Otomotif', 'otomotif', 'Ulasan kendaraan baru, perkembangan mobil listrik, dan tips perawatan kendaraan.', '#dc2626', 7, '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(8, 'Kesehatan', 'kesehatan', 'Panduan gaya hidup sehat, info medis terpercaya, gizi, dan riset kesehatan.', '#10b981', 8, '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(9, 'Travel', 'travel', 'Destinasi wisata eksotis Nusantara, rekomendasi kuliner, dan panduan perjalanan liburan.', '#f59e0b', 9, '2026-08-21 16:55:01', '2026-08-21 16:55:01');

-- --------------------------------------------------------
-- Struktur tabel: `tags`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'BendunganMeninting', 'bendunganmeninting', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(2, 'InfrastrukturPUPR', 'infrastrukturpupr', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(3, 'IrasiPetani', 'irasipetani', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(4, 'KetahananPangan', 'ketahananpangan', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(5, 'LombokBarat', 'lombokbarat', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(6, 'NusaTenggaraBarat', 'nusatenggarabarat', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(7, 'PembangunanDaerah', 'pembangunandaerah', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(8, 'PeresmianBendungan', 'peresmianbendungan', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(9, 'PertanianModern', 'pertanianmodern', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(10, 'PresidenRI', 'presidenri', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(11, 'PresidenPrabowo', 'presidenprabowo', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(12, 'HUTRI81', 'hutri81', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(13, 'IndonesiaEmas', 'indonesiaemas', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(14, 'Kemensetneg', 'kemensetneg', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(15, 'GlobalBond', 'globalbond', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(16, 'Danantara', 'danantara', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(17, 'PasarModal', 'pasarmodal', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(18, 'ElNinoGodzilla', 'elninogodzilla', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(19, 'SDMUnggul', 'sdmunggul', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(20, 'Industrialisasi', 'industrialisasi', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(21, 'BuluTangkis', 'bulutangkis', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(22, 'KPU', 'kpu', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(23, 'PilkadaSerentak', 'pilkadaserentak', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(24, 'AIQuantum', 'aiquantum', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(25, 'InvestasiAsing', 'investasiasing', '2026-08-21 16:55:01', '2026-08-21 16:55:01'),
(26, 'KemerdekaanRI', 'kemerdekaanri', '2026-08-21 17:19:33', '2026-08-21 17:19:33'),
(27, 'LogoHUTRI2026', 'logohutri2026', '2026-08-21 17:19:33', '2026-08-21 17:19:33'),
(28, 'MenluQatar', 'menluqatar', '2026-08-21 17:19:35', '2026-08-21 17:19:35'),
(29, 'HubunganDiplomatik', 'hubungandiplomatik', '2026-08-21 17:19:35', '2026-08-21 17:19:35'),
(30, 'SeskabTeddy', 'seskabteddy', '2026-08-21 17:19:35', '2026-08-21 17:19:35'),
(31, 'Danantara2026', 'danantara2026', '2026-08-21 17:19:35', '2026-08-21 17:19:35'),
(32, 'GlobalBondDanantara', 'globalbonddanantara', '2026-08-21 17:19:35', '2026-08-21 17:19:35'),
(33, 'InvestasiIndonesia', 'investasiindonesia', '2026-08-21 17:19:35', '2026-08-21 17:19:35'),
(34, 'EkonomiNasional', 'ekonominasional', '2026-08-21 17:19:35', '2026-08-21 17:19:35'),
(35, 'CadanganPangan', 'cadanganpangan', '2026-08-21 17:19:36', '2026-08-21 17:19:36'),
(36, 'Bulog', 'bulog', '2026-08-21 17:19:36', '2026-08-21 17:19:36'),
(37, 'Pompanisasi', 'pompanisasi', '2026-08-21 17:19:36', '2026-08-21 17:19:36'),
(38, 'MitigasiBencana', 'mitigasibencana', '2026-08-21 17:19:36', '2026-08-21 17:19:36'),
(39, 'PerguruanTinggi', 'perguruantinggi', '2026-08-21 17:19:36', '2026-08-21 17:19:36'),
(40, 'IndustrialisasiNasional', 'industrialisasinasional', '2026-08-21 17:19:36', '2026-08-21 17:19:36'),
(41, 'Hilirisasi', 'hilirisasi', '2026-08-21 17:19:36', '2026-08-21 17:19:36'),
(42, 'MagangNasional2026', 'magangnasional2026', '2026-08-21 17:19:37', '2026-08-21 17:19:37'),
(43, 'GenerasiMuda', 'generasimuda', '2026-08-21 17:19:37', '2026-08-21 17:19:37'),
(44, 'BUMN', 'bumn', '2026-08-21 17:19:37', '2026-08-21 17:19:37'),
(45, 'InfoMagang', 'infomagang', '2026-08-21 17:19:37', '2026-08-21 17:19:37'),
(46, 'DanaKampanye', 'danakampanye', '2026-08-21 17:19:38', '2026-08-21 17:19:38'),
(47, 'KPURI', 'kpuri', '2026-08-21 17:19:38', '2026-08-21 17:19:38'),
(48, 'Bawaslu', 'bawaslu', '2026-08-21 17:19:38', '2026-08-21 17:19:38'),
(49, 'TransparansiPolitik', 'transparansipolitik', '2026-08-21 17:19:38', '2026-08-21 17:19:38'),
(50, 'KomputerKuantum', 'komputerkuantum', '2026-08-21 17:19:38', '2026-08-21 17:19:38'),
(51, 'ArtificialIntelligence', 'artificialintelligence', '2026-08-21 17:19:38', '2026-08-21 17:19:38'),
(52, 'InovasiTeknologi', 'inovasiteknologi', '2026-08-21 17:19:38', '2026-08-21 17:19:38'),
(53, 'SiliconValley', 'siliconvalley', '2026-08-21 17:19:38', '2026-08-21 17:19:38'),
(54, 'BadmintonIndonesia', 'badmintonindonesia', '2026-08-21 17:19:39', '2026-08-21 17:19:39'),
(55, 'IndonesiaJuara', 'indonesiajuara', '2026-08-21 17:19:39', '2026-08-21 17:19:39'),
(56, 'WorldChampionships2026', 'worldchampionships2026', '2026-08-21 17:19:39', '2026-08-21 17:19:39'),
(57, 'KendaraanListrik', 'kendaraanlistrik', '2026-08-21 17:19:40', '2026-08-21 17:19:40'),
(58, 'SPKLU', 'spklu', '2026-08-21 17:19:40', '2026-08-21 17:19:40'),
(59, 'MobilListrik', 'mobillistrik', '2026-08-21 17:19:40', '2026-08-21 17:19:40'),
(60, 'TransJawa', 'transjawa', '2026-08-21 17:19:40', '2026-08-21 17:19:40'),
(61, 'EnergiBersih', 'energibersih', '2026-08-21 17:19:40', '2026-08-21 17:19:40'),
(62, 'RisetKesehatan', 'risetkesehatan', '2026-08-21 17:19:41', '2026-08-21 17:19:41'),
(63, 'PanganSehat', 'pangansehat', '2026-08-21 17:19:41', '2026-08-21 17:19:41'),
(64, 'Mikrobioma', 'mikrobioma', '2026-08-21 17:19:41', '2026-08-21 17:19:41'),
(65, 'ImunitasTubuh', 'imunitastubuh', '2026-08-21 17:19:41', '2026-08-21 17:19:41'),
(66, 'BRIN', 'brin', '2026-08-21 17:19:41', '2026-08-21 17:19:41'),
(67, 'LabuanBajo', 'labuanbajo', '2026-08-21 17:19:42', '2026-08-21 17:19:42'),
(68, 'RajaAmpat', 'rajaampat', '2026-08-21 17:19:42', '2026-08-21 17:19:42'),
(69, 'WonderfulIndonesia', 'wonderfulindonesia', '2026-08-21 17:19:42', '2026-08-21 17:19:42'),
(70, 'WisataBahari', 'wisatabahari', '2026-08-21 17:19:42', '2026-08-21 17:19:42'),
(71, 'Travel2026', 'travel2026', '2026-08-21 17:19:42', '2026-08-21 17:19:42'),
(72, 'KTTIklim', 'kttiklim', '2026-08-21 17:19:44', '2026-08-21 17:19:44'),
(73, 'TransisiEnergi', 'transisienergi', '2026-08-21 17:19:44', '2026-08-21 17:19:44'),
(74, 'EnergiHijau', 'energihijau', '2026-08-21 17:19:44', '2026-08-21 17:19:44'),
(75, 'BeritaInternasional', 'beritainternasional', '2026-08-21 17:19:44', '2026-08-21 17:19:44'),
(76, 'PBB', 'pbb', '2026-08-21 17:19:44', '2026-08-21 17:19:44');

-- --------------------------------------------------------
-- Struktur tabel: `articles`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',
  `media_badge` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_sticky` tinyint(1) NOT NULL DEFAULT 0,
  `is_slider` tinyint(1) NOT NULL DEFAULT 0,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_user_id_foreign` (`user_id`),
  KEY `articles_category_id_foreign` (`category_id`),
  CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `articles` (`id`, `user_id`, `category_id`, `title`, `slug`, `excerpt`, `content`, `image`, `image_caption`, `image_source`, `media_type`, `media_badge`, `video_url`, `video_id`, `is_sticky`, `is_slider`, `views_count`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '[Sticky Post] Pemerintah Resmi Luncurkan Logo dan Identitas Visual HUT Ke-81 Kemerdekaan RI', 'pemerintah-resmi-luncurkan-logo-dan-identitas-visual-hut-ke-81-kemerdekaan-ri', 'Pemerintah Republik Indonesia melalui Kementerian Sekretariat Negara (Kemensetneg) resmi meluncurkan logo dan identitas visual peringatan Hari Ulang Tahun (HUT) ke-81 Kemerdekaan RI tahun 2026.', '<p>Pemerintah Republik Indonesia melalui Kementerian Sekretariat Negara (Kemensetneg) resmi meluncurkan logo dan identitas visual peringatan Hari Ulang Tahun (HUT) ke-81 Kemerdekaan RI tahun 2026.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_1_pemerintah-resmi-luncurkan-logo-dan-identitas-visual-hut-ke-81-kemerdekaan-ri.webp', 'Peluncuran Logo dan Identitas Visual HUT Ke-81 Kemerdekaan RI', 'Biro Pers Sekretariat Presiden RI', 'standard', NULL, NULL, NULL, 1, 0, 5420, 'published', '2026-07-01 16:45:37', '2026-08-21 16:55:01', '2026-08-21 17:19:33'),
(2, 1, 1, 'Warga Sambut Antusias Peresmian Bendungan Meninting, Lombok Barat', 'warga-sambut-antusias-peresmian-bendungan-meninting-lombok-barat', 'Suasana penuh semangat menyambut kedatangan Presiden Prabowo Subianto di kawasan Bendungan Meninting, Kabupaten Lombok Barat, Provinsi Nusa Tenggara Barat (NTB).', '<p>Suasana penuh semangat menyambut kedatangan Presiden Prabowo Subianto di kawasan Bendungan Meninting, Kabupaten Lombok Barat, Provinsi Nusa Tenggara Barat (NTB).</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_2_warga-sambut-antusias-peresmian-bendungan-meninting-lombok-barat.webp', 'Warga menyambut peresmian Bendungan Meninting di Lombok Barat', 'Biro Pers Sekretariat Presiden / PUPR', 'video', '02:07', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'dQw4w9WgXcQ', 0, 1, 4892, 'published', '2026-07-16 08:04:57', '2026-08-21 16:55:02', '2026-08-21 17:25:19'),
(3, 1, 1, 'Dari Kesulitan Air Menuju Panen Tiga Kali, Warga Sambut Antusias Peresmian Bendungan Meninting di NTB', 'dari-kesulitan-air-menuju-panen-tiga-kali-warga-sambut-antusias-peresmian-bendungan-meninting-di-ntb', 'Kehadiran Bendungan Meninting menjadi babak baru bagi para petani di Lombok Barat yang selama puluhan tahun mengandalkan tadah hujan.', '<p>Kehadiran Bendungan Meninting menjadi babak baru bagi para petani di Lombok Barat yang selama puluhan tahun mengandalkan tadah hujan.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_3_dari-kesulitan-air-menuju-panen-tiga-kali-warga-sambut-antusias-peresmian-bendungan-meninting-di-ntb.webp', 'Saluran irigasi Bendungan Meninting mengalir ke sawah warga', 'Kementerian PUPR RI', 'photo', '3 Foto', NULL, NULL, 0, 1, 3720, 'published', '2026-07-16 06:39:08', '2026-08-21 16:55:02', '2026-08-21 17:19:34'),
(4, 1, 1, 'Seskab Teddy: Presiden Prabowo Terima Menlu Qatar, Bahas Penguatan Investasi dan 50 Tahun Hubungan Diplomatik', 'seskab-teddy-presiden-prabowo-terima-menlu-qatar-bahas-penguatan-investasi-dan-50-tahun-hubungan-diplomatik', 'Presiden Republik Indonesia Prabowo Subianto menerima kunjungan kehormatan dari Menteri Luar Negeri Qatar di Istana Negara, Jakarta.', '<p>Presiden Republik Indonesia Prabowo Subianto menerima kunjungan kehormatan dari Menteri Luar Negeri Qatar di Istana Negara, Jakarta.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_4_seskab-teddy-presiden-prabowo-terima-menlu-qatar-bahas-penguatan-investasi-dan-50-tahun-hubungan-diplomatik.webp', 'Pertemuan bilateral Presiden Prabowo dengan Menlu Qatar di Istana Merdeka', 'Sekretariat Kabinet RI', 'standard', NULL, NULL, NULL, 0, 1, 2950, 'published', '2026-07-02 15:19:28', '2026-08-21 16:55:02', '2026-08-21 17:19:35'),
(5, 1, 1, 'Global Bond Perdana Danantara Catat Hasil Positif, Bukti Kepercayaan Investor Dunia terhadap Indonesia Tetap Tinggi', 'global-bond-perdana-danantara-catat-hasil-positif-bukti-kepercayaan-investor-dunia-terhadap-indonesia-tetap-tinggi', 'Penerbitan obligasi global (global bond) perdana oleh Badan Pengelola Investasi Danantara sukses mencatatkan hasil positif dengan oversubscribed 4.5 kali.', '<p>Penerbitan obligasi global (global bond) perdana oleh Badan Pengelola Investasi Danantara sukses mencatatkan hasil positif dengan oversubscribed 4.5 kali.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_5_global-bond-perdana-danantara-catat-hasil-positif-bukti-kepercayaan-investor-dunia-terhadap-indonesia-tetap-tinggi.webp', 'Konferensi pers peluncuran Global Bond Danantara di Jakarta', 'BPI Danantara / Antara Foto', 'standard', NULL, NULL, NULL, 0, 1, 3120, 'published', '2026-07-02 15:13:15', '2026-08-21 16:55:02', '2026-08-21 17:19:35'),
(6, 1, 1, 'Hadapi El Nino Godzilla, Pemerintah Pastikan Kesiapan Cadangan Pangan dan Infrastruktur Pertanian Nasional', 'hadapi-el-nino-godzilla-pemerintah-pastikan-kesiapan-cadangan-pangan-dan-infrastruktur-pertanian-nasional', 'Pemerintah Republik Indonesia bergerak cepat mengambil langkah antisipasi menghadapi fenomena iklim ekstrem yang dijuluki El Nino Godzilla.', '<p>Pemerintah Republik Indonesia bergerak cepat mengambil langkah antisipasi menghadapi fenomena iklim ekstrem yang dijuluki El Nino Godzilla.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_6_hadapi-el-nino-godzilla-pemerintah-pastikan-kesiapan-cadangan-pangan-dan-infrastruktur-pertanian-nasional.webp', 'Inspeksi cadangan beras nasional di gudang Bulog Pusat', 'Kementerian Pertanian / Bulog', 'standard', NULL, NULL, NULL, 0, 1, 2480, 'published', '2026-07-01 17:08:02', '2026-08-21 16:55:02', '2026-08-21 17:19:36'),
(7, 1, 1, 'Presiden Prabowo Instruksikan Perguruan Tinggi Cetak SDM Unggul untuk Percepat Industrialisasi Nasional', 'presiden-prabowo-instruksikan-perguruan-tinggi-cetak-sdm-unggul-untuk-percepat-industrialisasi-nasional', 'Presiden Prabowo Subianto memberikan instruksi tegas kepada seluruh perguruan tinggi di Indonesia untuk mereformasi kurikulum demi mencetak SDM unggul.', '<p>Presiden Prabowo Subianto memberikan instruksi tegas kepada seluruh perguruan tinggi di Indonesia untuk mereformasi kurikulum demi mencetak SDM unggul.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_7_presiden-prabowo-instruksikan-perguruan-tinggi-cetak-sdm-unggul-untuk-percepat-industrialisasi-nasional.webp', 'Pertemuan Forum Rektor Indonesia bersama Presiden RI', 'Biro Pers Media Setpres', 'standard', NULL, NULL, NULL, 0, 1, 1980, 'published', '2026-07-01 17:00:20', '2026-08-21 16:55:02', '2026-08-21 17:19:36'),
(8, 1, 1, 'Seskab Teddy: Program Magang Nasional 2026 Angkatan Kedua Resmi Diluncurkan, Libatkan 150 Ribu Peserta', 'seskab-teddy-program-magang-nasional-2026-angkatan-kedua-resmi-diluncurkan-libatkan-150-ribu-peserta', 'Sekretaris Kabinet Teddy Indra Wijaya resmi meluncurkan Program Magang Nasional 2026 Angkatan Kedua dengan target serapan 150 ribu generasi muda.', '<p>Sekretaris Kabinet Teddy Indra Wijaya resmi meluncurkan Program Magang Nasional 2026 Angkatan Kedua dengan target serapan 150 ribu generasi muda.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_8_seskab-teddy-program-magang-nasional-2026-angkatan-kedua-resmi-diluncurkan-libatkan-150-ribu-peserta.webp', 'Peluncuran Program Magang Nasional Bersertifikat di Jakarta Convention Center', 'Setkab RI', 'standard', NULL, NULL, NULL, 0, 0, 2191, 'published', '2026-07-01 16:52:48', '2026-08-21 16:55:02', '2026-08-21 17:26:50'),
(9, 1, 3, 'Jamin Transparansi, KPU Batasi Dana Kampanye Pilkada Serentak Maksimal Rp50 Miliar per Paslon', 'jamin-transparansi-kpu-batasi-dana-kampanye-pilkada-serentak-maksimal-rp50-miliar-per-paslon', 'Komisi Pemilihan Umum (KPU) RI resmi menerbitkan PKPU terbaru mengenai batasan dana kampanye untuk Pilkada Serentak guna mencegah politik uang.', '<p>Komisi Pemilihan Umum (KPU) RI resmi menerbitkan PKPU terbaru mengenai batasan dana kampanye untuk Pilkada Serentak guna mencegah politik uang.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_9_jamin-transparansi-kpu-batasi-dana-kampanye-pilkada-serentak-maksimal-rp50-miliar-per-paslon.webp', 'Rapat Pleno Terbuka KPU RI bersama Bawaslu dan perwakilan partai', 'Humas KPU RI', 'standard', NULL, NULL, NULL, 0, 0, 1840, 'published', '2026-06-09 15:16:28', '2026-08-21 16:55:02', '2026-08-21 17:19:38'),
(10, 1, 6, 'Era Baru AI Komputasi: Prosesor Kuantum Portabel Pertama untuk Komputer Komersial Resmi Diluncurkan', 'era-baru-ai-komputasi-prosesor-kuantum-portabel-pertama-untuk-komputer-komersial-resmi-diluncurkan', 'Lanskap teknologi global kembali diguncang oleh inovasi mutakhir peluncuran prosesor kuantum komersial portabel pertama di dunia.', '<p>Lanskap teknologi global kembali diguncang oleh inovasi mutakhir peluncuran prosesor kuantum komersial portabel pertama di dunia.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_10_era-baru-ai-komputasi-prosesor-kuantum-portabel-pertama-untuk-komputer-komersial-resmi-diluncurkan.webp', 'Tampilan miniatur chip prosesor kuantum komersial', 'Silicon Valley Tech Media', 'standard', NULL, NULL, NULL, 0, 0, 2780, 'published', '2026-06-09 14:37:23', '2026-08-21 16:55:02', '2026-08-21 17:19:38'),
(11, 1, 5, 'Sejarah Baru! Tunggal Putra Indonesia Raih Gelar Juara di Kejuaraan Dunia Bulu Tangkis 2026', 'sejarah-baru-tunggal-putra-indonesia-raih-gelar-juara-di-kejuaraan-dunia-bulu-tangkis-2026', 'Gemuruh lagu Indonesia Raya membahana di Royal Arena Copenhagen setelah tunggal putra Indonesia menumbangkan unggulan pertama dalam final dramatis.', '<p>Gemuruh lagu Indonesia Raya membahana di Royal Arena Copenhagen setelah tunggal putra Indonesia menumbangkan unggulan pertama dalam final dramatis.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_11_sejarah-baru-tunggal-putra-indonesia-raih-gelar-juara-di-kejuaraan-dunia-bulu-tangkis-2026.webp', 'Momen kemenangan atlet bulu tangkis Indonesia di podium utama', 'PBSI Media / BWF', 'standard', NULL, NULL, NULL, 0, 0, 4150, 'published', '2026-06-05 14:51:29', '2026-08-21 16:55:02', '2026-08-21 17:19:39'),
(12, 1, 7, 'Tren Kendaraan Listrik 2026: Indonesia Perluas Jaringan SPKLU Ultra Fast Charging Antarkota', 'tren-kendaraan-listrik-2026-indonesia-perluas-jaringan-spklu-ultra-fast-charging-antarkota', 'Kementerian ESDM bersama PLN meresmikan penambahan 500 titik Stasiun Pengisian Kendaraan Listrik Umum (SPKLU) ultra-fast charging di jalur Tol Trans Jawa dan Sumatera.', '<p>Kementerian ESDM bersama PLN meresmikan penambahan 500 titik Stasiun Pengisian Kendaraan Listrik Umum (SPKLU) ultra-fast charging di jalur Tol Trans Jawa dan Sumatera.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_12_tren-kendaraan-listrik-2026-indonesia-perluas-jaringan-spklu-ultra-fast-charging-antarkota.webp', 'Stasiun pengisian daya cepat kendaraan listrik di rest area tol', 'PLN Icon Plus / Antara', 'standard', NULL, NULL, NULL, 0, 0, 1620, 'published', '2026-06-01 10:15:00', '2026-08-21 16:55:02', '2026-08-21 17:19:40'),
(13, 1, 8, 'Riset Medis Terbaru: Konsumsi Pangan Fermentasi Lokal Terbukti Tingkatkan Imunitas Tubuh', 'riset-medis-terbaru-konsumsi-pangan-fermentasi-lokal-terbukti-tingkatkan-imunitas-tubuh', 'Penelitian kolaboratif Fakultas Kedokteran dan BRIN mengungkap khasiat luar biasa makanan fermentasi tradisional Indonesia dalam menjaga mikrobioma usus dan daya tahan tubuh.', '<p>Penelitian kolaboratif Fakultas Kedokteran dan BRIN mengungkap khasiat luar biasa makanan fermentasi tradisional Indonesia dalam menjaga mikrobioma usus dan daya tahan tubuh.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_13_riset-medis-terbaru-konsumsi-pangan-fermentasi-lokal-terbukti-tingkatkan-imunitas-tubuh.webp', 'Laboratorium penelitian mikrobiologi pangan BRIN', 'BRIN Riset Kesehatan', 'standard', NULL, NULL, NULL, 0, 0, 1430, 'published', '2026-05-28 09:30:00', '2026-08-21 16:55:02', '2026-08-21 17:19:41'),
(14, 1, 9, 'Pesona Labuan Bajo & Raja Ampat: Masuk Daftar 10 Destinasi Wisata Bahari Terbaik Dunia 2026', 'pesona-labuan-bajo-raja-ampat-masuk-daftar-10-destinasi-wisata-bahari-terbaik-dunia-2026', 'Majalah pariwisata internasional bergengsi menobatkan dua ikon pariwisata bahari Indonesia dalam daftar destinasi maritim paling memesona di dunia tahun 2026.', '<p>Majalah pariwisata internasional bergengsi menobatkan dua ikon pariwisata bahari Indonesia dalam daftar destinasi maritim paling memesona di dunia tahun 2026.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_14_pesona-labuan-bajo-raja-ampat-masuk-daftar-10-destinasi-wisata-bahari-terbaik-dunia-2026.webp', 'Pemandangan pulau karang dan laut jernih di Raja Ampat', 'Kemenparekraf RI / Wonderful Indonesia', 'photo', '5 Foto', NULL, NULL, 0, 0, 3890, 'published', '2026-05-25 14:00:00', '2026-08-21 16:55:02', '2026-08-21 17:19:42'),
(15, 1, 2, 'KTT Iklim Global Sepakati Komitmen Pendanaan Transisi Energi Hijau untuk Negara Berkembang', 'ktt-iklim-global-sepakati-komitmen-pendanaan-transisi-energi-hijau-untuk-negara-berkembang', 'Konferensi Tingkat Tinggi (KTT) Perubahan Iklim di Jenewa mencapai kesepakatan bersejarah terkait skema pendanaan transisi energi terbarukan sebesar USD 100 miliar.', '<p>Konferensi Tingkat Tinggi (KTT) Perubahan Iklim di Jenewa mencapai kesepakatan bersejarah terkait skema pendanaan transisi energi terbarukan sebesar USD 100 miliar.</p><p>Perkembangan ini mendapatkan perhatian luas dari berbagai elemen masyarakat dan pemangku kepentingan di seluruh tanah air.</p><blockquote>\"Komitmen kami adalah terus menyajikan berita terpercaya, akurat, dan mendalam bagi kemajuan bangsa.\"</blockquote><p>Langkah strategis ini diharapkan memberikan dampak jangka panjang yang signifikan bagi pembangunan dan kesejahteraan masyarakat Indonesia.</p>', 'articles/art_15_ktt-iklim-global-sepakati-komitmen-pendanaan-transisi-energi-hijau-untuk-negara-berkembang.webp', 'Sidang pleno KTT Perubahan Iklim di Jenewa, Swiss', 'UN Climate Change Media', 'standard', NULL, NULL, NULL, 0, 0, 2050, 'published', '2026-05-20 11:20:00', '2026-08-21 16:55:02', '2026-08-21 17:19:44');

-- --------------------------------------------------------
-- Struktur tabel: `article_tag`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `article_tag`;
CREATE TABLE `article_tag` (
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`article_id`,`tag_id`),
  KEY `article_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `article_tag_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `article_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `article_tag` (`article_id`, `tag_id`) VALUES
(1, 12),
(1, 13),
(1, 14),
(1, 10),
(2, 1),
(2, 2),
(2, 5),
(2, 4),
(3, 9),
(3, 6),
(4, 25),
(4, 11),
(5, 17),
(6, 18),
(7, 19),
(9, 23),
(11, 21),
(1, 26),
(1, 27),
(2, 3),
(2, 10),
(3, 1),
(3, 4),
(4, 28),
(4, 29),
(4, 30),
(5, 31),
(5, 32),
(5, 33),
(5, 34),
(6, 35),
(6, 36),
(6, 37),
(6, 38),
(7, 39),
(7, 40),
(7, 41),
(8, 42),
(8, 43),
(8, 44),
(8, 45),
(9, 46),
(9, 47),
(9, 48),
(9, 49),
(10, 50),
(10, 51),
(10, 52),
(10, 53),
(11, 54),
(11, 55),
(11, 56),
(12, 57),
(12, 58),
(12, 59),
(12, 60),
(12, 61),
(13, 62),
(13, 63),
(13, 64),
(13, 65),
(13, 66),
(14, 67),
(14, 68),
(14, 69),
(14, 70),
(14, 71),
(15, 72),
(15, 73),
(15, 74),
(15, 75),
(15, 76);

-- --------------------------------------------------------
-- Struktur tabel: `comments`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_article_id_foreign` (`article_id`),
  CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comments` (`id`, `article_id`, `name`, `email`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ahmad Fadhil', 'ahmad@example.com', 'Informasi yang sangat mencerahkan dan komprehensif. Semoga infrastruktur ini membawa manfaat nyata bagi petani dan ekonomi daerah!', 1, '2026-08-21 11:55:02', '2026-08-21 16:55:02'),
(2, 1, 'Ratna Dewi', 'ratna@example.com', 'Pemberitaan yang sangat aktual dan berimbang. Sukses terus untuk redaksi Digiterkini!', 1, '2026-08-21 14:55:02', '2026-08-21 16:55:02'),
(3, 2, 'Ahmad Fadhil', 'ahmad@example.com', 'Informasi yang sangat mencerahkan dan komprehensif. Semoga infrastruktur ini membawa manfaat nyata bagi petani dan ekonomi daerah!', 1, '2026-08-21 11:55:02', '2026-08-21 16:55:02'),
(4, 2, 'Ratna Dewi', 'ratna@example.com', 'Pemberitaan yang sangat aktual dan berimbang. Sukses terus untuk redaksi Digiterkini!', 1, '2026-08-21 14:55:02', '2026-08-21 16:55:02'),
(5, 3, 'Ahmad Fadhil', 'ahmad@example.com', 'Informasi yang sangat mencerahkan dan komprehensif. Semoga infrastruktur ini membawa manfaat nyata bagi petani dan ekonomi daerah!', 1, '2026-08-21 11:55:02', '2026-08-21 16:55:02'),
(6, 3, 'Ratna Dewi', 'ratna@example.com', 'Pemberitaan yang sangat aktual dan berimbang. Sukses terus untuk redaksi Digiterkini!', 1, '2026-08-21 14:55:02', '2026-08-21 16:55:02'),
(7, 2, 'Budi Santoso', 'budi@example.com', 'Berita yang sangat informatif dan bermanfaat untuk masyarakat!', 1, '2026-08-21 17:01:38', '2026-08-21 17:01:38');

-- --------------------------------------------------------
-- Struktur tabel: `site_settings`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'SmartNews', '2026-08-21 16:55:02', '2026-08-21 17:11:39'),
(2, 'site_tagline', 'Portal Berita Terpercaya & Cerdas', '2026-08-21 16:55:02', '2026-08-21 17:11:39'),
(3, 'site_description', 'Portal berita Indonesia terpercaya, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.', '2026-08-21 16:55:02', '2026-08-21 16:55:02'),
(4, 'site_address', 'Jl. Sudirman Kav. 52–53, Jakarta Pusat 10220', '2026-08-21 16:55:02', '2026-08-21 16:55:02'),
(5, 'site_phone', '(012) 3456-7890', '2026-08-21 16:55:02', '2026-08-21 16:55:02'),
(6, 'site_email', 'redaksi@digiterkini.id', '2026-08-21 16:55:02', '2026-08-21 16:55:02'),
(7, 'social_facebook', 'https://facebook.com', '2026-08-21 16:55:02', '2026-08-21 16:55:02'),
(8, 'social_twitter', 'https://twitter.com', '2026-08-21 16:55:02', '2026-08-21 16:55:02'),
(9, 'social_tiktok', 'https://tiktok.com', '2026-08-21 16:55:02', '2026-08-21 16:55:02'),
(10, 'social_youtube', 'https://youtube.com', '2026-08-21 16:55:02', '2026-08-21 16:55:02');

-- --------------------------------------------------------
-- Struktur tabel: `sessions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur tabel: `cache`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Struktur tabel: `site_settings`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
('site_name', 'SmartNews', NOW(), NOW()),
('site_tagline', 'Portal Berita Terpercaya & Cerdas', NOW(), NOW()),
('site_description', 'SmartNews - Portal berita Indonesia terpercaya, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.', NOW(), NOW()),
('site_keywords', 'smartnews, berita terkini, berita indonesia, portal berita, nasional, politik, ekonomi, teknologi, olahraga', NOW(), NOW()),
('contact_email', 'redaksi@smartnews.id', NOW(), NOW()),
('contact_phone', '(012) 3456-7890', NOW(), NOW()),
('contact_address', 'Jl. Sudirman Kav. 52–53, Jakarta Pusat 10220', NOW(), NOW()),
('social_facebook', 'https://facebook.com', NOW(), NOW()),
('social_twitter', 'https://twitter.com', NOW(), NOW()),
('social_instagram', 'https://instagram.com', NOW(), NOW()),
('social_tiktok', 'https://tiktok.com', NOW(), NOW()),
('social_youtube', 'https://youtube.com', NOW(), NOW());

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
