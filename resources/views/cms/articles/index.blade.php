@extends('layouts.cms')

@section('title', 'Daftar Berita & Artikel - eVoters')
@section('page_title', 'Kelola Berita & Artikel')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Header Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-white">Kelola Berita & Informasi</h3>
            <p class="text-xs text-gray-400">Tulis, edit, dan publikasikan artikel berita terbaru untuk pengunjung dan pemilih.</p>
        </div>
        <a href="{{ route('cms.articles.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-lg shadow-indigo-600/20 flex items-center justify-center cursor-pointer">
            <i class="fa-solid fa-plus mr-1.5"></i> Tulis Berita Baru
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="glass-card p-4 rounded-2xl border border-white/5 flex flex-col md:flex-row gap-3 items-center justify-between">
        <form action="{{ route('cms.articles.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto flex-grow">
            <div class="relative flex-grow max-w-md">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari judul berita..." 
                    class="glass-input w-full pl-9 pr-4 py-2 rounded-xl text-xs text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                >
            </div>

            <select name="status" class="glass-input px-3 py-2 rounded-xl text-xs text-gray-300 focus:outline-none focus:ring-1 focus:ring-indigo-500 bg-[#0d1424]">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <button type="submit" class="bg-white/5 hover:bg-white/10 text-gray-300 text-xs font-semibold px-4 py-2 rounded-xl border border-white/10 transition-colors">
                Filter
            </button>

            @if(request('search') || request('status') || request('category'))
                <a href="{{ route('cms.articles.index') }}" class="text-xs text-gray-400 hover:text-white flex items-center justify-center px-3 py-2">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card Container -->
    <div class="glass-card rounded-2xl border border-white/5 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs text-gray-400 uppercase bg-white/5 border-b border-white/5 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Berita</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Dilihat</th>
                        <th class="px-6 py-4">Tanggal Rilis</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($articles as $article)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <!-- Title & Image preview -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-slate-800 flex-shrink-0 overflow-hidden border border-white/10 flex items-center justify-center">
                                        @if($article->image)
                                            <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-newspaper text-gray-500"></i>
                                        @endif
                                    </div>
                                    <div class="max-w-md">
                                        <a href="{{ route('news.show', $article->slug) }}" target="_blank" class="font-bold text-white hover:text-indigo-400 transition-colors block text-sm line-clamp-1">
                                            {{ $article->title }}
                                        </a>
                                        <p class="text-[11px] text-gray-400 line-clamp-1 mt-0.5">{{ $article->excerpt }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    {{ $article->category }}
                                </span>
                            </td>

                            <!-- Author -->
                            <td class="px-6 py-4 text-xs text-gray-300">
                                {{ $article->author_name }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if($article->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <i class="fa-solid fa-circle-check mr-1 text-[8px]"></i> Terbit
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                        <i class="fa-solid fa-file-pen mr-1 text-[8px]"></i> Draft
                                    </span>
                                @endif
                            </td>

                            <!-- Views -->
                            <td class="px-6 py-4 text-center text-xs text-gray-400 font-mono">
                                {{ number_format($article->views_count) }}
                            </td>

                            <!-- Date -->
                            <td class="px-6 py-4 text-xs text-gray-400">
                                {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('news.show', $article->slug) }}" target="_blank" title="Lihat di Web" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-colors">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                    <a href="{{ route('cms.articles.edit', $article->id) }}" title="Edit Berita" class="p-1.5 rounded-lg bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 transition-colors">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('cms.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Berita" class="p-1.5 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 transition-colors cursor-pointer">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <i class="fa-regular fa-newspaper text-3xl mb-2 text-gray-600 block"></i>
                                <p class="text-sm font-semibold text-gray-300">Belum ada berita yang tersedia</p>
                                <p class="text-xs text-gray-500 mt-0.5">Mulai publikasikan berita atau informasi terkini untuk platform voting Anda.</p>
                                <a href="{{ route('cms.articles.create') }}" class="mt-4 inline-flex items-center text-xs font-semibold px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                                    <i class="fa-solid fa-plus mr-1.5"></i> Tulis Berita Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="px-6 py-4 border-t border-white/5">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
