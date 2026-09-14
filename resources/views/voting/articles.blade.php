@extends('layouts.app')

@section('title', 'Berita & Informasi Terkini - eVoters')

@section('content')
<div class="space-y-8 relative overflow-hidden">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-20 left-1/4 w-[500px] h-[500px] bg-[#ba7c21]/[0.04] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-40 right-1/4 w-[400px] h-[400px] bg-[#9b5f1a]/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <!-- Hero Header -->
    <div class="text-center max-w-2xl mx-auto space-y-3 pt-6 pb-2">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-semibold tracking-wide mb-2" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
            <i class="fa-solid fa-newspaper"></i>
            <span>Pusat Berita & Informasi</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-tight" style="color: #0f172a;">
            Kabar Terbaru & <span style="color: #ba7c21;">Panduan eVoters</span>
        </h1>
        <p class="text-sm md:text-base leading-relaxed max-w-xl mx-auto" style="color: #64748b;">
            Ikuti perkembangan terkini hasil pemilihan, edukasi hak suara digital, serta panduan praktis voting online.
        </p>
    </div>

    <!-- Search Engine & Category Filter Section -->
    <div class="max-w-2xl mx-auto space-y-4">
        <!-- Search Bar -->
        <form action="{{ route('news.index') }}" method="GET" class="flex items-center gap-3">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none" style="color: #94a3b8 !important;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari berita atau panduan..." 
                    style="background: #ffffff !important; border: 1.5px solid #cbd5e1 !important; color: #0f172a !important; padding-left: 2.75rem !important; box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;"
                    class="w-full py-3 pr-4 rounded-xl text-sm focus:outline-none transition-all"
                >
            </div>
            @if(request('search'))
                <a href="{{ route('news.index', ['category' => request('category')]) }}" style="background: #f1f5f9 !important; border: 1.5px solid #cbd5e1 !important; color: #334155 !important;" class="font-medium text-sm px-5 py-3 rounded-xl transition-all hover:opacity-80 whitespace-nowrap">
                    Reset
                </a>
            @endif
            <button type="submit" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a) !important; color: #ffffff !important; border: none !important;" class="font-semibold text-sm px-6 py-3 rounded-xl transition-all cursor-pointer shadow-md hover:opacity-90 whitespace-nowrap">
                <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Cari
            </button>
        </form>

        <!-- Category Filter Pills -->
        <div class="flex items-center justify-center gap-2 pt-1 flex-wrap">
            <a href="{{ route('news.index', array_filter(['search' => request('search')])) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ !request('category') ? 'bg-[#ba7c21] text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                Semua Kategori
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('news.index', array_filter(['category' => $cat, 'search' => request('search')])) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ request('category') === $cat ? 'bg-[#ba7c21] text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Results Count Bar -->
    <div class="flex items-center justify-between pb-2" style="border-bottom: 1px solid #f1f5f9;">
        <div class="flex items-center space-x-2">
            <span class="inline-flex w-2 h-2 rounded-full" style="background: #ba7c21;"></span>
            <span class="text-xs font-bold uppercase tracking-wider" style="color: #334155;">
                {{ request('category') ? 'Kategori: ' . request('category') : 'Semua Berita' }}
            </span>
        </div>
        <div class="text-xs font-medium" style="color: #64748b;">
            <span style="color: #ba7c21; font-weight: 700;">{{ $articles->total() }}</span> artikel ditemukan
        </div>
    </div>

    <!-- News Grid -->
    <section>
        @if($articles->isEmpty())
            <div class="rounded-3xl p-14 text-center space-y-5 max-w-md mx-auto bg-white border border-slate-200/80 shadow-sm">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto bg-slate-50 border border-slate-200 text-slate-400">
                    <i class="fa-solid fa-newspaper text-2xl"></i>
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-lg font-bold text-slate-900">Berita tidak ditemukan</h3>
                    <p class="text-sm leading-relaxed text-slate-500">
                        @if(request('search'))
                            Tidak ada berita yang cocok dengan kata kunci <span style="color: #ba7c21; font-weight: 600;">"{{ request('search') }}"</span>.
                        @else
                            Belum ada berita atau artikel yang terdaftar dalam kategori ini.
                        @endif
                    </p>
                </div>
                @if(request('search') || request('category'))
                    <a href="{{ route('news.index') }}" class="inline-flex items-center text-xs font-semibold py-2.5 px-5 rounded-xl transition-all hover:opacity-80 bg-slate-100 border border-slate-200 text-slate-700">
                        <i class="fa-solid fa-rotate-left mr-2"></i> Reset Filter
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <article class="rounded-3xl overflow-hidden border border-slate-200/80 bg-white transition-all duration-300 flex flex-col group hover:-translate-y-1.5 hover:shadow-xl shadow-sm">
                        <!-- Thumbnail Image -->
                        <a href="{{ route('news.show', $article->slug) }}" class="h-48 w-full relative overflow-hidden bg-slate-100 flex-shrink-0 block">
                            @if($article->image)
                                <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-amber-50 via-slate-50 to-amber-100/40 flex items-center justify-center relative">
                                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#ba7c21_1px,transparent_1px)] [background-size:16px_16px]"></div>
                                    <i class="fa-solid fa-newspaper text-3xl text-slate-300"></i>
                                </div>
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute top-3.5 left-3.5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/95 backdrop-blur-md shadow-sm border border-slate-200/60" style="color: #9b5f1a;">
                                    {{ $article->category }}
                                </span>
                            </div>

                            <!-- Date Badge -->
                            <div class="absolute bottom-3.5 right-3.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white/95 backdrop-blur-md text-slate-800 border border-slate-200/80 shadow-xs">
                                    <i class="fa-regular fa-calendar text-[#ba7c21] mr-1.5 text-xs"></i>
                                    {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </a>

                        <!-- Card Body -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 line-clamp-2 group-hover:text-[#ba7c21] transition-colors leading-snug">
                                    <a href="{{ route('news.show', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                    {{ $article->excerpt }}
                                </p>
                            </div>

                            <!-- Card Footer -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                <div class="flex items-center gap-1.5 font-medium">
                                    <i class="fa-solid fa-user-pen text-[#ba7c21]"></i>
                                    <span class="truncate max-w-[120px]">{{ $article->author_name }}</span>
                                </div>
                                <a href="{{ route('news.show', $article->slug) }}" class="font-bold flex items-center gap-1 transition-colors" style="color: #ba7c21;">
                                    <span>Baca Berita</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($articles->hasPages())
                <div class="pt-6">
                    {{ $articles->links() }}
                </div>
            @endif
        @endif
    </section>

</div>
@endsection

