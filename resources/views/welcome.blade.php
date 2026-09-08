@extends('layouts.app')

@section('title', 'eVoters - Platform Voting Online Terbuka & Transparan')

@push('styles')
<style>
    @keyframes floatSlow {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }
    @keyframes floatReverse {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(8px); }
    }
    .float-badge-1 {
        animation: floatSlow 4s ease-in-out infinite;
    }
    .float-badge-2 {
        animation: floatReverse 4.5s ease-in-out infinite;
    }
    .feature-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 30px -10px rgba(186, 124, 33, 0.15);
        border-color: rgba(186, 124, 33, 0.35) !important;
    }
    .step-card {
        transition: all 0.3s ease;
    }
    .step-card:hover {
        transform: translateY(-4px);
    }
</style>
@endpush

@section('content')
<div class="space-y-20 relative overflow-hidden pb-12">
    
    <!-- Ambient Glow Background Decorators -->
    <div class="absolute -top-32 left-1/4 w-[600px] h-[600px] bg-[#ba7c21]/[0.05] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-[600px] right-1/4 w-[500px] h-[500px] bg-[#9b5f1a]/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <!-- ==================== HERO SECTION ==================== -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center pt-4 md:pt-10">
        <!-- Left Column: Copy & Search Form -->
        <div class="lg:col-span-7 space-y-6 text-left">
            
            <!-- Live Badge -->
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full text-xs font-semibold tracking-wide shadow-sm" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
                <span class="w-2 h-2 rounded-full animate-ping" style="background: #ba7c21;"></span>
                <i class="fa-solid fa-crown text-[#ba7c21] text-xs"></i>
                <span>Platform E-Voting #1 Terpercaya & Real-Time</span>
            </div>
            
            <!-- Main Headline -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.12]">
                Ambil Keputusan Bersama dengan <br class="hidden sm:inline">
                <span style="background: linear-gradient(135deg, #ba7c21, #9b5f1a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; color: #ba7c21;">
                    Lebih Cepat, Adil & Transparan
                </span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-base sm:text-lg text-slate-600 font-normal leading-relaxed max-w-xl">
                Solusi pemungutan suara online modern untuk sekolah, komunitas, organisasi, dan perusahaan. Nikmati penghitungan suara instan, enkripsi data terjamin, dan sistem pembayaran QRIS otomatis.
            </p>

            <!-- Search Form -->
            <div class="pt-2 max-w-xl">
                <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari event voting aktif..." 
                            style="background: #ffffff !important; border: 1.5px solid #cbd5e1 !important; color: #0f172a !important; padding-left: 2.75rem !important; box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;"
                            class="w-full pr-4 py-3.5 rounded-2xl text-sm focus:outline-none transition-all"
                        >
                    </div>
                    @if(request('search'))
                        <a href="{{ route('home') }}" style="background: #f1f5f9 !important; border: 1.5px solid #cbd5e1 !important; color: #334155 !important;" class="font-medium text-sm px-5 py-3.5 rounded-2xl transition-all hover:opacity-80 flex items-center justify-center whitespace-nowrap">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="text-white font-bold text-sm px-7 py-3.5 rounded-2xl transition-all cursor-pointer shadow-lg shadow-[#ba7c21]/25 flex items-center justify-center whitespace-nowrap hover:opacity-90" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                        <i class="fa-solid fa-magnifying-glass mr-2"></i> Cari Event
                    </button>
                </form>
            </div>

            <!-- Micro Trust Badges Row -->
            <div class="pt-3 flex flex-wrap items-center gap-x-5 gap-y-2.5 text-xs text-slate-500 font-medium">
                <span class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-bolt text-[#ba7c21]"></i>
                    <span>Real-Time Leaderboard</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-check text-[#ba7c21]"></i>
                    <span>Enkripsi SSL & Anti Duplikasi</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-qrcode text-[#ba7c21]"></i>
                    <span>QRIS & E-Wallet Instan</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-users text-[#ba7c21]"></i>
                    <span>Ribuan Voter Terlayani</span>
                </span>
            </div>

        </div>

        <!-- Right Column: Visual Mockup with Floating Dynamic Cards -->
        <div class="lg:col-span-5 relative flex justify-center mt-6 lg:mt-0">
            <!-- Glow background decorators -->
            <div class="absolute -top-8 -left-8 w-64 h-64 bg-[#ba7c21]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-8 -right-8 w-64 h-64 bg-[#9b5f1a]/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <!-- Glass Frame Card -->
            <div class="relative w-full max-w-md p-3.5 rounded-[2.5rem] border border-slate-200/80 bg-white/95 shadow-2xl overflow-hidden transition-all duration-500">
                <img 
                    src="{{ asset('images/voting_hand.png') }}" 
                    alt="Voting Hand Mockup" 
                    class="w-full h-auto object-cover rounded-[2rem] aspect-[4/3] shadow-sm"
                >
                
                <!-- Floating Badge 1: Top Left (Live Accuracy) -->
                <div class="float-badge-1 absolute top-6 left-6 p-2.5 px-3.5 rounded-2xl bg-white/95 backdrop-blur-md border border-slate-200/80 shadow-lg flex items-center space-x-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-800 leading-none">99.9% Akurat</p>
                        <p class="text-[8px] text-slate-500 leading-none mt-0.5">Validasi Sistem Otomatis</p>
                    </div>
                </div>

                <!-- Floating Badge 2: Bottom Right (Vote Success) -->
                <div class="float-badge-2 absolute bottom-6 right-6 p-3 px-4 rounded-2xl bg-white/95 backdrop-blur-md border border-slate-200/80 shadow-xl flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs shadow-md" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Suara Terverifikasi</p>
                        <p class="text-[10px] text-slate-500">Hasil langsung tercatat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== EVENTS GRID SECTION ==================== -->
    <section class="space-y-6 max-w-7xl mx-auto pt-4">
        <!-- Header bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-slate-100">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex w-2.5 h-2.5 rounded-full animate-pulse" style="background: #ba7c21;"></span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Event Voting Aktif</h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Pilih salah satu event pemungutan suara yang sedang berlangsung saat ini.</p>
            </div>
            <div class="flex items-center space-x-3 text-xs text-slate-500 font-medium">
                <span>
                    Menampilkan <span class="font-bold" style="color: #ba7c21;">{{ $activeEvents->count() }}</span> Event
                </span>
                <span class="text-slate-300">|</span>
                <a href="{{ route('events.list') }}" class="font-bold transition-colors flex items-center gap-1.5" style="color: #ba7c21;">
                    <span>Lihat Semua Event</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        @if($activeEvents->isEmpty())
            <div class="rounded-3xl p-14 text-center border border-slate-200/80 bg-white space-y-4 max-w-lg mx-auto shadow-sm">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto border border-slate-200 text-slate-400">
                    <i class="fa-solid fa-calendar-xmark text-2xl"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800">Tidak ada event aktif</h3>
                    <p class="text-sm text-slate-500">
                        @if(request('search'))
                            Tidak ada event yang cocok dengan kata kunci <strong>"{{ request('search') }}"</strong>.
                        @else
                            Saat ini belum ada event pemungutan suara aktif yang terdaftar.
                        @endif
                    </p>
                </div>
                @if(request('search'))
                    <a href="{{ route('home') }}" class="inline-block text-xs font-semibold px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Hapus Filter Pencarian
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activeEvents as $event)
                    <div class="rounded-3xl overflow-hidden border border-slate-200/80 bg-white transition-all duration-300 flex flex-col group hover:-translate-y-1.5 hover:shadow-xl shadow-sm">
                        <!-- Banner Image -->
                        <div class="h-48 w-full relative overflow-hidden bg-slate-100 flex-shrink-0">
                            @if($event->banner_image)
                                <img src="{{ asset($event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-amber-50 via-slate-50 to-amber-100/40 flex items-center justify-center relative">
                                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#ba7c21_1px,transparent_1px)] [background-size:16px_16px]"></div>
                                    <i class="fa-solid fa-image text-3xl text-slate-300"></i>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="absolute top-3.5 right-3.5 flex items-center space-x-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md shadow-sm border border-slate-200/60" style="color: #9b5f1a;">
                                <span class="w-1.5 h-1.5 rounded-full" style="background: #ba7c21;"></span>
                                <span>Aktif</span>
                            </div>

                            <!-- Pricing Badge -->
                            <div class="absolute bottom-3.5 left-3.5">
                                @if($event->price > 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-slate-900/85 backdrop-blur-md text-white shadow-sm">
                                        <i class="fa-solid fa-coins mr-1 text-[#ba7c21]"></i> Rp {{ number_format($event->price, 0, ',', '.') }} / vote
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-emerald-700/90 backdrop-blur-md text-white shadow-sm">
                                        <i class="fa-solid fa-ticket mr-1"></i> Gratis / Token
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="text-lg font-bold text-slate-900 line-clamp-1 group-hover:text-[#ba7c21] transition-colors">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ $event->description ?: 'Pilih kandidat terbaik Anda dalam pelaksanaan event pemungutan suara ini.' }}
                                </p>
                            </div>

                            <!-- Stats Row -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-users text-[#ba7c21]"></i>
                                    <span>{{ $event->candidates_count ?? $event->candidates->count() }} Kandidat</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-box-archive text-[#ba7c21]"></i>
                                    <span>{{ $event->votes_count ?? $event->votes()->count() }} Suara Masuk</span>
                                </div>
                            </div>

                            <!-- Vote Actions -->
                            <div class="flex gap-2 pt-1">
                                <a href="{{ route('event.show', $event->slug) }}" class="flex-grow text-white font-bold text-xs py-3 px-4 rounded-xl text-center transition-all cursor-pointer hover:opacity-90 shadow-md shadow-[#ba7c21]/20 flex items-center justify-center gap-1.5" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                                    <i class="fa-solid fa-check-to-slot"></i>
                                    <span>Vote Sekarang</span>
                                </a>
                                <a href="{{ route('event.results', $event->slug) }}" title="Lihat Hasil Realtime" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 font-semibold text-xs p-3 rounded-xl text-center transition-all flex items-center justify-center">
                                    <i class="fa-solid fa-chart-simple"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

</div>
@endsection
