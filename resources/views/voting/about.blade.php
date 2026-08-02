@extends('layouts.app')

@section('title', 'About - eVoters')

@section('content')
<div class="space-y-16 relative overflow-hidden pb-16">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-40 left-1/4 w-[600px] h-[600px] bg-emerald-400/[0.04] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-[400px] right-1/4 w-[500px] h-[500px] bg-cyan-400/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <!-- ==================== HERO SECTION ==================== -->
    <section class="text-center max-w-3xl mx-auto space-y-4 pt-8">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold tracking-wide" style="background: #e6f4ea; border: 1px solid #a3cfbb; color: #146c43;">
            <i class="fa-solid fa-leaf"></i>
            <span>About Us</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight" style="color: #0f172a;">
            Platform Voting Online <br class="hidden sm:inline">
            <span style="color: #059669;">Lebih Praktis & Transparan</span>
        </h1>
        <p class="text-base md:text-lg leading-relaxed max-w-xl mx-auto" style="color: #64748b;">
            E-Voters.id hadir untuk mendigitalisasi proses pemungutan suara dengan jaminan keamanan tingkat tinggi dan keterbukaan hasil secara langsung.
        </p>
    </section>

    <!-- ==================== TENTANG & PILAR UTAMA ==================== -->
    <section class="max-w-5xl mx-auto space-y-10">
        <!-- Intro Card -->
        <div class="glass-card rounded-3xl p-8 md:p-10 border border-slate-100 shadow-md">
            <div class="flex flex-col lg:flex-row gap-10 items-center">
                <!-- Left Content -->
                <div class="w-full lg:w-3/5 space-y-5">
                    <div class="space-y-2">
                        <h2 class="text-2xl font-extrabold" style="color: #0f172a;">
                            Apa Itu <span style="color: #059669;">E-Voters.id</span>?
                        </h2>
                        <div class="w-16 h-1 bg-emerald-500 rounded-full"></div>
                    </div>
                    <p class="text-sm leading-relaxed" style="color: #475569;">
                        <strong>E-Voters.id</strong> adalah platform pemungutan suara online yang dirancang untuk memudahkan berbagai organisasi, komunitas, sekolah, dan perusahaan dalam menyelenggarakan voting secara digital.
                    </p>
                    <p class="text-sm leading-relaxed" style="color: #475569;">
                        Dengan E-Voters.id, Anda dapat membuat event voting, mengelola kandidat, mengirim token voting yang aman, hingga menerima pembayaran — semua dalam satu platform terintegrasi. Kami menjamin keamanan data, mencegah kecurangan, dan menampilkan hasil secara real-time.
                    </p>
                    <div class="flex flex-wrap gap-2 pt-2">
                        @foreach(['Voting Online', 'Hasil Real-time', 'Token Aman', 'Pembayaran Terintegrasi', 'Multi Event', 'Anti Kecurangan'] as $f)
                            <span class="text-[11px] font-semibold px-3 py-1.5 rounded-xl transition-all hover:scale-105" style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;">{{ $f }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Right Feature Box -->
                <div class="w-full lg:w-2/5 rounded-2xl p-8 text-center space-y-5 flex flex-col justify-center items-center" style="background: linear-gradient(135deg, #f0fdf4, #ecfdf5); border: 1px solid #d1fae5;">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-md bg-gradient-to-tr from-emerald-650 to-teal-500" style="background: #059669;">
                        <i class="fa-solid fa-check-to-slot text-2xl" style="color: #ffffff !important;"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-lg font-bold" style="color: #0f172a;">Voting Digital Aman</h3>
                        <p class="text-xs text-slate-500 max-w-xs leading-relaxed">
                            Mendukung demokrasi yang jujur, adil, transparan, dan dapat diakses dengan mudah oleh siapa saja.
                        </p>
                    </div>
                    <div class="flex justify-center gap-2 pt-1 w-full">
                        <span class="inline-flex items-center space-x-1 text-[11px] font-semibold px-3 py-1.5 rounded-full" style="background: #ffffff; border: 1px solid #e2e8f0; color: #334155;">
                            <i class="fa-solid fa-shield-halved text-[10px]" style="color: #059669 !important;"></i>
                            <span>Terenkripsi</span>
                        </span>
                        <span class="inline-flex items-center space-x-1 text-[11px] font-semibold px-3 py-1.5 rounded-full" style="background: #ffffff; border: 1px solid #e2e8f0; color: #334155;">
                            <i class="fa-solid fa-chart-simple text-[10px]" style="color: #059669 !important;"></i>
                            <span>Real-time</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Pillars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Pillar 1: Keamanan -->
            <div class="glass-card rounded-2xl p-6 space-y-4 border border-slate-100 hover:border-emerald-500/20 hover:-translate-y-1 transition-all duration-350 shadow-sm">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm" style="background: #ecfdf5; border: 1px solid #bbf7d0;">
                    <i class="fa-solid fa-shield-halved text-lg" style="color: #059669 !important;"></i>
                </div>
                <div class="space-y-1.5">
                    <h3 class="font-bold text-base" style="color: #0f172a;">Keamanan Terjamin</h3>
                    <p class="text-xs leading-relaxed" style="color: #64748b;">
                        Setiap suara dienkripsi secara aman menggunakan kode unik OTP/Token guna mencegah terjadinya manipulasi data.
                    </p>
                </div>
            </div>

            <!-- Pillar 2: Transparansi -->
            <div class="glass-card rounded-2xl p-6 space-y-4 border border-slate-100 hover:border-emerald-500/20 hover:-translate-y-1 transition-all duration-350 shadow-sm">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm" style="background: #ecfdf5; border: 1px solid #bbf7d0;">
                    <i class="fa-solid fa-chart-line text-lg" style="color: #059669 !important;"></i>
                </div>
                <div class="space-y-1.5">
                    <h3 class="font-bold text-base" style="color: #0f172a;">Hasil Real-Time</h3>
                    <p class="text-xs leading-relaxed" style="color: #64748b;">
                        Perolehan grafik suara dapat dipantau langsung detik demi detik secara terbuka dan transparan setelah suara masuk.
                    </p>
                </div>
            </div>

            <!-- Pillar 3: Kemudahan -->
            <div class="glass-card rounded-2xl p-6 space-y-4 border border-slate-100 hover:border-emerald-500/20 hover:-translate-y-1 transition-all duration-350 shadow-sm">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm" style="background: #ecfdf5; border: 1px solid #bbf7d0;">
                    <i class="fa-solid fa-bolt text-lg" style="color: #059669 !important;"></i>
                </div>
                <div class="space-y-1.5">
                    <h3 class="font-bold text-base" style="color: #0f172a;">Akses Cepat</h3>
                    <p class="text-xs leading-relaxed" style="color: #64748b;">
                        Dapat diakses kapan saja dan di mana saja melalui perangkat smartphone, tablet, maupun komputer tanpa kendala instalasi.
                    </p>
                </div>
            </div>

            <!-- Pillar 4: Integrasi -->
            <div class="glass-card rounded-2xl p-6 space-y-4 border border-slate-100 hover:border-emerald-500/20 hover:-translate-y-1 transition-all duration-350 shadow-sm">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm" style="background: #ecfdf5; border: 1px solid #bbf7d0;">
                    <i class="fa-solid fa-wallet text-lg" style="color: #059669 !important;"></i>
                </div>
                <div class="space-y-1.5">
                    <h3 class="font-bold text-base" style="color: #0f172a;">Payment Terintegrasi</h3>
                    <p class="text-xs leading-relaxed" style="color: #64748b;">
                        Dukungan pembayaran digital instan melalui DOKU PG untuk mendukung event berbayar atau donasi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== VISI & MISI ==================== -->
    <section class="max-w-5xl mx-auto space-y-8">
        <div class="text-center">
            <h2 class="text-2xl font-bold" style="color: #0f172a;">Visi & Misi Kami</h2>
            <p class="text-sm mt-1" style="color: #64748b;">Landasan dasar kami dalam menghadirkan sistem demokrasi digital terpercaya.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            <!-- Visi Card -->
            <div class="glass-card rounded-3xl p-8 space-y-6 flex flex-col justify-between border border-slate-100 shadow-md">
                <div class="space-y-4">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold" style="background: #e8f9ff; border: 1px solid #bee5eb; color: #087990;">
                        <i class="fa-solid fa-compass"></i>
                        <span>Visi</span>
                    </div>
                    <h3 class="text-2xl font-bold" style="color: #0f172a;">Menjadi Pionir E-Voting Terpercaya</h3>
                    <p class="text-sm leading-relaxed" style="color: #475569;">
                        Menjadikan E-Voters.id sebagai platform rujukan utama dalam pelaksanaan pemungutan suara digital skala nasional yang berintegritas, menjamin kerahasiaan pemilih, serta menghapus kecurangan secara sistemik.
                    </p>
                </div>
            </div>

            <!-- Misi Card -->
            <div class="glass-card rounded-3xl p-8 space-y-6 border border-slate-100 shadow-md">
                <div class="space-y-4">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold" style="background: #e6f4ea; border: 1px solid #a3cfbb; color: #146c43;">
                        <i class="fa-solid fa-bullseye"></i>
                        <span>Misi</span>
                    </div>
                    <h3 class="text-2xl font-bold" style="color: #0f172a;">Fokus Target Kerja</h3>
                </div>
                <ul class="space-y-3.5 text-sm" style="color: #475569;">
                    <li class="flex items-start space-x-3">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: #e6f4ea; color: #059669;">
                            <i class="fa-solid fa-check text-xs"></i>
                        </span>
                        <span>Membangun UI/UX antarmuka yang ramah pengguna dari berbagai kalangan usia.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: #e6f4ea; color: #059669;">
                            <i class="fa-solid fa-check text-xs"></i>
                        </span>
                        <span>Menerapkan enkripsi data ketat untuk menjamin kerahasiaan suara voter.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: #e6f4ea; color: #059669;">
                            <i class="fa-solid fa-check text-xs"></i>
                        </span>
                        <span>Mendorong efisiensi logistik penyelenggara dengan meminimalisir kertas suara fisik.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ==================== OWNER PROFILE (REBUILT WITH FLEX) ==================== -->
    <section class="max-w-5xl mx-auto space-y-8">
        <div class="text-center">
            <h2 class="text-2xl font-bold" style="color: #0f172a;">Profil Pemilik</h2>
            <p class="text-sm mt-1" style="color: #64748b;">Sosok penting di balik berdirinya platform E-Voters.id.</p>
        </div>

        <div class="glass-card rounded-3xl overflow-hidden p-8 border border-slate-100 shadow-md">
            <div class="flex flex-col md:flex-row gap-10 items-center md:items-start">
                <!-- Profile Image -->
                <div class="flex-shrink-0">
                    <div class="relative w-64 h-64 md:w-72 md:h-72 rounded-2xl overflow-hidden shadow-lg border-4 border-white bg-slate-100">
                        <img src="{{ asset('images/owner_profile.jpg') }}" alt="Aries Mulyono" class="w-full h-full object-cover">
                        <div class="absolute bottom-4 left-4 right-4 backdrop-blur-md rounded-xl p-3 text-center border border-white/20" style="background: rgba(15, 23, 42, 0.75);">
                            <span class="text-white text-xs font-semibold tracking-wider block">OWNER E-VOTERS</span>
                        </div>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-grow space-y-6 text-center md:text-left pt-2">
                    <div class="space-y-2">
                        <h3 class="text-3xl font-extrabold" style="color: #0f172a;">Aries Mulyono</h3>
                        <p class="text-sm font-semibold uppercase tracking-wider" style="color: #059669;">Owner E-Voters.id</p>
                    </div>

                    <div class="space-y-4 text-sm leading-relaxed" style="color: #475569;">
                        <p>
                            Aries Mulyono merupakan pemilik sekaligus pendiri E-Voters.id. Beliau menginisiasi pengembangan platform ini dengan tujuan menghadirkan sistem pemungutan suara digital yang aman, praktis, dan dapat diandalkan oleh berbagai instansi, sekolah, maupun organisasi di Indonesia.
                        </p>
                        <p>
                            Dengan komitmen tinggi terhadap integritas data dan transparansi hasil, Aries terus mendukung transformasi digital dalam proses demokrasi dan pengambilan keputusan bersama secara modern, efisien, serta ramah lingkungan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== BOTTOM CTA ==================== -->
    <section class="max-w-4xl mx-auto text-center rounded-3xl p-10 md:p-12 space-y-6 relative overflow-hidden" style="background: linear-gradient(135deg, #059669, #0d9488); box-shadow: 0 10px 30px -10px rgba(5, 150, 105, 0.3); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <h2 class="text-3xl font-extrabold text-white" style="color: #ffffff !important;">Mulai Pemilihan Anda Sekarang</h2>
        <p class="text-sm md:text-base leading-relaxed max-w-xl mx-auto" style="color: rgba(255, 255, 255, 0.85) !important;">
            Buat keputusan bersama dengan lebih cepat, adil, transparan, dan terpercaya bersama E-Voters.id.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
            <a href="{{ route('events.list') }}" class="inline-flex items-center text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:scale-[1.02] shadow-md" style="background: #ffffff; color: #059669 !important;">
                <i class="fa-solid fa-calendar-days mr-2" style="color: #059669 !important;"></i> Temukan Event Aktif
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-bold px-6 py-3.5 rounded-xl transition-all hover:scale-[1.02]" style="background: rgba(255, 255, 255, 0.15); color: #ffffff !important; border: 1px solid rgba(255, 255, 255, 0.3);">
                <i class="fa-solid fa-house mr-2" style="color: #ffffff !important;"></i> Kembali ke Beranda
            </a>
        </div>
    </section>
</div>
@endsection
