@extends('layouts.app')

@section('title', 'About - eVoters')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .reveal { animation: fadeInUp 0.5s ease-out both; }
    .reveal-1 { animation-delay: 0.05s; }
    .reveal-2 { animation-delay: 0.12s; }
    .reveal-3 { animation-delay: 0.19s; }
    .reveal-4 { animation-delay: 0.26s; }
    @media (prefers-reduced-motion: reduce) { .reveal { animation: none; } }

    .feature-row { transition: background-color 0.25s ease; }
    .feature-row:hover { background: #f8fdfb; }
    .feature-row:hover .feature-icon { transform: scale(1.06); }
    .feature-icon { transition: transform 0.25s ease; }

    .stat-box { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .stat-box:hover { transform: translateY(-3px); }
</style>
@endpush

@section('content')
<div class="space-y-16 relative overflow-hidden pb-16">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-40 left-1/4 w-[600px] h-[600px] bg-emerald-400/[0.04] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-[500px] right-1/4 w-[500px] h-[500px] bg-cyan-400/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <!-- ==================== HERO ==================== -->
    <section class="text-center max-w-3xl mx-auto space-y-5 pt-8 reveal">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold tracking-wide" style="background: #e6f4ea; border: 1px solid #a3cfbb; color: #146c43;">
            <i class="fa-solid fa-leaf"></i>
            <span>About Us</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight" style="color: #0f172a;">
            Platform Voting Online <br class="hidden sm:inline">
            <span style="color: #059669;">Lebih Praktis & Transparan</span>
        </h1>
    </section>

    <!-- Card 1: Apa Itu E-Voters.id? -->
    <section class="max-w-5xl mx-auto reveal reveal-1 mb-6">
        <div class="glass-card rounded-3xl border border-slate-100 shadow-md p-8 md:p-12 bg-gradient-to-br from-white via-white to-emerald-50/[0.05]">
            <div class="max-w-4xl space-y-5">
                <div class="space-y-1.5">
                    <span class="text-xs md:text-sm font-bold uppercase tracking-wider text-emerald-600">Kenali Platform Kami</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight" style="color: #0f172a;">
                        Apa Itu <span style="color: #059669;">E-Voters.id</span>?
                    </h2>
                    <div class="w-16 h-0.5 bg-emerald-500 rounded-full mt-2"></div>
                </div>
                <div class="space-y-4 text-base md:text-lg leading-relaxed text-justify" style="color: #475569;">
                    <p>
                        <strong>E-Voters.id</strong> adalah platform pemungutan suara online modern yang dirancang untuk mendigitalisasi proses demokrasi secara praktis, aman, dan transparan.
                    </p>
                    <p>
                        Kami memudahkan berbagai organisasi, komunitas, sekolah, dan perusahaan untuk menyelenggarakan voting dengan pengiriman token voting unik, pemantauan hasil secara real-time, hingga sistem pembayaran terintegrasi — dikemas dalam antarmuka yang ramah pengguna.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Card 2: Visi & Misi (Side-by-Side Cards) -->
    <section class="max-w-5xl mx-auto reveal reveal-1 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Visi -->
            <div class="glass-card rounded-3xl border border-slate-100 shadow-md p-8 md:p-10 bg-gradient-to-br from-white via-white to-emerald-50/[0.05] space-y-4">
                <div>
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold" style="background: #e8f9ff; border: 1px solid #bee5eb; color: #087990;">
                        <i class="fa-solid fa-compass"></i>
                        <span>Visi</span>
                    </div>
                </div>
                <h3 class="text-xl md:text-2xl font-bold" style="color: #0f172a;">Menjadi Pionir E-Voting Terpercaya</h3>
                <p class="text-sm md:text-base leading-relaxed text-justify" style="color: #475569;">
                    Menjadikan E-Voters.id sebagai platform rujukan utama dalam pelaksanaan pemungutan suara digital skala nasional yang berintegritas, menjamin kerahasiaan pemilih, serta menghapus kecurangan secara sistemik.
                </p>
            </div>

            <!-- Misi -->
            <div class="glass-card rounded-3xl border border-slate-100 shadow-md p-8 md:p-10 bg-gradient-to-br from-white via-white to-emerald-50/[0.05] space-y-4">
                <div>
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold" style="background: #e6f4ea; border: 1px solid #a3cfbb; color: #146c43;">
                        <i class="fa-solid fa-bullseye"></i>
                        <span>Misi</span>
                    </div>
                </div>
                <h3 class="text-xl md:text-2xl font-bold" style="color: #0f172a;">Fokus Target Kerja</h3>
                <ul class="space-y-3 text-sm md:text-base pt-1 text-justify" style="color: #475569;">
                    <li class="flex items-start space-x-3">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: #e6f4ea; color: #059669;">
                            <i class="fa-solid fa-check text-xs"></i>
                        </span>
                        <span>Mengembangkan platform E-Voters.id dengan antarmuka (UI/UX) yang ramah pengguna bagi berbagai kalangan usia.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: #e6f4ea; color: #059669;">
                            <i class="fa-solid fa-check text-xs"></i>
                        </span>
                        <span>Menerapkan enkripsi data dan sistem keamanan ketat pada E-Voters.id untuk menjamin kerahasiaan suara voter.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: #e6f4ea; color: #059669;">
                            <i class="fa-solid fa-check text-xs"></i>
                        </span>
                        <span>Mendorong efisiensi logistik melalui E-Voters.id guna meminimalisir kertas suara fisik secara ramah lingkungan.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ==================== OWNER PROFILE ==================== -->
    <section class="max-w-5xl mx-auto reveal reveal-1">
        <div class="glass-card rounded-3xl border border-slate-100 shadow-md overflow-hidden bg-gradient-to-br from-white via-white to-emerald-50/[0.05]">
            <div class="flex flex-col md:flex-row md:items-center gap-10 p-8 md:p-12">
                <!-- Left: Photo -->
                <div class="w-full md:w-2/5 flex justify-center">
                    <div class="relative w-60 h-80 md:w-72 md:h-96 rounded-3xl overflow-hidden shadow-lg border-4 border-white bg-slate-100 flex-shrink-0">
                        <img src="{{ asset('images/owner_profile.jpg') }}" alt="Aries Mulyono" class="w-full h-full object-cover rounded-[20px]">
                    </div>
                </div>
                
                <!-- Right: Owner Info -->
                <div class="w-full md:w-3/5 space-y-5">
                    <div class="space-y-1.5">
                        <span class="inline-flex items-center space-x-1.5 text-[11px] font-semibold px-3 py-1 rounded-full mb-1" style="background: #e6f4ea; border: 1px solid #a3cfbb; color: #146c43;">
                            <i class="fa-solid fa-user-tie text-[9px]"></i>
                            <span>Founder E-Voters.id</span>
                        </span>
                        <h3 class="text-3xl font-extrabold" style="color: #0f172a;">Aries Mulyono</h3>
                    </div>
                    <div class="space-y-4 text-base md:text-lg leading-relaxed" style="color: #475569;">
                        <p class="text-justify">
                            Aries Mulyono adalah pemilik sekaligus pendiri E-Voters.id. Selain aktif mengembangkan platform digital ini, beliau juga berkecimpung luas di bidang event organizer, konsultan musik, dan dikenal sebagai aktivis marching band serta pegiat dunia musik tanah air. Beliau juga merupakan pendiri PRO ATS Music Center.
                        </p>
                        <p class="text-justify">
                            Berbekal pengalaman tersebut, Aries menginisiasi pengembangan E-Voters.id dengan komitmen untuk menghadirkan sistem pemungutan suara digital yang aman, praktis, transparan, dan ramah lingkungan bagi berbagai organisasi, sekolah, maupun instansi di Indonesia.
                        </p>
                        <p class="text-justify">
                            Melalui E-Voters.id, Aries berharap dapat mendorong terwujudnya proses demokrasi yang lebih efisien dan modern, sekaligus memperkuat kepercayaan publik terhadap sistem pemilihan digital di berbagai lapisan masyarakat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection