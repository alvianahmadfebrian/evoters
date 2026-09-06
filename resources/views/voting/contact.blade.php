@extends('layouts.app')

@section('title', 'Kontak Kami - eVoters')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .reveal { animation: fadeInUp 0.45s ease-out both; }
    .contact-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .contact-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.08);
    }
</style>
@endpush

@section('content')
<div class="space-y-12 relative overflow-hidden pb-16">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-32 left-1/4 w-[500px] h-[500px] bg-emerald-400/[0.04] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-[450px] right-1/4 w-[450px] h-[450px] bg-cyan-400/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <!-- Hero Header -->
    <section class="text-center max-w-3xl mx-auto space-y-4 pt-6 reveal">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold tracking-wide" style="background: #e6f4ea; border: 1px solid #a3cfbb; color: #146c43;">
            <i class="fa-solid fa-address-book"></i>
            <span>Hubungi Kami</span>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight leading-tight" style="color: #0f172a;">
            Kontak & Informasi <span style="color: #059669;">Resmi Usaha</span>
        </h1>
        <p class="text-base md:text-lg leading-relaxed max-w-2xl mx-auto" style="color: #475569;">
            Kami siap membantu Anda. Jangan ragu untuk menghubungi kami jika memiliki pertanyaan seputar pelaksanaan event, kendala teknis, panduan transaksi, atau kerja sama.
        </p>
    </section>

    <!-- 4 Main Contact Cards -->
    <section class="max-w-5xl mx-auto reveal">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: Alamat Usaha -->
            <div class="contact-card glass-card rounded-3xl border border-slate-200/90 bg-white p-6 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Usaha</span>
                        <h3 class="text-base font-bold text-slate-800 mt-1">Kantor Operasional</h3>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        {{ config('company.address') }}
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 text-[11px] text-emerald-700 font-semibold flex items-center gap-1.5">
                    <i class="fa-solid fa-building-shield"></i>
                    <span>Terdaftar & Terverifikasi</span>
                </div>
            </div>

            <!-- Card 2: Telepon & WhatsApp -->
            <div class="contact-card glass-card rounded-3xl border border-slate-200/90 bg-white p-6 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Nomor Telepon</span>
                        <h3 class="text-base font-bold text-slate-800 mt-1">Customer Service</h3>
                    </div>
                    <p class="text-sm font-semibold text-slate-700">
                        {{ config('company.phone') }}
                    </p>
                    <p class="text-xs text-slate-500">
                        Melayani panggilan telepon & pesan WhatsApp cepat.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <a href="https://wa.me/{{ config('company.whatsapp') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>Kirim Pesan WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Card 3: Email Resmi -->
            <div class="contact-card glass-card rounded-3xl border border-slate-200/90 bg-white p-6 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Email</span>
                        <h3 class="text-base font-bold text-slate-800 mt-1">Surat Elektronik</h3>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 break-all">
                        {{ config('company.email') }}
                    </p>
                    <p class="text-xs text-slate-500">
                        Untuk penawaran kemitraan, bantuan akun, dan klaim refund.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <a href="mailto:{{ config('company.email') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Kirim Email Langsung</span>
                    </a>
                </div>
            </div>

            <!-- Card 4: Jam Operasional -->
            <div class="contact-card glass-card rounded-3xl border border-slate-200/90 bg-white p-6 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Jam Operasional</span>
                        <h3 class="text-base font-bold text-slate-800 mt-1">Waktu Pelayanan</h3>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">
                        {{ config('company.hours') }}
                    </p>
                    <p class="text-xs text-slate-500">
                        Server voting otomatis beroperasi 24 jam sehari, 7 hari seminggu.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-500 font-medium flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Sistem Aktif 24/7</span>
                </div>
            </div>

        </div>
    </section>

    <!-- Company Detail & Quick Assistance Grid -->
    <section class="max-w-5xl mx-auto reveal">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Left Column: Company Profile & Verification Compliance Box -->
            <div class="glass-card rounded-3xl border border-slate-200/90 bg-white p-8 md:p-10 space-y-6 shadow-md">
                <div class="space-y-2">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold" style="background: #e8f9ff; border: 1px solid #bee5eb; color: #087990;">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Legalitas Usaha</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Identitas Resmi Pengelola</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Platform <strong>eVoters.id</strong> dikelola langsung di bawah naungan manajemen usaha resmi:
                    </p>
                </div>

                <div class="space-y-4 text-sm text-slate-700">
                    <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <i class="fa-solid fa-briefcase text-emerald-600 mt-0.5"></i>
                        <div>
                            <span class="text-xs text-slate-500 block">Nama Entitas Bisnis</span>
                            <span class="font-bold text-slate-800">{{ config('company.name') }}</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <i class="fa-solid fa-user-check text-emerald-600 mt-0.5"></i>
                        <div>
                            <span class="text-xs text-slate-500 block">Pendiri & Penanggung Jawab</span>
                            <span class="font-bold text-slate-800">{{ config('company.owner') }}</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <i class="fa-solid fa-map-location-dot text-emerald-600 mt-0.5"></i>
                        <div>
                            <span class="text-xs text-slate-500 block">Alamat Usaha Resmi</span>
                            <span class="font-semibold text-slate-800 leading-relaxed">{{ config('company.address') }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 text-xs text-emerald-900 leading-relaxed flex items-start gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm mt-0.5"></i>
                    <div>
                        <strong>Komitmen Transparansi:</strong> Data kontak dan alamat usaha ini sepenuhnya sinkron dan terdaftar pada gerbang pembayaran iPaymu untuk menjamin kenyamanan dan keamanan transaksi para pemilih.
                    </div>
                </div>
            </div>

            <!-- Right Column: Direct Message / WhatsApp Quick Connect -->
            <div class="glass-card rounded-3xl border border-slate-200/90 bg-white p-8 md:p-10 space-y-6 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold" style="background: #e6f4ea; border: 1px solid #a3cfbb; color: #146c43;">
                        <i class="fa-solid fa-headset"></i>
                        <span>Respon Cepat</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Konsultasi & Layanan Cepat</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Butuh respon instan mengenai event voting Anda atau kendala transaksi? Hubungi customer support kami secara langsung melalui WhatsApp atau asisten virtual kami.
                    </p>
                </div>

                <div class="space-y-4">
                    <!-- WhatsApp Action Box -->
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white space-y-3 shadow-lg shadow-emerald-500/20">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-xl">
                                <i class="fa-brands fa-whatsapp"></i>
                            </span>
                            <div>
                                <h4 class="font-bold text-base">WhatsApp Resmi CS</h4>
                                <p class="text-xs text-emerald-100">Aktif pada jam kerja operasional</p>
                            </div>
                        </div>
                        <p class="text-xs text-emerald-50 leading-relaxed">
                            Hubungi langsung nomor: <strong>{{ config('company.phone') }}</strong> untuk penanganan darurat tiket voting atau pembayaran.
                        </p>
                        <a href="https://wa.me/{{ config('company.whatsapp') }}?text=Halo%20Admin%20eVoters,%20saya%20membutuhkan%20informasi%20terkait%20platform%20voting" target="_blank" rel="noopener noreferrer" class="block w-full text-center bg-white text-emerald-700 font-bold text-xs py-3 px-4 rounded-xl shadow hover:bg-slate-50 transition-colors">
                            Buka WhatsApp Sekarang <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i>
                        </a>
                    </div>

                    <!-- Email Contact Box -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-700">Kirim Email Resmi</p>
                            <p class="text-xs text-slate-500">{{ config('company.email') }}</p>
                        </div>
                        <a href="mailto:{{ config('company.email') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs py-2 px-4 rounded-xl transition-all">
                            Tulis Pesan
                        </a>
                    </div>
                </div>

                <p class="text-[11px] text-slate-400 text-center">
                    Kami biasanya membalas pesan WhatsApp dalam waktu kurang dari 30 menit pada jam kerja.
                </p>
            </div>

        </div>
    </section>
</div>
@endsection
