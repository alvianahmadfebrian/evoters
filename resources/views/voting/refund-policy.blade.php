@extends('layouts.app')

@section('title', 'Kebijakan Pengembalian Dana (Refund Policy) - eVoters')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .reveal { animation: fadeInUp 0.45s ease-out both; }
    .refund-card h2 {
        color: #0f172a;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .refund-card p, .refund-card li {
        color: #475569;
        line-height: 1.75;
        font-size: 0.95rem;
    }
</style>
@endpush

@section('content')
<div class="space-y-12 relative overflow-hidden pb-16">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-32 left-1/4 w-[500px] h-[500px] bg-[#ba7c21]/[0.04] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-[500px] right-1/4 w-[450px] h-[450px] bg-[#9b5f1a]/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <!-- Hero Header -->
    <section class="text-center max-w-3xl mx-auto space-y-4 pt-6 reveal">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold tracking-wide" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
            <i class="fa-solid fa-receipt"></i>
            <span>Kebijakan Transaksi & Pembayaran</span>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight leading-tight" style="color: #0f172a;">
            Kebijakan <span style="color: #ba7c21;">Pengembalian Dana</span> (Refund)
        </h1>
        <p class="text-base md:text-lg leading-relaxed max-w-2xl mx-auto" style="color: #475569;">
            Panduan transparansi mengenai status transaksi, syarat, ketentuan, serta prosedur pengajuan klaim pengembalian dana (refund) pada layanan <strong>eVoters.id</strong>.
        </p>
        <p class="text-xs text-slate-500">
            Terakhir Diperbarui: {{ date('d F Y') }}
        </p>
    </section>

    <!-- Main Policy Content -->
    <section class="max-w-4xl mx-auto reveal">
        <div class="glass-card rounded-3xl border border-slate-200/90 bg-white p-8 md:p-12 shadow-md space-y-8">
            
            <!-- Prinsip Utama -->
            <div class="refund-card">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold flex-shrink-0">1</span>
                    Prinsip Dasar Produk Digital & Pemungutan Suara
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        Layanan pemungutan suara online di <strong>eVoters.id</strong> merupakan penyediaan produk digital yang sifatnya langsung dikonsumsi (real-time service). 
                    </p>
                    <p>
                        Oleh karena itu, secara umum <strong>dana yang telah berhasil dibayarkan dan telah terkonversi menjadi suara sah dalam sistem tidak dapat dibatalkan atau dikembalikan</strong>, demi menjaga netralitas, validitas, serta independensi hasil pemilihan.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Kondisi Memenuhi Syarat Refund -->
            <div class="refund-card">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold flex-shrink-0">2</span>
                    Kondisi yang Memenuhi Syarat Pengembalian Dana (Refund)
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        Pengembalian dana hanya dapat diproses dan disetujui apabila terjadi kondisi khusus berikut:
                    </p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>
                            <strong>Pembayaran Ganda (Double Payment):</strong> Pemilih tidak sengaja membayar dua kali untuk nomor referensi/tagihan pembayaran yang sama karena gangguan timeout perbankan.
                        </li>
                        <li>
                            <strong>Kelebihan Nominal Pembayaran:</strong> Pemilih mentransfer dana melebihi jumlah total tagihan resmi yang ditentukan oleh sistem pembayaran.
                        </li>
                        <li>
                            <strong>Sistem Error / Suara Tidak Masuk:</strong> Saldo pemilih telah berhasil terpotong pada rekening/e-wallet, namun status voting gagal tercatat dalam sistem server dan tidak dapat dipulihkan secara manual oleh tim teknis kami dalam waktu 1x24 jam.
                        </li>
                        <li>
                            <strong>Pembatalan Event Resmi:</strong> Penyelenggara event secara resmi membatalkan seluruh rangkaian kegiatan sebelum masa pemungutan suara berakhir.
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Kondisi Non-Refundable -->
            <div class="refund-card">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold flex-shrink-0">3</span>
                    Kondisi yang Tidak Dapat Dikembalikan (Non-Refundable)
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        Permintaan pengembalian dana <strong>TIDAK DAPAT DITERIMA</strong> pada kondisi:
                    </p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Pemilih berubah pikiran atau keliru memilih kandidat/opsi setelah menekan tombol konfirmasi pemilihan.</li>
                        <li>Event voting telah selesai dan ditutup secara sah sesuai waktu yang telah ditentukan.</li>
                        <li>Adanya indikasi kecurangan, manipulasi data, atau pelanggaran Syarat & Ketentuan platform oleh pemilih.</li>
                    </ul>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Tata Cara Pengajuan -->
            <div class="refund-card">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold flex-shrink-0">4</span>
                    Tata Cara & Prosedur Pengajuan Refund
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        Untuk mengajukan permohonan pengembalian dana, pemilih wajib mengirimkan laporan paling lambat <strong>3 x 24 jam</strong> sejak transaksi dilakukan dengan menyertakan:
                    </p>
                    <ol class="list-decimal list-inside space-y-1.5 pl-1">
                        <li>Nomor Referensi Transaksi / Kode Invoice pembayaran.</li>
                        <li>Bukti pembayaran yang sah (Screenshot mutasi bank, bukti struk ATM, atau resi transaksi e-wallet).</li>
                        <li>Nama lengkap dan nomor WhatsApp/Email yang digunakan saat melakukan transaksi.</li>
                        <li>Nomor rekening atau akun e-wallet tujuan pengembalian dana yang valid dan sesuai dengan nama pemilih.</li>
                    </ol>
                    <p class="pt-2">
                        Kirimkan berkas permohonan di atas ke email resmi: <a href="mailto:{{ config('company.email') }}" class="text-amber-600 font-semibold underline">{{ config('company.email') }}</a> atau melalui WhatsApp Customer Service di <a href="https://wa.me/{{ config('company.whatsapp') }}" class="text-amber-600 font-semibold underline">{{ config('company.phone') }}</a>.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Waktu Proses Pengembalian -->
            <div class="refund-card">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold flex-shrink-0">5</span>
                    Waktu Pemrosesan Pengembalian (SLA Refund)
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        Tim keuangan kami akan melakukan verifikasi data dalam <strong>1 - 2 hari kerja</strong>. Setelah disetujui, dana pengembalian akan ditransfer ke rekening bank / e-wallet pemilih dalam kurun waktu <strong>3 - 7 hari kerja</strong> (tergantung mekanisme kliring bank terkait).
                    </p>
                    <p class="text-xs text-slate-500 italic">
                        * Catatan: Biaya administrasi transfer antar-bank atau biaya switching yang dibebankan oleh penyedia kanal pembayaran pihak ketiga (jika ada) berada di luar tanggungan pengembalian utuh.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Kontak Layanan Bantuan -->
            <div class="refund-card">
                <h2>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold flex-shrink-0">6</span>
                    Kontak Layanan Pengembalian Dana
                </h2>
                <div class="space-y-3 pl-10">
                    <p>
                        Jika ada pertanyaan seputar status refund atau kendala pembayaran Anda, silakan hubungi tim kami:
                    </p>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-sm space-y-1">
                        <p><strong>Badan Usaha / Pengelola:</strong> {{ config('company.name') }}</p>
                        <p><strong>Alamat Operasional:</strong> {{ config('company.address') }}</p>
                        <p><strong>Email Layanan:</strong> <a href="mailto:{{ config('company.email') }}" class="text-amber-600 underline">{{ config('company.email') }}</a></p>
                        <p><strong>WhatsApp Support:</strong> <a href="https://wa.me/{{ config('company.whatsapp') }}" class="text-amber-600 underline">{{ config('company.phone') }}</a></p>
                        <p><strong>Jam Kerja:</strong> {{ config('company.hours') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
