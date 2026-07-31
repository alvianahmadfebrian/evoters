@extends('layouts.cms')

@section('title', 'Daftar Event Voting - eVoters')
@section('page_title', 'Semua Event Voting')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Header Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-white">Kelola Voting Event</h3>
            <p class="text-xs text-gray-400">Aktifkan, jeda, atau buat event voting baru secara instan.</p>
        </div>
        <a href="{{ route('cms.events.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-lg shadow-indigo-600/20 flex items-center justify-center cursor-pointer">
            <i class="fa-solid fa-plus mr-1.5"></i> Buat Event Baru
        </a>
    </div>

    <!-- Table Card Container -->
    <div class="glass-card rounded-2xl border border-white/5 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs text-gray-400 uppercase bg-white/5 border-b border-white/5 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Nama Event</th>
                        <th class="px-6 py-4">Tipe Voting</th>
                        <th class="px-6 py-4">Tarif</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Kandidat</th>
                        <th class="px-6 py-4 text-center">Total Suara</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($events as $event)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <!-- Title & Slug -->
                            <td class="px-6 py-4">
                                <a href="{{ route('cms.events.show', $event->id) }}" class="font-bold text-white hover:text-indigo-400 transition-colors block text-sm">
                                    {{ $event->title }}
                                </a>
                                <div class="flex items-center space-x-1.5 mt-1 text-[10px] text-gray-500">
                                    <span>Slug: <span class="text-gray-400 font-semibold">{{ $event->slug }}</span></span>
                                    <span>&bull;</span>
                                    <span>Dibuat {{ $event->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <!-- Type -->
                            <td class="px-6 py-4">
                                @if($event->voting_type === 'public_email')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <i class="fa-solid fa-envelope mr-1"></i> EMAIL TERBUKA
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-500/10 text-purple-400 border border-purple-500/20">
                                        <i class="fa-solid fa-ticket mr-1"></i> TOKEN PRIVAT
                                    </span>
                                @endif
                            </td>
                            <!-- Price -->
                            <td class="px-6 py-4 font-semibold text-xs whitespace-nowrap">
                                @if($event->price > 0)
                                    <span class="text-emerald-600 font-bold">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-slate-500">Gratis</span>
                                @endif
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if($event->status === 'active')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-green-500/10 text-green-400 border border-green-500/20">
                                        <i class="fa-solid fa-circle text-[6px] mr-1 animate-pulse text-green-400"></i> AKTIF
                                    </span>
                                @elseif($event->status === 'draft')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                        DRAFT
                                    </span>
                                @elseif($event->status === 'paused')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                                        PAUSED
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                                        CLOSED
                                    </span>
                                @endif
                            </td>
                            <!-- Candidate count -->
                            <td class="px-6 py-4 text-center font-bold text-gray-100">
                                {{ $event->candidates_count }}
                            </td>
                            <!-- Vote count -->
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold text-gray-100">{{ $event->votes_sum_quantity ?? 0 }}</span>
                                @if($event->voting_type === 'token_only' && $event->price == 0)
                                    <span class="text-[10px] text-gray-500 block">dari {{ $event->tokens_count }} token</span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Monitor Details -->
                                    <a href="{{ route('cms.events.show', $event->id) }}" class="text-xs font-semibold bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 text-indigo-400 px-3 py-1.5 rounded-lg transition-colors cursor-pointer" title="Monitor & Kelola">
                                        <i class="fa-solid fa-gauge mr-1"></i> Monitor
                                    </a>
                                    <!-- Edit -->
                                    <a href="{{ route('cms.events.edit', $event->id) }}" class="text-xs font-semibold bg-white/5 hover:bg-white/10 border border-white/5 text-gray-300 px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <!-- Delete -->
                                    <form action="{{ route('cms.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini beserta kandidat, token, dan seluruh suara masuk?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 p-1.5 rounded-lg transition-colors cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="space-y-2">
                                    <i class="fa-solid fa-calendar-xmark text-4xl text-gray-600 block"></i>
                                    <p class="text-sm">Belum ada event terdaftar.</p>
                                    <a href="{{ route('cms.events.create') }}" class="inline-block text-xs font-semibold text-indigo-400 hover:text-indigo-300">Buat event pertama Anda sekarang &rarr;</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div class="px-6 py-4 border-t border-white/5 bg-white/[0.01]">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
