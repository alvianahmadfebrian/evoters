@extends('layouts.app')

@section('title', $article->title . ' - Berita eVoters')

@section('content')
<div class="space-y-10 max-w-4xl mx-auto w-full pb-16">

    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('home') }}" class="hover:text-[#ba7c21] transition-colors">Beranda</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
        <a href="{{ route('news.index') }}" class="hover:text-[#ba7c21] transition-colors">Berita & Informasi</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
        <span class="text-slate-800 font-bold truncate max-w-xs">{{ $article->title }}</span>
    </nav>

    <!-- Main Article Card -->
    <article class="rounded-3xl p-6 sm:p-10 border border-slate-200/80 bg-white shadow-sm space-y-8">
        
        <!-- Header & Meta -->
        <div class="space-y-4">
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-amber-50 text-[#9b5f1a] border border-amber-200">
                    {{ $article->category }}
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 flex items-center gap-1.5">
                    <i class="fa-solid fa-calendar-days text-[#ba7c21]"></i>
                    {{ $article->published_at ? $article->published_at->format('d F Y, H:i') : $article->created_at->format('d F Y') }} WIB
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 flex items-center gap-1.5">
                    <i class="fa-solid fa-eye text-[#ba7c21]"></i>
                    {{ number_format($article->views_count) }} kali dibaca
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                {{ $article->title }}
            </h1>

            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-sm" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                    {{ strtoupper(substr($article->author_name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-900">{{ $article->author_name }}</p>
                    <p class="text-[10px] text-slate-500">Editor Publikasi eVoters</p>
                </div>
            </div>
        </div>

        <!-- Featured Image Banner (Compact & Centered) -->
        @if($article->image)
            <div class="max-w-lg sm:max-w-xl mx-auto rounded-2xl overflow-hidden shadow-sm border border-slate-200/80 bg-slate-50">
                <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="w-full h-56 sm:h-72 object-cover object-center">
            </div>
        @endif

        <!-- Article Content -->
        <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4 font-normal">
            {!! nl2br(e($article->content)) !!}
        </div>

        <!-- Share & Interaction Bar -->
        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                <i class="fa-solid fa-share-nodes text-[#ba7c21]"></i>
                <span>Bagikan Berita Ini:</span>
            </div>
            
            <div class="flex items-center gap-2">
                <!-- WhatsApp -->
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="p-2.5 px-3.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span class="hidden sm:inline">WhatsApp</span>
                </a>

                <!-- Twitter / X -->
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="p-2.5 px-3.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                    <i class="fa-brands fa-x-twitter text-sm"></i>
                    <span class="hidden sm:inline">X</span>
                </a>

                <!-- Copy Link Button -->
                <button onclick="copyArticleUrl()" id="btn-copy-link" class="p-2.5 px-3.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-[#9b5f1a] text-xs font-semibold flex items-center gap-1.5 transition-colors cursor-pointer border border-amber-200">
                    <i class="fa-solid fa-link text-xs"></i>
                    <span id="copy-text">Salin Tautan</span>
                </button>
            </div>
        </div>

    </article>

    <!-- Recent / Related Articles Section -->
    @if(isset($recentArticles) && $recentArticles->isNotEmpty())
        <div class="space-y-6 pt-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Berita & Informasi Terkait Lainnya</h3>
                    <p class="text-xs text-slate-500">Artikel pilihan lainnya seputar pemilihan dan update sistem.</p>
                </div>
                <a href="{{ route('news.index') }}" class="text-xs font-bold text-[#ba7c21] hover:underline flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($recentArticles as $recent)
                    <a href="{{ route('news.show', $recent->slug) }}" class="rounded-2xl p-4 border border-slate-200/80 bg-white hover:-translate-y-1 hover:shadow-md transition-all flex gap-4 items-center group">
                        <div class="w-24 h-24 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200/60 flex items-center justify-center">
                            @if($recent->image)
                                <img src="{{ asset($recent->image) }}" alt="{{ $recent->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <i class="fa-solid fa-newspaper text-slate-400 text-xl"></i>
                            @endif
                        </div>
                        <div class="flex flex-col justify-between h-full space-y-1 overflow-hidden">
                            <span class="text-[10px] font-bold text-[#ba7c21] uppercase tracking-wider">{{ $recent->category }}</span>
                            <h4 class="text-sm font-bold text-slate-900 group-hover:text-[#ba7c21] transition-colors line-clamp-2 leading-snug">
                                {{ $recent->title }}
                            </h4>
                            <p class="text-[11px] text-slate-500 flex items-center gap-1 mt-1">
                                <i class="fa-solid fa-calendar-days text-[9px]"></i>
                                {{ $recent->published_at ? $recent->published_at->format('d M Y') : $recent->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
function copyArticleUrl() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const textSpan = document.getElementById('copy-text');
        const original = textSpan.textContent;
        textSpan.textContent = 'Tersalin!';
        setTimeout(() => {
            textSpan.textContent = original;
        }, 2000);
    });
}
</script>
@endsection
