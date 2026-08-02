@extends('layouts.app')

@section('title', 'Daftar Event Voting - eVoters')

@section('content')
<div class="space-y-8 relative overflow-hidden">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-20 left-1/4 w-[500px] h-[500px] bg-emerald-400/[0.03] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-40 right-1/4 w-[400px] h-[400px] bg-cyan-400/[0.03] rounded-full blur-3xl pointer-events-none"></div>

    <!-- Hero Header -->
    <div class="text-center max-w-2xl mx-auto space-y-3 pt-6 pb-2">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-semibold tracking-wide mb-2">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Jelajahi Event</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-tight" style="color: #0f172a;">
            Daftar Event <span style="color: #059669;">Voting Aktif</span>
        </h1>
        <p class="text-sm md:text-base leading-relaxed max-w-xl mx-auto" style="color: #64748b;">
            Cari dan temukan event pemungutan suara yang sedang berlangsung. Pilih event di bawah untuk memberikan suara Anda.
        </p>
    </div>

    <!-- Search Engine Section -->
    <div class="max-w-xl mx-auto">
        <form action="{{ route('events.list') }}" method="GET" class="flex items-center gap-3">
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
                <a href="{{ route('events.list') }}" style="background: #f1f5f9 !important; border: 1.5px solid #cbd5e1 !important; color: #334155 !important;" class="font-medium text-sm px-5 py-3 rounded-xl transition-all hover:opacity-80 whitespace-nowrap">
                    Reset
                </a>
            @endif
            <button type="submit" style="background: #059669 !important; color: #ffffff !important; border: none !important;" class="font-semibold text-sm px-6 py-3 rounded-xl transition-all cursor-pointer shadow-md hover:opacity-90 whitespace-nowrap">
                <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Cari
            </button>
        </form>
    </div>

    <!-- Results Count Bar -->
    <div class="flex items-center justify-between pb-2" style="border-bottom: 1px solid #f1f5f9;">
        <div class="flex items-center space-x-2">
            <span class="inline-flex w-2 h-2 rounded-full animate-pulse" style="background: #10b981;"></span>
            <span class="text-xs font-bold uppercase tracking-wider" style="color: #334155;">Event Aktif</span>
        </div>
        <div class="text-xs font-medium" style="color: #64748b;">
            <span style="color: #059669; font-weight: 700;">{{ $events->total() }}</span> event ditemukan
        </div>
    </div>

    <!-- Events Grid -->
    <section>
        @if($events->isEmpty())
            <div class="rounded-2xl p-14 text-center space-y-5 max-w-md mx-auto" style="background: #ffffff; border: 1px solid #e2e8f0;">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #94a3b8;">
                    <i class="fa-solid fa-calendar-xmark text-2xl"></i>
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-lg font-bold" style="color: #0f172a;">Event tidak ditemukan</h3>
                    <p class="text-sm leading-relaxed" style="color: #64748b;">
                        @if(request('search'))
                            Tidak ada event yang cocok dengan <span style="color: #059669; font-weight: 600;">"{{ request('search') }}"</span>.
                        @else
                            Belum ada event aktif saat ini.
                        @endif
                    </p>
                </div>
                @if(request('search'))
                    <a href="{{ route('events.list') }}" class="inline-flex items-center text-xs font-semibold py-2.5 px-5 rounded-lg transition-all hover:opacity-80" style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #334155;">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Lihat Semua
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <a href="{{ route('event.show', $event->slug) }}" class="block rounded-2xl overflow-hidden transition-all duration-300 group hover:-translate-y-0.5 hover:shadow-lg" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                        
                        <!-- Banner -->
                        <div class="h-44 w-full relative overflow-hidden" style="background: #f1f5f9;">
                            @if($event->banner_image)
                                <img src="{{ asset($event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, #ecfdf5, #f0f9ff);">
                                    <i class="fa-solid fa-image text-3xl" style="color: #d1fae5;"></i>
                                </div>
                            @endif
                            <!-- Badge -->
                            <div class="absolute top-3 right-3 flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider" style="background: rgba(255,255,255,0.92); backdrop-filter: blur(8px); color: #059669; border: 1px solid #d1fae5;">
                                <span class="w-1.5 h-1.5 rounded-full" style="background: #10b981;"></span>
                                <span>Aktif</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5 space-y-4">
                            <div class="space-y-1.5">
                                <h3 class="text-base font-bold line-clamp-1 group-hover:opacity-80 transition-opacity" style="color: #0f172a;">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-xs line-clamp-2 leading-relaxed" style="color: #64748b;">
                                    {{ $event->description ?: 'Tidak ada deskripsi event.' }}
                                </p>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-xs font-medium pt-3" style="border-top: 1px solid #f1f5f9; color: #64748b;">
                                <div class="flex items-center space-x-1">
                                    <i class="fa-solid fa-users" style="color: #059669;"></i>
                                    <span>{{ $event->candidates_count ?? $event->candidates()->count() }} Kandidat</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="fa-solid fa-box-archive" style="color: #059669;"></i>
                                    <span>{{ $event->votes_count ?? $event->votes()->count() }} Suara</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 pt-1">
                                <span class="flex-grow text-center font-semibold text-xs py-3 px-4 rounded-xl transition-all" style="background: #059669; color: #ffffff;">
                                    <i class="fa-solid fa-check-to-slot mr-1.5"></i> Vote Sekarang
                                </span>
                                <span onclick="event.preventDefault(); window.location='{{ route('event.results', $event->slug) }}';" class="flex items-center justify-center text-xs p-3 rounded-xl transition-all hover:opacity-80 cursor-pointer" style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569;">
                                    <i class="fa-solid fa-chart-simple"></i>
                                </span>
                            </div>
                        </div>
                    </a>
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