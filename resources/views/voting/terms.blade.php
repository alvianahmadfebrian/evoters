@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - eVoters')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .reveal { animation: fadeInUp 0.45s ease-out both; }
    .terms-section h2 {
        color: #0f172a;
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .terms-section p, .terms-section li {
        color: #475569;
        line-height: 1.75;
        font-size: 0.95rem;
    }
</style>
@endpush

@section('content')
<div class="space-y-12 relative overflow-hidden pb-16">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-32 left-1/4 w-[500px] h-[500px] bg-emerald-400/[0.04] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-[600px] right-1/4 w-[450px] h-[450px] bg-cyan-400/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <!-- Hero Header -->
    <section class="text-center max-w-3xl mx-auto space-y-4 pt-6 reveal">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold tracking-wide" style="background: #e6f4ea; border: 1px solid #a3cfbb; color: #146c43;">
            <i class="fa-solid fa-scale-balanced"></i>
            <span>Dokumen Hukum & Legal</span>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight leading-tight" style="color: #0f172a;">
            Syarat & <span style="color: #059669;">Ketentuan Penggunaan</span>
        </h1>
        <p class="text-base md:text-lg leading-relaxed max-w-2xl mx-auto" style="color: #475569;">
            Harap membaca syarat dan ketentuan berikut dengan teliti sebelum menggunakan layanan platform pemungutan suara online <strong>eVoters.id</strong>.
        </p>
        <p class="text-xs text-slate-500">
            Terakhir Diperbarui: {{ date('d F Y') }}
        </p>
    </section>

    <!-- Main Content Document -->
    <section class="max-w-4xl mx-auto reveal">
        <div class="glass-card rounded-3xl border border-slate-200/90 bg-white p-8 md:p-12 shadow-md space-y-8">
            
            <!-- Section 1 -->
            <div class="terms-section">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold flex-shrink-0">1</span>
                    Definisi & Ketentuan Umum
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        1.1. <strong>"Platform"</strong> merujuk pada situs web dan sistem perangkat lunak <strong>eVoters.id</strong> yang dikelola oleh <strong>{{ config('company.name') }}</strong>.
                    </p>
                    <p>
                        1.2. <strong>"Penyelenggara / Klien"</strong> adalah individu, panitia, organisasi, sekolah, atau institusi yang mengadakan kegiatan pemungutan suara melalui layanan eVoters.id.
                    </p>
                    <p>
                        1.3. <strong>"Pemilih / Voter"</strong> adalah setiap individu yang berpartisipasi dalam memberikan suaranya pada event yang diselenggarakan di platform ini.
                    </p>
                    <p>
                        1.4. Dengan mengakses atau menggunakan platform ini, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh isi Syarat & Ketentuan ini.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 2 -->
            <div class="terms-section">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold flex-shrink-0">2</span>
                    Mekanisme Pemungutan Suara (Voting)
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        2.1. <strong>Sifat Suara:</strong> Setiap suara yang telah berhasil dikirimkan dan diverifikasi oleh sistem bersifat <em>final, mutlak, dan tidak dapat ditarik kembali atau diubah</em> dengan alasan apa pun.
                    </p>
                    <p>
                        2.2. <strong>Integritas Suara:</strong> Kami menjamin sistem penghitungan suara berjalan otomatis dan transparan tanpa manipulasi pihak ketiga. Hasil penghitungan ditampilkan secara real-time atau sesuai preferensi pengaturan penyelenggara.
                    </p>
                    <p>
                        2.3. <strong>Event Bertoken:</strong> Untuk event yang menggunakan sistem token privat, satu kode token hanya berlaku untuk satu kali pemungutan suara dan langsung berstatus tidak aktif (hangus) setelah digunakan.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 3 -->
            <div class="terms-section">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold flex-shrink-0">3</span>
                    Pembayaran & Transaksi Digital
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        3.1. Untuk event berbayar (Paid Voting), proses transaksi diproses melalui mitra saluran gerbang pembayaran (Payment Gateway) resmi berizin Bank Indonesia (iPaymu / DOKU / QRIS / Bank Transfer).
                    </p>
                    <p>
                        3.2. Pemilih bertanggung jawab memastikan nomor nominal transfer, batas waktu pembayaran, serta kode unik yang tertera saat instruksi pembayaran sesuai dengan instruksi sistem.
                    </p>
                    <p>
                        3.3. eVoters.id tidak bertanggung jawab atas kegagalan transaksi yang disebabkan oleh gangguan jaringan pada pihak bank pengirim atau penyedia e-wallet pemilih di luar kendali teknis platform.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 4 -->
            <div class="terms-section">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold flex-shrink-0">4</span>
                    Larangan & Perlindungan Sistem
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        Pengguna dilarang keras untuk:
                    </p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Menggunakan skrip otomatis, robot, perayap web (crawlers), atau alat manipulasi otomatis untuk menyuntikkan suara palsu (bot voting).</li>
                        <li>Melakukan serangan denial-of-service (DDoS), eksploitasi celah keamanan, atau percobaan peretasan terhadap server eVoters.id.</li>
                        <li>Mengunggah materi yang melanggar hukum, SARA, pornografi, ujaran kebencian, atau melanggar hak cipta pihak ketiga pada profil kandidat atau deskripsi event.</li>
                    </ul>
                    <p class="pt-1">
                        Pelanggaran terhadap ketentuan ini dapat mengakibatkan pembatalan suara, penutupan event sepihak tanpa ganti rugi, serta pelaporan ke pihak berwajib sesuai peraturan perundang-undangan (UU ITE).
                    </p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section Privasi -->
            <div class="terms-section scroll-mt-24" id="privasi">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold flex-shrink-0">5</span>
                    Kebijakan Privasi & Perlindungan Data Pribadi
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        5.1. <strong>Pengumpulan Data:</strong> Kami hanya mengumpulkan informasi minimum yang diperlukan untuk keperluan verifikasi suara dan pemrosesan pembayaran, seperti nama lengkap, nomor WhatsApp/telepon, dan alamat email.
                    </p>
                    <p>
                        5.2. <strong>Kerahasiaan Pilihan Suara:</strong> Hak suara dan pilihan kandidat setiap pemilih dijaga kerahasiaannya dengan sistem enkripsi dan tidak akan pernah dipublikasikan atau dijual kepada pihak ketiga mana pun.
                    </p>
                    <p>
                        5.3. <strong>Keamanan Transaksi:</strong> Data pembayaran (seperti nomor rekening atau transaksi perbankan) diproses secara langsung oleh mitra gerbang pembayaran berizin resmi (Payment Gateway) melalui koneksi SSL terenkripsi tanpa disimpan di server publik kami.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 6 -->
            <div class="terms-section">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold flex-shrink-0">6</span>
                    Hukum yang Berlaku & Hubungi Kami
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        6.1. Syarat dan Ketentuan ini diatur dan ditafsirkan berdasarkan hukum Negara Kesatuan Republik Indonesia.
                    </p>
                    <p>
                        6.2. Apabila Anda memiliki pertanyaan atau memerlukan informasi lebih lanjut mengenai ketentuan ini, silakan hubungi kami di:
                    </p>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-sm space-y-1">
                        <p><strong>Entitas Pengelola:</strong> {{ config('company.name') }}</p>
                        <p><strong>Alamat Usaha:</strong> {{ config('company.address') }}</p>
                        <p><strong>Email Resmi:</strong> <a href="mailto:{{ config('company.email') }}" class="text-emerald-600 underline">{{ config('company.email') }}</a></p>
                        <p><strong>Telepon / WhatsApp:</strong> <a href="https://wa.me/{{ config('company.whatsapp') }}" class="text-emerald-600 underline">{{ config('company.phone') }}</a></p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
