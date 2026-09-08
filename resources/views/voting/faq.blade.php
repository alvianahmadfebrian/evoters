@extends('layouts.app')

@section('title', 'Pertanyaan Umum (FAQ) - eVoters')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .reveal { animation: fadeInUp 0.45s ease-out both; }
    .faq-item details summary::-webkit-details-marker { display: none; }
    .faq-item details[open] summary .faq-icon {
        transform: rotate(180deg);
        color: #ba7c21;
    }
    .faq-item details[open] {
        border-color: rgba(186, 124, 33, 0.4) !important;
        box-shadow: 0 4px 20px -2px rgba(186, 124, 33, 0.1);
    }
</style>
@endpush

@section('content')
<div class="space-y-12 relative overflow-hidden pb-16">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-32 left-1/4 w-[500px] h-[500px] bg-[#ba7c21]/[0.04] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-[450px] right-1/4 w-[450px] h-[450px] bg-[#9b5f1a]/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <!-- Hero Header -->
    <section class="text-center max-w-3xl mx-auto space-y-4 pt-6 reveal">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold tracking-wide" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
            <i class="fa-solid fa-circle-question"></i>
            <span>Pusat Bantuan & Pertanyaan Umum</span>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight leading-tight" style="color: #0f172a;">
            Frequently Asked <span style="color: #ba7c21;">Questions (FAQ)</span>
        </h1>
        <p class="text-base md:text-lg leading-relaxed max-w-2xl mx-auto" style="color: #475569;">
            Temukan jawaban lengkap dan cepat seputar penggunaan platform pemungutan suara online eVoters.id, alur voting, sistem token, serta proses pembayaran.
        </p>
    </section>

    <!-- FAQ Accordion Container -->
    <section class="max-w-4xl mx-auto space-y-4 reveal">
        <!-- Item 1 -->
        <div class="faq-item">
            <details class="group glass-card rounded-2xl border border-slate-200/80 bg-white p-6 transition-all duration-300">
                <summary class="flex justify-between items-center cursor-pointer list-none select-none font-bold text-lg text-slate-800">
                    <span class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-extrabold flex-shrink-0">
                            01
                        </span>
                        <span>Apa itu platform eVoters.id?</span>
                    </span>
                    <span class="faq-icon transition-transform duration-300 text-slate-400">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </summary>
                <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-base space-y-2">
                    <p>
                        <strong>eVoters.id</strong> adalah sistem pemungutan suara digital (online voting) modern yang didesain untuk menyelenggarakan pemilihan umum, pemilihan ketua organisasi/OSIS/BEM, festival favorit, hingga voting komunitas secara praktis, transparan, dan akuntabel.
                    </p>
                    <p>
                        Platform ini dilengkapi dengan penghitungan suara instan (real-time), enkripsi keamanan ketat, serta integrasi saluran pembayaran digital yang aman.
                    </p>
                </div>
            </details>
        </div>

        <!-- Item 2 -->
        <div class="faq-item">
            <details class="group glass-card rounded-2xl border border-slate-200/80 bg-white p-6 transition-all duration-300">
                <summary class="flex justify-between items-center cursor-pointer list-none select-none font-bold text-lg text-slate-800">
                    <span class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-extrabold flex-shrink-0">
                            02
                        </span>
                        <span>Apakah saya harus mendaftar akun untuk melakukan voting?</span>
                    </span>
                    <span class="faq-icon transition-transform duration-300 text-slate-400">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </summary>
                <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-base">
                    <p>
                        <strong>Tidak.</strong> Pemilih (voter) tidak diwajibkan mendaftar akun atau login untuk memberikan suara. Anda cukup membuka event voting yang sedang aktif, memilih kandidat favorit, melengkapi informasi identitas/kontak yang diminta panitia, dan menyelesaikan proses voting. Registrasi akun hanya diperuntukkan bagi admin/panitia penyelenggara event.
                    </p>
                </div>
            </details>
        </div>

        <!-- Item 3 -->
        <div class="faq-item">
            <details class="group glass-card rounded-2xl border border-slate-200/80 bg-white p-6 transition-all duration-300">
                <summary class="flex justify-between items-center cursor-pointer list-none select-none font-bold text-lg text-slate-800">
                    <span class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-extrabold flex-shrink-0">
                            03
                        </span>
                        <span>Bagaimana alur dan langkah-langkah memberikan suara?</span>
                    </span>
                    <span class="faq-icon transition-transform duration-300 text-slate-400">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </summary>
                <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-base space-y-2">
                    <ol class="list-decimal list-inside space-y-1.5 pl-1">
                        <li>Kunjungi halaman <strong>Beranda</strong> atau menu <strong>Event</strong>.</li>
                        <li>Pilih event aktif yang ingin Anda ikuti lalu klik <strong>Vote Sekarang</strong>.</li>
                        <li>Pilih kandidat atau opsi pilihan Anda.</li>
                        <li>Isi data nama dan alamat email/WhatsApp Anda.</li>
                        <li>Jika event menggunakan <em>Token</em>, masukkan kode token unik yang diberikan panitia.</li>
                        <li>Jika event berbayar (paid voting), masukkan jumlah suara yang ingin diberikan dan lanjutkan ke pembayaran.</li>
                        <li>Setelah sukses, suara Anda akan langsung tercatat dan diakumulasikan ke grafik hasil perolehan.</li>
                    </ol>
                </div>
            </details>
        </div>

        <!-- Item 4 -->
        <div class="faq-item">
            <details class="group glass-card rounded-2xl border border-slate-200/80 bg-white p-6 transition-all duration-300">
                <summary class="flex justify-between items-center cursor-pointer list-none select-none font-bold text-lg text-slate-800">
                    <span class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-extrabold flex-shrink-0">
                            04
                        </span>
                        <span>Apa saja metode pembayaran yang diterima pada event berbayar?</span>
                    </span>
                    <span class="faq-icon transition-transform duration-300 text-slate-400">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </summary>
                <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-base space-y-2">
                    <p>
                        Kami mendukung berbagai kanal pembayaran resmi terpercaya di Indonesia melalui payment gateway resmi:
                    </p>
                    <ul class="list-disc list-inside space-y-1 pl-1">
                        <li><strong>QRIS</strong> (GoPay, OVO, Dana, LinkAja, ShopeePay, BCA, Livin Mandiri, BRImo, CIMB, dan semua aplikasi mobile banking berstandar QRIS).</li>
                        <li><strong>Virtual Account Bank</strong> (BCA, Mandiri, BRI, BNI, Permata, dll).</li>
                        <li><strong>E-Wallet</strong> & Saluran pembayaran online terverifikasi lainnya.</li>
                    </ul>
                </div>
            </details>
        </div>

        <!-- Item 5 -->
        <div class="faq-item">
            <details class="group glass-card rounded-2xl border border-slate-200/80 bg-white p-6 transition-all duration-300">
                <summary class="flex justify-between items-center cursor-pointer list-none select-none font-bold text-lg text-slate-800">
                    <span class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-extrabold flex-shrink-0">
                            05
                        </span>
                        <span>Bagaimana jika pembayaran sudah berhasil namun suara belum terhitung?</span>
                    </span>
                    <span class="faq-icon transition-transform duration-300 text-slate-400">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </summary>
                <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-base space-y-2">
                    <p>
                        Sistem kami memproses konfirmasi notifikasi secara otomatis (real-time webhook). Namun, pada kasus tertentu akibat keterlambatan jaringan perbankan, silakan:
                    </p>
                    <ul class="list-disc list-inside space-y-1 pl-1">
                        <li>Muat ulang (refresh) halaman instruksi pembayaran atau periksa grafik hasil event.</li>
                        <li>Jika dalam 5-10 menit status belum terupdate, simpan bukti transfer/screenshot Anda dan hubungi tim <strong>Customer Support</strong> kami melalui halaman Kontak atau WhatsApp dengan menyertakan Nomor Invoice/Referensi Transaksi.</li>
                    </ul>
                </div>
            </details>
        </div>

        <!-- Item 6 -->
        <div class="faq-item">
            <details class="group glass-card rounded-2xl border border-slate-200/80 bg-white p-6 transition-all duration-300">
                <summary class="flex justify-between items-center cursor-pointer list-none select-none font-bold text-lg text-slate-800">
                    <span class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-extrabold flex-shrink-0">
                            06
                        </span>
                        <span>Apakah suara yang sudah dikirimkan dapat diubah atau dibatalkan?</span>
                    </span>
                    <span class="faq-icon transition-transform duration-300 text-slate-400">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </summary>
                <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-base">
                    <p>
                        <strong>Tidak.</strong> Demi menjaga integritas, netralitas, dan keabsahan hasil pemungutan suara, setiap suara yang telah diverifikasi dan masuk ke database bersifat final, permanen, dan tidak dapat ditarik kembali atau diubah.
                    </p>
                </div>
            </details>
        </div>

        <!-- Item 7 -->
        <div class="faq-item">
            <details class="group glass-card rounded-2xl border border-slate-200/80 bg-white p-6 transition-all duration-300">
                <summary class="flex justify-between items-center cursor-pointer list-none select-none font-bold text-lg text-slate-800">
                    <span class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-extrabold flex-shrink-0">
                            07
                        </span>
                        <span>Bagaimana eVoters.id menjamin keamanan dan keabsahan data pemilih?</span>
                    </span>
                    <span class="faq-icon transition-transform duration-300 text-slate-400">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </summary>
                <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-base space-y-2">
                    <p>
                        Kami menerapkan standar keamanan web modern:
                    </p>
                    <ul class="list-disc list-inside space-y-1 pl-1">
                        <li>Enkripsi transmisi data menggunakan protokol HTTPS/SSL 256-bit.</li>
                        <li>Token voting sekali pakai (single-use token) yang langsung hangus setelah dipakai.</li>
                        <li>Pencegahan voting ganda (double-voting protection) serta audit trail transaksi yang komprehensif.</li>
                    </ul>
                </div>
            </details>
        </div>
    </section>

    <!-- Support CTA Card -->
    <section class="max-w-4xl mx-auto reveal">
        <div class="glass-card rounded-3xl border border-slate-200/80 bg-gradient-to-r from-amber-50/40 via-white to-amber-50/40 p-8 md:p-10 text-center space-y-4 shadow-sm">
            <div class="w-12 h-12 rounded-2xl text-white flex items-center justify-center mx-auto text-xl shadow-md shadow-[#ba7c21]/20" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                <i class="fa-solid fa-headset"></i>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900">Belum Menemukan Jawaban yang Anda Cari?</h3>
            <p class="text-slate-600 text-sm md:text-base max-w-xl mx-auto">
                Tim layanan bantuan kami selalu siap menjawab kendala teknis, pertanyaan kemitraan, atau panduan transaksi Anda.
            </p>
            <div class="pt-2 flex flex-wrap justify-center gap-3">
                <a href="{{ route('contact') }}" class="text-white font-semibold text-sm py-3 px-6 rounded-xl transition-all shadow-md" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                    <i class="fa-solid fa-envelope mr-1.5"></i> Hubungi Kami
                </a>
                <a href="https://wa.me/{{ config('company.whatsapp') }}" target="_blank" rel="noopener noreferrer" class="bg-white hover:bg-slate-50 border border-slate-300 text-slate-800 font-semibold text-sm py-3 px-6 rounded-xl transition-all">
                    <i class="fa-brands fa-whatsapp text-emerald-600 mr-1.5"></i> WhatsApp Support
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
