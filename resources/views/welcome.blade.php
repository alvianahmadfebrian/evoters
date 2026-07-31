@extends('layouts.app')

@section('title', 'eVoters - Platform Voting Online Terbuka & Transparan')

@section('content')
<div class="space-y-12">
    <!-- Hero Section -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center py-8 md:py-16">
        <!-- Left Side: Text and Search -->
        <div class="lg:col-span-7 space-y-6 text-left">
            <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-xs font-semibold tracking-wide">
                <i class="fa-solid fa-fire-flame-curved"></i>
                <span>Platform Voting Terbuka & Privat</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight">
                Ambil Keputusan Bersama dengan <br>
                <span class="bg-gradient-to-r from-cyan-600 via-emerald-600 to-emerald-500 bg-clip-text text-transparent">
                    Lebih Cepat, Adil & Transparan
                </span>
            </h1>
            
            <p class="text-lg text-slate-600 font-medium max-w-xl">
                Platform pemungutan suara online terpercaya untuk komunitas, organisasi, sekolah, dan perusahaan. Lacak hasil secara real-time dan aman.
            </p>

            <!-- Search Form -->
            <div class="pt-4 max-w-xl">
                <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari event voting aktif..." 
                            class="w-full pl-10 pr-4 py-3.5 rounded-2xl glass-card text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white/90"
                        >
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm px-6 py-3.5 rounded-2xl transition-all cursor-pointer shadow-lg shadow-emerald-600/30 flex items-center justify-center whitespace-nowrap">
                        Cari Event
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Side: Image/Mockup -->
        <div class="lg:col-span-5 relative flex justify-center">
            <!-- Glow background decorators -->
            <div class="absolute -top-10 -left-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-cyan-500/10 rounded-full blur-3xl"></div>
            
            <!-- Glass Frame -->
            <div class="relative w-full max-w-md p-3 glass-card rounded-[2.5rem] border border-white/20 shadow-2xl overflow-hidden transform hover:scale-[1.02] transition-transform duration-500">
                <img 
                    src="{{ asset('images/voting_hand.png') }}" 
                    alt="Voting Hand Mockup" 
                    class="w-full h-auto object-cover rounded-[2rem] aspect-[4/3] shadow-inner"
                >
                <!-- Subtle UI overlap card -->
                <div class="absolute bottom-6 right-6 glass-card p-4 rounded-2xl border border-white/20 shadow-xl flex items-center space-x-3 max-w-[200px] animate-bounce duration-1000">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Vote Berhasil</p>
                        <p class="text-[10px] text-slate-500">Terverifikasi aman</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Events Grid Section -->
    <section class="space-y-6 pt-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white">Event Voting Aktif</h2>
                <p class="text-xs text-gray-400">Pilih salah satu event aktif di bawah ini untuk memberikan suara Anda.</p>
            </div>
            <div class="text-xs text-gray-400 font-medium">
                Menampilkan <span class="text-indigo-400 font-bold">{{ $activeEvents->count() }}</span> Event
            </div>
        </div>

        @if($activeEvents->isEmpty())
            <div class="glass-card rounded-2xl p-12 text-center border border-white/5 space-y-4">
                <div class="w-16 h-16 bg-gray-900 rounded-full flex items-center justify-center mx-auto border border-white/5 text-gray-500">
                    <i class="fa-solid fa-folder-open text-2xl"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-white">Tidak ada event aktif</h3>
                    <p class="text-sm text-gray-500">Saat ini tidak ada kegiatan pemungutan suara aktif yang terdaftar.</p>
                </div>
                @if(request('search'))
                    <a href="{{ route('home') }}" class="inline-block text-xs font-semibold text-indigo-400 hover:text-indigo-300">
                        Hapus filter pencarian
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activeEvents as $event)
                    <div class="glass-card rounded-2xl overflow-hidden border border-white/5 hover:border-white/15 transition-all duration-300 flex flex-col group hover:-translate-y-1 shadow-lg">
                        <!-- Banner Image -->
                        <div class="h-44 w-full relative overflow-hidden bg-slate-900 flex-shrink-0">
                            @if($event->banner_image)
                                <img src="{{ asset($event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-950 via-slate-900 to-purple-950 flex items-center justify-center relative">
                                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:16px_16px]"></div>
                                    <i class="fa-solid fa-image text-3xl text-indigo-500/30"></i>
                                </div>
                            @endif
                            
                            
                        </div>

                        <!-- Content Info -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="text-lg font-bold text-white line-clamp-1 group-hover:text-indigo-400 transition-colors">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed">
                                    {{ $event->description ?: 'Tidak ada deskripsi.' }}
                                </p>
                            </div>

                            <!-- Small Stats -->
                            <div class="pt-4 border-t border-white/5 flex items-center justify-between text-xs text-gray-500 font-medium">
                                <div>
                                    <i class="fa-solid fa-users mr-1"></i> {{ $event->candidates_count ?? $event->candidates()->count() }} Kandidat
                                </div>
                                <div>
                                    <i class="fa-solid fa-box-archive mr-1"></i> {{ $event->votes_count ?? $event->votes()->count() }} Suara Masuk
                                </div>
                            </div>

                            <!-- Vote Action -->
                            <div class="flex gap-2">
                                <a href="{{ route('event.show', $event->slug) }}" class="flex-grow bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs py-3 px-4 rounded-xl text-center transition-all cursor-pointer">
                                    <i class="fa-solid fa-check-to-slot mr-1.5"></i> Vote Sekarang
                                </a>
                                <a href="{{ route('event.results', $event->slug) }}" title="Lihat Hasil" class="bg-white/5 hover:bg-white/10 border border-white/5 text-gray-300 hover:text-white font-semibold text-xs p-3 rounded-xl text-center transition-all">
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


