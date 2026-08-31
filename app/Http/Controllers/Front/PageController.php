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
        $siteName = setting('site_name', 'SmartNews');
        $siteAddress = setting('contact_address', 'Jl. Sarjana, Timbangan, Ogan Ilir 30862');
        $sitePhone = setting('contact_phone', '(012) 3456-7890');
        $siteEmail = setting('contact_email', 'redaksi@smartnews.id');
        $adEmail = setting('contact_email', 'iklan@smartnews.id');

        $pages = [
            // 1. TENTANG KAMI
            'tentang-kami' => [
                'title' => 'Tentang Kami',
                'subtitle' => 'Mengenal Lebih Dekat Komitmen Jurnalisme Cerdas & Terpercaya ' . $siteName,
                'content' => '
                <div class="page-rich-content">
                    <p class="lead" style="font-size: 17.5px; font-weight: 500; line-height: 1.8; color: var(--text-main); margin-bottom: 24px;">
                        <strong>' . $siteName . '</strong> adalah portal berita digital Indonesia terdepan yang didirikan dengan tekad teguh menyajikan jurnalisme berkualitas, faktual, mendalam, dan independen untuk mencerdaskan kehidupan bangsa di tengah dinamika era disrupsi digital.
                    </p>

                    <h3>1. Profil & Latar Belakang Perusahaan</h3>
                    <p>
                        Berdiri di bawah naungan badan hukum pers terpercaya, <strong>' . $siteName . '</strong> hadir menjawab kebutuhan masyarakat akan referensi berita yang dapat dipertanggungjawabkan kebenarannya. Di tengah derasnya arus disinformasi, kabar bohong (hoaks), dan bias media, redaksi ' . $siteName . ' berkomitmen teguh memegang prinsip verifikasi fakta berlapis sebelum suatu informasi dipublikasikan kepada khalayak luas.
                    </p>
                    <p>
                        Dengan dukungan jaringan koresponden jurnalis di berbagai daerah strategis tanah air serta pemanfaatan infrastruktur teknologi informasi termutakhir, kami menyajikan liputan multidimensi mulai dari isu nasional, dinamika politik, ekonomi & bisnis makro-mikro, inovasi teknologi, hingga dinamika sosial budaya secara berimbang, transparan, dan berkeadilan.
                    </p>

                    <h3>2. Visi Kami</h3>
                    <p>
                        Menjadi ekosistem media siber nomor satu di Indonesia yang paling dipercaya, mencerahkan, dan menginspirasi kemajuan peradaban bangsa melalui jurnalisme berintegritas tinggi yang berpihak pada kebenaran dan kepentingan publik.
                    </p>

                    <h3>3. Misi Utama Kami</h3>
                    <ul>
                        <li><strong>Akurasi & Cek Fakta di Atas Kecepatan:</strong> Mengedepankan verifikasi sumber primer, konfirmasi berimbang, dan disiplin verifikasi tanpa mengorbankan kecepatan penyampaian informasi.</li>
                        <li><strong>Mencerdaskan Publik:</strong> Menyuguhkan liputan mendalam (in-depth reporting), investigasi faktual, dan analisis kontekstual yang mudah dipahami seluruh kalangan masyarakat.</li>
                        <li><strong>Independen & Berkeadilan:</strong> Menjaga netralitas dari tekanan politik, kepentingan kelompok, maupun kekuatan oligarki dalam setiap ruang pemberitaan.</li>
                        <li><strong>Inovasi Teknologi Media:</strong> Mengembangkan pengalaman membaca berita yang ramah pengguna, responsif, berkecepatan tinggi, dan diperkaya dengan fitur ringkasan cerdas berbasis teknologi AI terdepan.</li>
                        <li><strong>Pemberdayaan Masyarakat:</strong> Memfasilitasi ruang dialog publik yang sehat, inklusif, dan demokratis demi tegaknya supremasi hukum dan keadilan sosial.</li>
                    </ul>

                    <h3>4. Lima Nilai Inti Redaksi (Core Editorial Values)</h3>
                    <ol>
                        <li><strong>Integritas (Integrity):</strong> Menjunjung tinggi kejujuran intelektual, menolak segala bentuk gratifikasi atau suap, dan tunduk mutlak pada Kode Etik Jurnalistik Dewan Pers.</li>
                        <li><strong>Independensi (Independence):</strong> Independen dalam menilai fakta peristiwa dan menentukan agenda redaksional semata-mata demi kepentingan publik.</li>
                        <li><strong>Keberimbangan (Balance):</strong> Selalu menerapkan asas <em>cover both sides</em> (keberimbangan multi-pihak) secara proporsional dan adil.</li>
                        <li><strong>Transparansi (Transparency):</strong> Terbuka mengenai ralat koreksi berita dan identitas penanggung jawab redaksional kepada publik.</li>
                        <li><strong>Empati Kemanusiaan (Humanity):</strong> Mengedepankan kepedulian terhadap kelompok rentan, korban bencana, perempuan, dan anak-anak sesuai norma kemanusiaan universal.</li>
                    </ol>

                    <h3>5. Layanan & Jangkauan Kanal Informasi</h3>
                    <p>
                        ' . $siteName . ' mengoperasikan beragam kanal pemberitaan tematik yang dirancang secara khusus untuk memenuhi kebutuhan pembaca modern:
                    </p>
                    <ul>
                        <li><strong>Nasional & Politik:</strong> Liputan kebijakan pemerintahan, legislatif, yudikatif, dan dinamika kebangsaan.</li>
                        <li><strong>Ekonomi & Bisnis:</strong> Analisis pasar modal, perbankan, UMKM, komoditas, dan kebijakan fiskal-moneter.</li>
                        <li><strong>Teknologi & Sains:</strong> Perkembangan kecerdasan buatan (AI), transformasi digital, startup, keamanan siber, dan riset ilmiah.</li>
                        <li><strong>Internasional:</strong> Isu geopolitik global, diplomasi internasional, dan tren dunia terkini.</li>
                        <li><strong>Olahraga & Otomotif:</strong> Liputan kompetisi sepak bola nasional-dunia, balap, otomotif masa depan, dan gaya hidup sehat.</li>
                    </ul>
                </div>',
            ],

            // 2. SUSUNAN REDAKSI
            'redaksi' => [
                'title' => 'Susunan Redaksi',
                'subtitle' => 'Struktur Dewan Redaksi, Penasihat Hukum, & Manajemen ' . $siteName,
                'content' => '
                <div class="page-rich-content">
                    <p class="lead" style="font-size: 16px; color: var(--text-main); margin-bottom: 24px;">
                        Berikut adalah susunan lengkap jajaran Dewan Redaksi, Dewan Pembina, Penasihat Hukum, serta Manajemen Pengelola Media Siber <strong>' . $siteName . '</strong> yang bertanggung jawab penuh atas seluruh kebijakan penerbitan dan operasional pemberitaan.
                    </p>

                    <div style="background-color: var(--bg-muted); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; margin-bottom: 28px;">
                        <h3 style="margin-top: 0; color: var(--color-primary); border-bottom: 2px solid var(--color-primary); padding-bottom: 8px;">1. Dewan Pembina & Penasihat Hukum</h3>
                        <p><strong>Ketua Dewan Pembina:</strong> Prof. Dr. Ir. H. Bambang Soeprapto, M.Sc.<br>
                        <strong>Anggota Dewan Pembina:</strong> Dra. Hj. Ratna Juwita, M.Si.<br>
                        <strong>Ketua Penasihat Hukum & Advokasi Pers:</strong> Adv. Hendra Wijaya, S.H., M.H. & Rekan<br>
                        <strong>Konsultan Regulasi & Media Siber:</strong> Lembaga Bantuan Hukum Pers Nusantara</p>

                        <h3 style="color: var(--color-primary); border-bottom: 2px solid var(--color-primary); padding-bottom: 8px; margin-top: 24px;">2. Manajemen Perusahaan</h3>
                        <p><strong>Direktur Utama / Pemimpin Umum:</strong> Raden Arya Permana, S.E., M.B.A.<br>
                        <strong>Direktur Keuangan & Operasional:</strong> Anita Kusuma Wardhani, S.E., Ak.<br>
                        <strong>Direktur Bisnis & Kemitraan Strategis:</strong> Ir. Donny Prasetyo, M.M.<br>
                        <strong>Manajer SDM & Legalitas Perusahaan:</strong> Farida Rahmawati, S.Psi.</p>

                        <h3 style="color: var(--color-primary); border-bottom: 2px solid var(--color-primary); padding-bottom: 8px; margin-top: 24px;">3. Dewan Redaksi (Editorial Board)</h3>
                        <p><strong>Pemimpin Redaksi / Penanggung Jawab:</strong> Budi Santoso, M.I.Kom.<br>
                        <strong>Wakil Pemimpin Redaksi:</strong> Siti Nurhaliza, S.Sos., M.A.<br>
                        <strong>Redaktur Pelaksana (Managing Editor):</strong> Hendra Gunawan, S.I.Kom.<br>
                        <strong>Sekretaris Redaksi:</strong> Maya Puspitasari, S.Hum.</p>

                        <h3 style="color: var(--color-primary); border-bottom: 2px solid var(--color-primary); padding-bottom: 8px; margin-top: 24px;">4. Redaktur Desk Berita (Desk Editors)</h3>
                        <p><strong>Redaktur Nasional & Pemerintahan:</strong> Ahmad Fauzi, S.Sos.<br>
                        <strong>Redaktur Hukum & Kriminalitas:</strong> Rizky Ramadhan, S.H.<br>
                        <strong>Redaktur Ekonomi, Bisnis & Finansial:</strong> Diana Kartika, S.E.<br>
                        <strong>Redaktur Teknologi, Gadget & Sains:</strong> Kevin Pratama, S.Kom.<br>
                        <strong>Redaktur Olahraga & Otomotif:</strong> Bagas Satria Yudha, S.Or.<br>
                        <strong>Redaktur Gaya Hidup, Hiburan & Budaya:</strong> Clarissa Aurelia, S.Sn.<br>
                        <strong>Redaktur Cek Fakta & Verifikasi Data:</strong> M. Irfan Hidayat, S.Stat.</p>

                        <h3 style="color: var(--color-primary); border-bottom: 2px solid var(--color-primary); padding-bottom: 8px; margin-top: 24px;">5. Tim Multimedia & Kreatif</h3>
                        <p><strong>Kepala Tim Foto & Video Jurnalis:</strong> Danang Wicaksono<br>
                        <strong>Desainer Grafis & Infografis:</strong> Aldi Firmansyah, S.Ds.<br>
                        <strong>Editor Audio Visual & Motion:</strong> Bagus Triadi<br>
                        <strong>Manajer Media Sosial & Komunitas:</strong> Amanda Putri Maharani</p>

                        <h3 style="color: var(--color-primary); border-bottom: 2px solid var(--color-primary); padding-bottom: 8px; margin-top: 24px;">6. Teknologi Informasi & Pengembangan Sistem</h3>
                        <p><strong>Chief Technology Officer (CTO):</strong> Tim ' . $siteName . ' Core Tech<br>
                        <strong>Senior Web & Backend Engineer:</strong> System Development Division<br>
                        <strong>Spesialis Keamanan Siber (Infosec):</strong> Cyber Defense & Reliability Unit</p>

                        <h3 style="color: var(--color-primary); border-bottom: 2px solid var(--color-primary); padding-bottom: 8px; margin-top: 24px;">7. Kantor & Kontak Redaksi Resmi</h3>
                        <p>
                            <strong>Alamat Kantor Redaksi:</strong> ' . $siteAddress . '<br>
                            <strong>Telepon Kantor:</strong> ' . $sitePhone . '<br>
                            <strong>Surel / Email Redaksi:</strong> <a href="mailto:' . $siteEmail . '">' . $siteEmail . '</a><br>
                            <strong>Surel / Email Kerja Sama Bisnis:</strong> <a href="mailto:' . $adEmail . '">' . $adEmail . '</a>
                        </p>
                    </div>

                    <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; border-radius: 8px; padding: 16px 20px; font-size: 13.5px; color: #991b1b; line-height: 1.6;">
                        <strong>PEMBERITAHUAN RESMI KEPADA PUBLIK & MITRA KERJA:</strong><br>
                        Seluruh wartawan dan koresponden <strong>' . $siteName . '</strong> selalu dibekali Kartu Tanda Anggota (KTA) Pers resmi yang masih berlaku dan Surat Tugas yang ditandatangani Pemimpin Redaksi. Dalam menjalankan tugas peliputan, wartawan kami <strong>DILARANG KERAS</strong> meminta atau menerima imbalan, uang, fasilitas, bingkisan, atau gratifikasi dalam bentuk apapun dari narasumber. Jika ada pihak yang mengatasnamakan redaksi dan melakukan tindakan melanggar hukum, harap segera hubungi Call Center Redaksi kami.
                    </div>
                </div>',
            ],

            // 3. PEDOMAN MEDIA SIBER
            'pedoman-media-siber' => [
                'title' => 'Pedoman Pemberitaan Media Siber',
                'subtitle' => 'Kepatuhan Mutlak terhadap Standar Dewan Pers Republik Indonesia',
                'content' => '
                <div class="page-rich-content">
                    <p class="lead" style="font-size: 16px; color: var(--text-main); margin-bottom: 24px;">
                        Kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers adalah hak asasi manusia yang dilindungi oleh Pancasila, Undang-Undang Dasar 1945, dan Deklarasi Universal Hak Asasi Manusia PBB. Media siber <strong>' . $siteName . '</strong> mematuhi secara penuh <strong>Pedoman Pemberitaan Media Siber</strong> yang ditetapkan oleh Dewan Pers bersama komunitas pers di Jakarta pada tanggal 3 Februari 2012.
                    </p>

                    <h3>1. Ruang Lingkup</h3>
                    <p>
                        Media Siber adalah segala bentuk media yang menggunakan wahana internet dan melaksanakan kegiatan jurnalistik, serta memenuhi persyaratan Undang-Undang Pers dan Standar Perusahaan Pers yang ditetapkan Dewan Pers.
                    </p>
                    <p>
                        Isi Buatan Pengguna (User Generated Content) adalah segala isi yang dibuat dan atau dipublikasikan oleh pengguna media siber, antara lain artikel, gambar, komentar, suara, video dan berbagai bentuk unggahan yang melekat pada media siber, seperti blog, forum, komentar pembaca atau pemirsa, dan bentuk lain.
                    </p>

                    <h3>2. Verifikasi dan Keberimbangan Berita</h3>
                    <ol>
                        <li>Pada prinsipnya setiap berita harus melalui proses verifikasi fakta dan konfirmasi dari pihak terkait.</li>
                        <li>Berita yang dapat merugikan pihak lain memerlukan verifikasi pada berita yang sama untuk memenuhi prinsip akurasi dan keberimbangan (cover both sides).</li>
                        <li>Ketentuan butir (1) dan (2) dikecualikan dengan syarat mutlak:
                            <ul>
                                <li>Berita benar-benar mengandung kepentingan publik yang mendesak;</li>
                                <li>Sumber berita pertama adalah sumber yang jelas disebutkan identitasnya, kredibel dan kompeten;</li>
                                <li>Subyek berita yang harus dikonfirmasi belum dapat dihubungi dan redaksi telah berupaya maksimal mencarinya;</li>
                                <li>Media mencantumkan penjelasan bahwa berita tersebut masih memerlukan verifikasi lebih lanjut yang diupayakan dalam waktu secepatnya.</li>
                            </ul>
                        </li>
                        <li>Setelah memuat berita butir (3), media wajib meneruskan upaya verifikasi, dan setelah verifikasi didapatkan, hasilnya dicantumkan pada berita pembaruan (update) dengan tautan pada berita awal.</li>
                    </ol>

                    <h3>3. Isi Buatan Pengguna (User Generated Content)</h3>
                    <ol>
                        <li>' . $siteName . ' mewajibkan pengguna (user) untuk melakukan registrasi atau mengisi data diri yang sah sebelum dapat mempublikasikan komentar atau isi buatan pengguna.</li>
                        <li>' . $siteName . ' melarang keras pemuatan konten yang mengandung fitnah, ujaran kebencian (hate speech), SARA, cabul, sadisme, atau ajakan melanggar hukum.</li>
                        <li>' . $siteName . ' memiliki kewenangan penuh untuk menyunting, memoderasi, atau menghapus Isi Buatan Pengguna yang melanggar ketentuan hukum dan etika.</li>
                        <li>' . $siteName . ' wajib menyediakan mekanisme pengaduan Isi Buatan Pengguna yang dinilai melanggar ketentuan dan menindaklanjutinya dalam waktu selambat-lambatnya 2 x 24 jam.</li>
                    </ol>

                    <h3>4. Ralat, Koreksi, dan Hak Jawab</h3>
                    <ol>
                        <li>Ralat, koreksi, dan hak jawab mengacu pada Undang-Undang Pers, Kode Etik Jurnalistik, dan Pedoman Hak Jawab yang ditetapkan Dewan Pers.</li>
                        <li>Ralat, koreksi dan atau hak jawab wajib ditautkan pada berita yang diralat, dikoreksi atau yang diberi hak jawab.</li>
                        <li>Pada setiap berita ralat, koreksi, dan hak jawab wajib dicantumkan waktu pemuatan ralat, koreksi, dan atau hak jawab tersebut secara transparan.</li>
                        <li>Bila suatu berita media siber tertentu disebarluaskan media siber lain, maka tanggung jawab media siber penyadur terbatas pada berita yang disadurnya. Namun bila ada ralat dari sumber awal, media penyadur wajib melakukan ralat serupa.</li>
                    </ol>

                    <h3>5. Pencabutan Berita</h3>
                    <ol>
                        <li>Berita yang sudah dipublikasikan tidak dapat dicabut karena alasan penyensoran dari pihak luar redaksi, kecuali terkait masalah SARA, kesusilaan, masa depan anak, pengalaman traumatik korban atau berdasarkan pertimbangan khusus lain yang ditetapkan Dewan Pers.</li>
                        <li>Pencabutan berita wajib disertai dengan alasan pencabutan dan diumumkan kepada publik.</li>
                    </ol>

                    <h3>6. Iklan dan Berita Berbayar (Advertorial)</h3>
                    <p>
                        ' . $siteName . ' membedakan secara tegas dan transparan antara produk berita jurnalistik dengan artikel berbayar/iklan/advertorial. Setiap konten yang merupakan sponsor, promosi komersial, atau advertorial wajib diberi label yang jelas (seperti <em>"Iklan"</em>, <em>"Advertorial"</em>, atau <em>"Sponsored Content"</em>) agar tidak menyesatkan publik.
                    </p>

                    <h3>7. Hak Cipta dan Atribusi</h3>
                    <p>
                        ' . $siteName . ' menghormati sepenuhnya hak kekayaan intelektual pihak lain. Pengutipan berita, data, foto, infografis, atau video dari sumber luar selalu menyertakan atribusi sumber asli dan tautan rujukan yang sah sesuai kaidah hukum hak cipta.
                    </p>

                    <h3>8. Sengketa Pemberitaan</h3>
                    <p>
                        Penilaian akhir atas pelaksanaan dan kepatuhan terhadap Pedoman Pemberitaan Media Siber ini diselesaikan melalui mekanisme mediasi dan pertimbangan Dewan Pers Republik Indonesia.
                    </p>
                </div>',
            ],

            // 4. KODE ETIK & DISCLAIMER
            'kode-etik' => [
                'title' => 'Kode Etik Jurnalistik & Disclaimer',
                'subtitle' => 'Komitmen Etika Profesi Wartawan & Penyangkalan Hukum Resmi',
                'content' => '
                <div class="page-rich-content">
                    <h3>Bagian I: Kode Etik Jurnalistik (11 Pasal Dewan Pers)</h3>
                    <p>
                        Dalam menjalankan tugas peliputan, penghimpunan data, dan penyiaran informasi, seluruh jajaran redaksi <strong>' . $siteName . '</strong> tunduk dan patuh pada 11 Pasal Kode Etik Jurnalistik:
                    </p>

                    <ol style="line-height: 1.8;">
                        <li><strong>Pasal 1:</strong> Wartawan Indonesia bersikap independen, menghasilkan berita yang akurat, berimbang, dan tidak beritikad buruk.</li>
                        <li><strong>Pasal 2:</strong> Wartawan Indonesia menempuh cara-cara yang profesional dalam melaksanakan tugas jurnalistik.</li>
                        <li><strong>Pasal 3:</strong> Wartawan Indonesia selalu menguji informasi, memberitakan secara berimbang, tidak mencampurkan fakta dan opini yang menghakimi, serta menerapkan asas praduga tak bersalah.</li>
                        <li><strong>Pasal 4:</strong> Wartawan Indonesia tidak membuat berita bohong, fitnah, sadis, dan cabul.</li>
                        <li><strong>Pasal 5:</strong> Wartawan Indonesia tidak menyebutkan dan menyiarkan identitas korban kejahatan susila dan tidak menyebutkan identitas anak yang menjadi pelaku kejahatan.</li>
                        <li><strong>Pasal 6:</strong> Wartawan Indonesia tidak menyalahgunakan profesi dan tidak menerima suap.</li>
                        <li><strong>Pasal 7:</strong> Wartawan Indonesia memiliki hak tolak untuk melindungi narasumber yang tidak bersedia diketahui identitas maupun keberadaannya, menghargai ketentuan embargo, informasi latar belakang, dan <em>off the record</em> sesuai dengan kesepakatan.</li>
                        <li><strong>Pasal 8:</strong> Wartawan Indonesia tidak menulis atau menyiarkan berita berdasarkan prasangka atau diskriminasi terhadap seseorang atas dasar perbedaan suku, ras, warna kulit, agama, jenis kelamin, dan bahasa serta tidak merendahkan martabat orang lemah, miskin, sakit, cacat jiwa atau cacat jasmani.</li>
                        <li><strong>Pasal 9:</strong> Wartawan Indonesia menghormati hak narasumber tentang kehidupan pribadinya, kecuali untuk kepentingan publik.</li>
                        <li><strong>Pasal 10:</strong> Wartawan Indonesia segera mencabut, meralat, dan memperbaiki berita yang keliru dan tidak akurat disertai dengan permintaan maaf kepada pembaca, pendengar, dan atau pemirsa.</li>
                        <li><strong>Pasal 11:</strong> Wartawan Indonesia melayani hak jawab dan hak koreksi secara proporsional.</li>
                    </ol>

                    <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 32px 0;">

                    <h3>Bagian II: Disclaimer (Pernyataan Batasan Tanggung Jawab)</h3>
                    <p>
                        Seluruh materi informasi, analisis, infografis, video, serta opini yang dipublikasikan di portal <strong>' . $siteName . '</strong> disajikan dengan itikad baik untuk tujuan penyebarluasan informasi publik yang edukatif dan bermanfaat.
                    </p>

                    <h4>1. Batasan Tanggung Jawab Informasi</h4>
                    <p>
                        Redaksi berupaya semaksimal mungkin menyajikan data yang akurat dan kredibel pada saat penulisan. Namun demikian, ' . $siteName . ' tidak memberikan jaminan mutlak atas kelengkapan, keakuratan, ketepatan waktu, atau kesesuaian materi untuk tujuan komersial atau investasi tertentu. Pembaca bertanggung jawab penuh atas segala keputusan finansial, hukum, atau bisnis yang diambil berdasarkan isi artikel di situs ini.
                    </p>

                    <h4>2. Opini Kolumnis & Penulis Tamu</h4>
                    <p>
                        Artikel opini, esai kolom, serta tulisan blog tamu yang dimuat di ' . $siteName . ' merupakan pandangan pribadi masing-masing penulis yang bersangkutan dan tidak mencerminkan sikap resmi atau pandangan institusi redaksi ' . $siteName . '.
                    </p>

                    <h4>3. Tautan Menuju Situs Pihak Ketiga</h4>
                    <p>
                        Situs kami mungkin memuat tautan menuju situs web eksternal yang dioperasikan oleh pihak ketiga. ' . $siteName . ' tidak memiliki kendali atas isi, kebijakan privasi, atau praktik situs web pihak ketiga tersebut dan tidak bertanggung jawab atas kerugian yang ditimbulkannya.
                    </p>

                    <h4>4. Hak Kekayaan Intelektual (HAKI)</h4>
                    <p>
                        Seluruh hak cipta atas teks berita, foto orisinal, desain tata letak, dan logo ' . $siteName . ' dilindungi oleh Undang-Undang Republik Indonesia. Penggandaan, pendistribusian ulang, atau publikasi komersial tanpa izin tertulis dari redaksi adalah pelanggaran hukum. Pengutipan singkat untuk tujuan non-komersial diwajibkan menyertakan tautan sumber aktif menuju ' . $siteName . '.
                    </p>
                </div>',
            ],

            // 5. HUBUNGI KAMI
            'kontak' => [
                'title' => 'Hubungi Kami',
                'subtitle' => 'Saluran Komunikasi Redaksi, Kerja Sama Bisnis, & Layanan Pengaduan',
                'content' => '
                <div class="page-rich-content">
                    <p class="lead" style="font-size: 16px; color: var(--text-main); margin-bottom: 24px;">
                        Redaksi <strong>' . $siteName . '</strong> senantiasa terbuka menerima kritik yang membangun, saran, rilis pers (press release), permohonan hak jawab, klarifikasi berita, maupun tawaran kemitraan strategis dari instansi pemerintah, korporasi, komunitas, dan seluruh masyarakat.
                    </p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
                        <div style="background-color: var(--bg-muted); border: 1px solid var(--border-color); border-radius: 10px; padding: 20px;">
                            <h4 style="color: var(--color-primary); margin-top: 0; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-newspaper"></i> Meja Redaksi & Siaran Pers
                            </h4>
                            <p style="font-size: 13.5px; line-height: 1.6; color: var(--text-main);">
                                Untuk pengiriman press release resmi, undangan peliputan media, opini pembaca, atau klarifikasi berita:<br>
                                <strong>Email:</strong> <a href="mailto:' . $siteEmail . '">' . $siteEmail . '</a><br>
                                <strong>WhatsApp Redaksi:</strong> +62 812-3456-7890<br>
                                <strong>Waktu Respons:</strong> 24 Jam / 7 Hari
                            </p>
                        </div>

                        <div style="background-color: var(--bg-muted); border: 1px solid var(--border-color); border-radius: 10px; padding: 20px;">
                            <h4 style="color: #0284c7; margin-top: 0; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-bullhorn"></i> Iklan, Sponsorship & Kemitraan
                            </h4>
                            <p style="font-size: 13.5px; line-height: 1.6; color: var(--text-main);">
                                Untuk pemasangan banner display, advertorial berbayar, media partner event, atau sponsorship korporat:<br>
                                <strong>Email:</strong> <a href="mailto:' . $adEmail . '">' . $adEmail . '</a><br>
                                <strong>Telepon Bisnis:</strong> ' . $sitePhone . '<br>
                                <strong>Jam Layanan:</strong> Senin – Jumat, 08.30 – 17.00 WIB
                            </p>
                        </div>
                    </div>

                    <h3>Kantor Pusat Redaksi & Manajemen</h3>
                    <div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; padding: 22px; margin-bottom: 24px; box-shadow: var(--shadow-sm);">
                        <p style="font-size: 15px; margin-bottom: 12px;">
                            <i class="fas fa-map-marker-alt" style="color: var(--color-primary); width: 22px;"></i>
                            <strong>Alamat Resmi:</strong> ' . $siteAddress . '
                        </p>
                        <p style="font-size: 15px; margin-bottom: 12px;">
                            <i class="fas fa-phone-alt" style="color: var(--color-primary); width: 22px;"></i>
                            <strong>Telepon / Hunting:</strong> ' . $sitePhone . '
                        </p>
                        <p style="font-size: 15px; margin-bottom: 12px;">
                            <i class="fas fa-envelope" style="color: var(--color-primary); width: 22px;"></i>
                            <strong>Surat Elektronik Utama:</strong> ' . $siteEmail . '
                        </p>
                        <p style="font-size: 15px; margin-bottom: 0;">
                            <i class="fas fa-globe" style="color: var(--color-primary); width: 22px;"></i>
                            <strong>Website Resmi:</strong> <a href="' . route('home') . '">' . url('/') . '</a>
                        </p>
                    </div>

                    <h3>Prosedur Pengajuan Hak Jawab & Hak Koreksi</h3>
                    <p>
                        Sesuai amanat Undang-Undang Pers No. 40 Tahun 1999 dan Pedoman Pemberitaan Media Siber Dewan Pers, setiap pihak yang merasa dirugikan nama baiknya atau mendapati kekeliruan data dalam pemberitaan berhak mengajukan Hak Jawab atau Hak Koreksi dengan ketentuan:
                    </p>
                    <ol style="font-size: 14px; line-height: 1.7;">
                        <li>Kirimkan surat permohonan resmi secara tertulis melalui surel ke <strong>' . $siteEmail . '</strong> dengan subjek: <code>[HAK JAWAB / KLARIFIKASI] - Judul Berita Terkait</code>.</li>
                        <li>Sertakan bukti identitas diri yang sah (KTP / Paspor / Surat Kuasa Resmi bagi lembaga/perusahaan).</li>
                        <li>Jelaskan secara spesifik bagian artikel, kalimat, atau data yang dinilai keliru beserta fakta/data tandingan yang sah.</li>
                        <li>Redaksi ' . $siteName . ' akan memverifikasi dan menindaklanjuti permohonan dalam waktu selambat-lambatnya 1 x 24 jam kerja.</li>
                    </ol>
                </div>',
            ],

            // 6. PASANG IKLAN
            'pasang-iklan' => [
                'title' => 'Pasang Iklan & Media Partner',
                'subtitle' => 'Solusi Promosi Digital Efektif, Terarah, & Menjangkau Jutaan Pembaca Potensial',
                'content' => '
                <div class="page-rich-content">
                    <p class="lead" style="font-size: 16px; color: var(--text-main); margin-bottom: 24px;">
                        Tingkatkan eksposur merek (brand awareness), konversi penjualan, dan reputasi bisnis Anda bersama <strong>' . $siteName . '</strong>. Kami menyediakan beragam inventaris periklanan digital yang dirancang adaptif, ramah seluler, dan memiliki tingkat keterlibatan (engagement rate) tinggi.
                    </p>

                    <h3>1. Format & Inventaris Iklan yang Tersedia</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px; margin: 20px 0 28px 0;">
                        <div style="border: 1px solid var(--border-color); border-radius: 8px; padding: 16px; background-color: var(--bg-card);">
                            <h4 style="color: var(--color-primary); margin-top: 0;"><i class="fas fa-columns"></i> Header Leaderboard</h4>
                            <p style="font-size: 13px; color: var(--text-muted);">Ukuran: 728x90 (Desktop) / 320x100 (Mobile). Tampil di bagian paling atas halaman di bawah bar navigasi utama.</p>
                        </div>
                        <div style="border: 1px solid var(--border-color); border-radius: 8px; padding: 16px; background-color: var(--bg-card);">
                            <h4 style="color: var(--color-primary); margin-top: 0;"><i class="fas fa-newspaper"></i> Homepage In-Feed Banner</h4>
                            <p style="font-size: 13px; color: var(--text-muted);">Ukuran: 728x90 / 336x280. Menyatu secara natural (native) di antara daftar feed berita terkini beranda.</p>
                        </div>
                        <div style="border: 1px solid var(--border-color); border-radius: 8px; padding: 16px; background-color: var(--bg-card);">
                            <h4 style="color: var(--color-primary); margin-top: 0;"><i class="fas fa-file-alt"></i> In-Content Article Ad</h4>
                            <p style="font-size: 13px; color: var(--text-muted);">Ukuran: 300x250 / Banner Responsif. Disisipkan otomatis di tengah-tengah paragraf artikel dengan CTR tertinggi.</p>
                        </div>
                        <div style="border: 1px solid var(--border-color); border-radius: 8px; padding: 16px; background-color: var(--bg-card);">
                            <h4 style="color: var(--color-primary); margin-top: 0;"><i class="fas fa-th-large"></i> Sidebar Medium Rectangle</h4>
                            <p style="font-size: 13px; color: var(--text-muted);">Ukuran: 300x250 / 300x600. Tampil di kolom samping (sidebar) beranda dan setiap halaman artikel berita.</p>
                        </div>
                    </div>

                    <h3>2. Layanan Advertorial & Sponsored Post (Native Article)</h3>
                    <p>
                        Layanan penulisan artikel berbayar (advertorial) yang disusun oleh tim jurnalis profesional kami dengan kaidah SEO on-page optimal, bahasa yang memikat, dan didistribusikan ke seluruh kanal sosial media resmi ' . $siteName . '. Sangat efektif untuk peluncuran produk baru, pencapaian korporasi (CSR), profil tokoh publik, maupun promosi event nasional.
                    </p>

                    <h3>3. Program Media Partner Acara (Event Partnership)</h3>
                    <p>
                        ' . $siteName . ' membuka kerja sama sebagai Media Partner resmi untuk seminar nasional/internasional, pameran bisnis (expo), festival kebudayaan, kompetisi olahraga, dan kegiatan kampus. Keuntungan meliputi publikasi artikel rilis berita pra & pasca acara serta pencantuman logo sponsor.
                    </p>

                    <h3>4. Hubungi Tim Bisnis & Periklanan</h3>
                    <p>
                        Dapatkan paket penawaran khusus dan <em>Rate Card</em> resmi dengan menghubungi tim marketing kami:
                    </p>
                    <div style="background-color: var(--bg-muted); border-radius: 8px; padding: 18px 22px; font-size: 14px; line-height: 1.8;">
                        <strong>Departemen Iklan & Bisnis Digital:</strong><br>
                        <strong>Email:</strong> <a href="mailto:' . $adEmail . '">' . $adEmail . '</a><br>
                        <strong>Hotline WhatsApp Marketing:</strong> +62 812-3456-7890<br>
                        <strong>Alamat:</strong> ' . $siteAddress . '
                    </div>
                </div>',
            ],

            // 7. PRIVACY POLICY
            'privacy-policy' => [
                'title' => 'Kebijakan Privasi (Privacy Policy)',
                'subtitle' => 'Perlindungan Data Pribadi Pengunjung ' . $siteName . ' Sesuai UU No. 27 Tahun 2022',
                'content' => '
                <div class="page-rich-content">
                    <p class="lead" style="font-size: 16px; color: var(--text-main); margin-bottom: 24px;">
                        Privasi pengunjung situs adalah prioritas tertinggi bagi <strong>' . $siteName . '</strong>. Dokumen Kebijakan Privasi ini menjelaskan bagaimana data dan informasi pribadi Anda dikumpulkan, digunakan, dilindungi, dan dikelola saat mengakses layanan situs kami.
                    </p>

                    <h3>1. Informasi yang Kami Kumpulkan</h3>
                    <ul>
                        <li><strong>Data yang Anda Berikan Secara Sukarela:</strong> Nama, alamat email, dan nomor telepon saat Anda mendaftar akun, mengirimkan formulir kontak, atau mengirim komentar berita.</li>
                        <li><strong>Data Teknis Otomatis:</strong> Alamat Protokol Internet (IP address), jenis perangkat (browser/device), sistem operasi, halaman yang dikunjungi, durasi kunjungan, serta data diagnostik log server.</li>
                        <li><strong>Cookies dan Penyimpanan Lokal:</strong> Kami menggunakan cookies dan localStorage untuk mengingat preferensi tampilan Anda (seperti Dark Mode dan ukuran font artikel) guna meningkatkan kenyamanan navigasi.</li>
                    </ul>

                    <h3>2. Penggunaan Informasi</h3>
                    <p>
                        Informasi yang kami kumpulkan digunakan secara eksklusif untuk:
                    </p>
                    <ol>
                        <li>Menyediakan, memelihara, dan mengoptimalkan performa situs portal berita kami.</li>
                        <li>Memproses dan memoderasi komentar pembaca guna mencegah spam dan ujaran kebencian.</li>
                        <li>Mengukur statistik dan analitik lalu lintas pembaca secara agregat tanpa mengidentifikasi individu secara personal.</li>
                        <li>Menayangkan materi iklan display yang relevan melalui mitra jaringan periklanan resmi.</li>
                    </ol>

                    <h3>3. Keamanan & Perlindungan Data</h3>
                    <p>
                        Kami menerapkan enkripsi standar industri (SSL/TLS HTTPS) dan protokol keamanan firewall ketat untuk melindungi informasi pribadi Anda dari akses tanpa hak, penyalahgunaan, kebocoran, atau perubahan yang tidak sah. Kami <strong>TIDAK PERNAH</strong> menjual, menyewakan, atau memperdagangkan data pribadi Anda kepada pihak ketiga manapun untuk tujuan komersial.
                    </p>

                    <h3>4. Hak Anda atas Data Pribadi</h3>
                    <p>
                        Sesuai Undang-Undang Republik Indonesia Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi (UU PDP), Anda memiliki hak untuk mengakses, memperbaiki, meminta penghapusan, atau membatasi pemrosesan data pribadi Anda yang tersimpan di sistem kami dengan menghubungi Petugas Perlindungan Data kami melalui surel <strong>' . $siteEmail . '</strong>.
                    </p>
                </div>',
            ],

            // 8. SYARAT & KETENTUAN (TERMS)
            'terms' => [
                'title' => 'Syarat & Ketentuan Layanan (Terms of Service)',
                'subtitle' => 'Ketentuan Penggunaan & Regulasi Akses Portal Berita ' . $siteName,
                'content' => '
                <div class="page-rich-content">
                    <p class="lead" style="font-size: 16px; color: var(--text-main); margin-bottom: 24px;">
                        Selamat datang di portal berita <strong>' . $siteName . '</strong>. Dengan mengakses dan menggunakan situs ini, Anda menyetujui untuk terikat oleh Syarat & Ketentuan Layanan yang berlaku di bawah ini.
                    </p>

                    <h3>1. Ketentuan Akses & Penggunaan</h3>
                    <p>
                        Pengunjung berhak mengakses seluruh artikel, gambar, video, dan infografis untuk konsumsi pribadi dan non-komersial. Pengunjung dilarang melakukan tindakan yang dapat merusak, mengganggu, melumpuhkan infrastruktur server, atau melakukan ekstraksi data massal (scraping/crawling) ilegal tanpa izin tertulis dari manajemen.
                    </p>

                    <h3>2. Kebijakan Komentar & Etika Diskusi</h3>
                    <p>
                        Kolom komentar disediakan sebagai sarana pertukaran gagasan publik yang sehat. Pengguna dilarang mengunggah komentar yang mengandung unsur fitnah, provokasi permusuhan (SARA), ujaran kebencian, pornografi, spam komersial, atau konten yang melanggar hukum Republik Indonesia. Redaksi berhak menghapus komentar dan memblokir akun yang melanggar ketentuan ini.
                    </p>

                    <h3>3. Hak Cipta & Kepemilikan Konten</h3>
                    <p>
                        Seluruh logo, merek dagang, naskah artikel berita, dan konten multimedia di portal ini adalah milik sah ' . $siteName . ' atau pemberi lisensi resminya dan dilindungi oleh Undang-Undang Hak Cipta Republik Indonesia.
                    </p>

                    <h3>4. Hukum yang Mengatur (Yurisdiksi)</h3>
                    <p>
                        Syarat dan ketentuan ini tunduk dan diatur berdasarkan hukum negara Republik Indonesia. Segala perselisihan yang timbul akan diselesaikan terlebih dahulu secara musyawarah mufakat, atau melalui jalur hukum di wilayah yurisdiksi Pengadilan Negeri Republik Indonesia.
                    </p>
                </div>',
            ],
        ];

        // Alias support for flexible URLs
        $aliases = [
            'susunan-redaksi' => 'redaksi',
            'disclaimer' => 'kode-etik',
            'kode-etik-disclaimer' => 'kode-etik',
            'hubungi-kami' => 'kontak',
            'iklan' => 'pasang-iklan',
            'media-partner' => 'pasang-iklan',
            'privacy' => 'privacy-policy',
            'kebijakan-privasi' => 'privacy-policy',
            'syarat-ketentuan' => 'terms',
            'terms-conditions' => 'terms',
        ];

        $resolvedKey = $aliases[$page] ?? $page;
        $pageData = $pages[$resolvedKey] ?? $pages['tentang-kami'];

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
