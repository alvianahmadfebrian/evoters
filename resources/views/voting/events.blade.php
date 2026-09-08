@extends('layouts.app')

@section('title', 'Daftar Event Voting - eVoters')

@section('content')
<div class="space-y-8 relative overflow-hidden">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-20 left-1/4 w-[500px] h-[500px] bg-[#ba7c21]/[0.04] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-40 right-1/4 w-[400px] h-[400px] bg-[#9b5f1a]/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <!-- Hero Header -->
    <div class="text-center max-w-2xl mx-auto space-y-3 pt-6 pb-2">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold tracking-wide mb-2" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Jelajahi Event</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-tight" style="color: #0f172a;">
            Daftar Event <span style="color: #ba7c21;">Pemungutan Suara</span>
        </h1>
        <p class="text-sm md:text-base leading-relaxed max-w-xl mx-auto" style="color: #64748b;">
            Temukan event voting yang sedang aktif maupun riwayat event yang telah selesai diselenggarakan.
        </p>
    </div>

    <!-- Search Engine & Filter Pills Section -->
    <div class="max-w-2xl mx-auto space-y-4">
        <form action="{{ route('events.list') }}" method="GET" class="flex items-center gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none" style="color: #94a3b8 !important;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama event atau deskripsi..." 
                    style="background: #ffffff !important; border: 1.5px solid #cbd5e1 !important; color: #0f172a !important; padding-left: 2.75rem !important; box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;"
                    class="w-full py-3 pr-4 rounded-xl text-sm focus:outline-none transition-all"
                >
            </div>
            @if(request('search'))
                <a href="{{ route('events.list', ['status' => request('status')]) }}" style="background: #f1f5f9 !important; border: 1.5px solid #cbd5e1 !important; color: #334155 !important;" class="font-medium text-sm px-5 py-3 rounded-xl transition-all hover:opacity-80 whitespace-nowrap">
                    Reset
                </a>
            @endif
            <button type="submit" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a) !important; color: #ffffff !important; border: none !important;" class="font-semibold text-sm px-6 py-3 rounded-xl transition-all cursor-pointer shadow-md hover:opacity-90 whitespace-nowrap">
                <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Cari
            </button>
        </form>

        <!-- Status Filter Pills -->
        <div class="flex items-center justify-center gap-2 pt-1 flex-wrap">
            <a href="{{ route('events.list', array_filter(['search' => request('search')])) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ !request('status') ? 'bg-[#ba7c21] text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                Semua Event
            </a>
            <a href="{{ route('events.list', array_filter(['status' => 'active', 'search' => request('search')])) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ request('status') === 'active' ? 'bg-[#ba7c21] text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                <i class="fa-solid fa-circle text-[8px] mr-1 text-emerald-400"></i> Event Aktif
            </a>
            <a href="{{ route('events.list', array_filter(['status' => 'completed', 'search' => request('search')])) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ request('status') === 'completed' ? 'bg-[#ba7c21] text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                <i class="fa-solid fa-flag-checkered text-[10px] mr-1"></i> Selesai / Ditutup
            </a>
        </div>
    </div>

    <!-- Results Count Bar -->
    <div class="flex items-center justify-between pb-2" style="border-bottom: 1px solid #f1f5f9;">
        <div class="flex items-center space-x-2">
            @if(request('status') === 'active')
                <span class="inline-flex w-2 h-2 rounded-full animate-pulse" style="background: #ba7c21;"></span>
                <span class="text-xs font-bold uppercase tracking-wider" style="color: #334155;">Event Aktif</span>
            @elseif(request('status') === 'completed')
                <span class="inline-flex w-2 h-2 rounded-full bg-slate-400"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Event Selesai</span>
            @else
                <span class="inline-flex w-2 h-2 rounded-full" style="background: #ba7c21;"></span>
                <span class="text-xs font-bold uppercase tracking-wider" style="color: #334155;">Semua Event</span>
            @endif
        </div>
        <div class="text-xs font-medium" style="color: #64748b;">
            <span style="color: #ba7c21; font-weight: 700;">{{ $events->total() }}</span> event ditemukan
        </div>
    </div>

    <!-- Events Grid -->
    <section>
        @if($events->isEmpty())
            <div class="rounded-3xl p-14 text-center space-y-5 max-w-md mx-auto bg-white border border-slate-200/80 shadow-sm">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto bg-slate-50 border border-slate-200 text-slate-400">
                    <i class="fa-solid fa-calendar-xmark text-2xl"></i>
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-lg font-bold text-slate-900">Event tidak ditemukan</h3>
                    <p class="text-sm leading-relaxed text-slate-500">
                        @if(request('search'))
                            Tidak ada event yang cocok dengan kata kunci <span style="color: #ba7c21; font-weight: 600;">"{{ request('search') }}"</span>.
                        @else
                            Belum ada event yang terdaftar dalam kategori ini.
                        @endif
                    </p>
                </div>
                @if(request('search') || request('status'))
                    <a href="{{ route('events.list') }}" class="inline-flex items-center text-xs font-semibold py-2.5 px-5 rounded-xl transition-all hover:opacity-80 bg-slate-100 border border-slate-200 text-slate-700">
                        <i class="fa-solid fa-rotate-left mr-2"></i> Reset Filter
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div class="rounded-3xl overflow-hidden border border-slate-200/80 bg-white transition-all duration-300 flex flex-col group hover:-translate-y-1.5 hover:shadow-xl shadow-sm">
                        <!-- Banner Image -->
                        <div class="h-48 w-full relative overflow-hidden bg-slate-100 flex-shrink-0">
                            @if($event->banner_image)
                                <img src="{{ asset($event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 {{ $event->status !== 'active' ? 'grayscale-[30%]' : '' }}">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-amber-50 via-slate-50 to-amber-100/40 flex items-center justify-center relative">
                                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#ba7c21_1px,transparent_1px)] [background-size:16px_16px]"></div>
                                    <i class="fa-solid fa-image text-3xl text-slate-300"></i>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="absolute top-3.5 right-3.5 flex items-center space-x-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md shadow-sm border border-slate-200/60">
                                @if($event->status === 'active')
                                    <span class="w-1.5 h-1.5 rounded-full" style="background: #ba7c21;"></span>
                                    <span style="color: #9b5f1a;">Aktif</span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    <span class="text-slate-600">Selesai</span>
                                @endif
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
                                @if($event->status === 'active')
                                    <a href="{{ route('event.show', $event->slug) }}" class="flex-grow text-white font-bold text-xs py-3 px-4 rounded-xl text-center transition-all cursor-pointer hover:opacity-90 shadow-md shadow-[#ba7c21]/20 flex items-center justify-center gap-1.5" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                                        <i class="fa-solid fa-check-to-slot"></i>
                                        <span>Vote Sekarang</span>
                                    </a>
                                    <a href="{{ route('event.results', $event->slug) }}" title="Lihat Hasil Realtime" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 font-semibold text-xs p-3 rounded-xl text-center transition-all flex items-center justify-center">
                                        <i class="fa-solid fa-chart-simple"></i>
                                    </a>
                                @else
                                    <a href="{{ route('event.results', $event->slug) }}" class="flex-grow bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-800 font-bold text-xs py-3 px-4 rounded-xl text-center transition-all flex items-center justify-center gap-1.5">
                                        <i class="fa-solid fa-chart-pie text-[#ba7c21]"></i>
                                        <span>Lihat Hasil Akhir</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($events->hasPages())
                <div class="mt-10">
                    {{ $events->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </section>
</div>
@endsection