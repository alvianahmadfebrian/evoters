<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::truncate();

        Article::create([
            'title' => 'Panduan Lengkap Tata Cara Memberikan Suara Online di Platform eVoters',
            'slug' => 'panduan-lengkap-tata-cara-memberikan-suara-online',
            'category' => 'Panduan Voting',
            'author_name' => 'Panitia Pemilihan',
            'excerpt' => 'Simak langkah mudah menggunakan hak pilih Anda secara online, mulai dari verifikasi token/email OTP, memilih kandidat, hingga melihat bukti resi suara.',
            'content' => "Proses pemungutan suara online (e-voting) di platform eVoters dirancang agar mudah, cepat, dan 100% aman untuk seluruh pemilih terdaftar.\n\nBerikut langkah-langkah praktis untuk menyalurkan hak suara Anda:\n\n1. Pilih Event Pemilihan\nKunjungi beranda atau katalog event, lalu pilih agenda voting yang sedang aktif dan sesuai dengan hak pilih Anda.\n\n2. Kenali Pasangan Calon / Kandidat\nBaca profil, nomor urut, visi, misi, dan program kerja masing-masing kandidat sebelum menentukan pilihan terbaik.\n\n3. Masukkan Kredensial Valid\n- Untuk Pemilihan Sistem Token: Masukkan kode token resmi yang telah dibagikan oleh panitia (1 token berlaku untuk 1 kali pemilihan).\n- Untuk Pemilihan Sistem Email OTP: Masukkan alamat email aktif Anda dan masukkan 6 digit kode OTP verifikasi yang dikirimkan ke kotak masuk.\n\n4. Berikan Suara & Konfirmasi Pilihan\nKlik tombol 'Vote Sekarang' pada kandidat pilihan Anda, lalu konfirmasi pilihan di bilik suara digital.\n\n5. Simpan Bukti Resi Kriptografi\nSetelah voting berhasil, Anda akan menerima nomor resi transaksi suara yang tercatat permanen dalam sistem sebagai bukti partisipasi yang sah.",
            'image' => 'images/news_voting_guide.jpg',
            'status' => 'published',
            'views_count' => 185,
            'published_at' => now()->subDays(2),
        ]);

        Article::create([
            'title' => 'Bogor Marching Band Championship 2026: Persaingan Ketat di Puncak Klasemen Sementara',
            'slug' => 'bogor-marching-band-championship-2026-persaingan-ketat',
            'category' => 'Update Event',
            'author_name' => 'Redaksi eVoters',
            'excerpt' => 'Perolehan suara sementara ajang Bogor Marching Band Championship 2026 berlangsung sengit dengan selisih suara tipis antar kontestan.',
            'content' => "Ajang bergengsi Bogor Marching Band Championship (BOMC) 2026 yang berlangsung di area Tugu Kujang Bogor telah memasuki hari kedua pemungutan suara online.\n\nAntusiasme para pendukung dan alumni sekolah terlihat sangat tinggi sejak bilik suara digital dibuka. Sistem leaderboard real-time mencatat ribuan suara telah masuk secara sah melalui verifikasi OTP Email dan QRIS otomatis.\n\nUnit Marching Band Kujang Siliwangi saat ini memimpin klasemen sementara, dibayangi ketat oleh Marching Band Swara Pajajaran dengan selisih perolehan suara yang sangat tipis.\n\nPanitia pelaksana mengimbau seluruh pendukung untuk tetap menyalurkan hak pilih secara tertib sebelum batas waktu penutupan voting berakhir. Hasil rekapitulasi akhir akan diumumkan secara serentak setelah sesi pemilihan ditutup resmi.",
            'image' => 'images/news_marching_band.jpg',
            'status' => 'published',
            'views_count' => 240,
            'published_at' => now()->subDays(1),
        ]);

        Article::create([
            'title' => 'Sistem Anti-Duplikasi & Audit Real-Time Jamin Kejujuran Pemungutan Suara',
            'slug' => 'sistem-anti-duplikasi-dan-audit-real-time-jamin-kejujuran-voting',
            'category' => 'Keamanan Voting',
            'author_name' => 'Tim Teknis eVoters',
            'excerpt' => 'Bagaimana algoritma enkripsi SHA-256 dan protokol Zero-Knowledge mencegah kecurangan, suara ganda, serta menjaga asas Luber-Jurdil.',
            'content' => "Salah satu tantangan terbesar dalam sistem e-voting adalah menjamin bahwa setiap pemilih hanya dapat memberikan satu suara sah tanpa adanya intervensi atau manipulasi data.\n\nPlatform eVoters mengimplementasikan 3 pilar keamanan utama:\n\n1. Proteksi Anti-Duplikasi (One Vote, One Person)\nSetiap transaksi suara dikunci dengan tanda tangan digital unik. Token yang telah digunakan akan langsung dinonaktifkan secara otomatis dari ledger aktif.\n\n2. Prinsip Kerahasiaan (Secret Ballot)\nPilihan kandidat pemilih dienkripsi dengan protokol Zero-Knowledge, sehingga pilihan suara tetap rahasia tanpa dapat diintip oleh pihak mana pun, termasuk administrator sistem.\n\n3. Audit Trail Transparan\nSeluruh rekapitulasi suara dapat diverifikasi keabsahannya secara independen melalui kode resi dan nomor transaksi blok yang terverifikasi.\n\nDengan teknologi ini, proses demokrasi online dapat berjalan dengan tingkat kepercayaan dan kredibilitas maksimal.",
            'image' => 'images/news_voting_security.jpg',
            'status' => 'published',
            'views_count' => 128,
            'published_at' => now()->subHours(12),
        ]);

        Article::create([
            'title' => 'FAQ Seputar Kendala Kode OTP & Token Voting yang Sering Ditanyakan Pemilih',
            'slug' => 'faq-kendala-otp-dan-token-voting-pemilih',
            'category' => 'Bantuan & Tips',
            'author_name' => 'Helpdesk eVoters',
            'excerpt' => 'Panduan solusi cepat jika Anda belum menerima kode OTP email, token tidak terbaca, atau status pembayaran pending.',
            'content' => "Berikut adalah rangkuman solusi untuk beberapa pertanyaan umum seputar teknis pemungutan suara di eVoters:\n\nQ: Kode OTP Email tidak kunjung masuk ke Inbox?\nA: Pastikan penulisan alamat email sudah benar. Cek juga folder 'Spam', 'Junk', atau 'Promotions' pada aplikasi email Anda. Kode OTP berlaku selama 5 menit.\n\nQ: Token dinyatakan 'Sudah Digunakan'?\nA: Setiap kode token bersifat unik dan hanya berlaku untuk 1 kali penggunaan suara. Jika merasa belum menggunakannya, silakan hubungi panitia pelaksana event terkait untuk pengecekan data DPT.\n\nQ: Bagaimana memastikan suara saya sudah terhitung?\nA: Setelah selesai memilih, sistem akan menampilkan halaman 'Voting Berhasil' dan data perolehan suara di halaman hasil real-time akan langsung bertambah secara otomatis.",
            'image' => 'images/news_voting_guide.jpg',
            'status' => 'published',
            'views_count' => 95,
            'published_at' => now()->subHours(3),
        ]);
    }
}
