@extends('layouts.cms')

@section('title', 'CMS Dashboard - eVoters')
@section('page_title', 'CMS Overview & Analytics')
@section('db_size', $dbSize)

@section('content')
<div class="space-y-8 animate-fade-in">
    
    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Card 1: Events -->
        <div class="glass-card p-4 rounded-2xl border border-white/5 relative overflow-hidden flex items-center justify-between shadow-lg">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-gray-400">Total Event</p>
                <h3 class="text-2xl font-extrabold text-white">{{ $stats['total_events'] }}</h3>
                <span class="text-[9px] text-emerald-400 font-semibold block">
                    <i class="fa-solid fa-circle text-[6px] mr-1"></i> {{ $stats['active_events'] }} Aktif
                </span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-violet-500/10 border border-violet-500/20 text-violet-400 flex items-center justify-center">
                <i class="fa-solid fa-calendar text-lg"></i>
            </div>
        </div>

        <!-- Card 2: Candidates -->
        <div class="glass-card p-4 rounded-2xl border border-white/5 relative overflow-hidden flex items-center justify-between shadow-lg">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-gray-400">Total Kandidat</p>
                <h3 class="text-2xl font-extrabold text-white">{{ $stats['total_candidates'] }}</h3>
                <p class="text-[9px] text-gray-500 font-medium">Di semua event</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center">
                <i class="fa-solid fa-users text-lg"></i>
            </div>
        </div>

        <!-- Card 3: Total Votes -->
        <div class="glass-card p-4 rounded-2xl border border-white/5 relative overflow-hidden flex items-center justify-between shadow-lg">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-gray-400">Suara Masuk</p>
                <h3 class="text-2xl font-extrabold text-white">{{ $stats['total_votes'] }}</h3>
                <p class="text-[9px] text-gray-500 font-medium">Partisipasi voter</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center">
                <i class="fa-solid fa-box-archive text-lg"></i>
            </div>
        </div>

        <!-- Card 4: Tokens Used -->
        <div class="glass-card p-4 rounded-2xl border border-white/5 relative overflow-hidden flex items-center justify-between shadow-lg">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-gray-400">Token Terpakai</p>
                <h3 class="text-2xl font-extrabold text-white">
                    {{ $stats['total_tokens'] > 0 ? round(($stats['used_tokens'] / $stats['total_tokens']) * 100, 1) : 0 }}%
                </h3>
                <span class="text-[9px] text-gray-400 font-medium block">
                    {{ $stats['used_tokens'] }}/{{ $stats['total_tokens'] }} terpakai
                </span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center">
                <i class="fa-solid fa-ticket text-lg"></i>
            </div>
        </div>

        <!-- Card 5: Total Revenue -->
        <div class="glass-card p-4 rounded-2xl border border-white/5 relative overflow-hidden flex items-center justify-between shadow-lg">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-gray-400">Total Pendapatan</p>
                <h3 class="text-xl font-extrabold text-emerald-600">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </h3>
                <p class="text-[9px] text-gray-500 font-medium">Dari QRIS Sukses</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-money-bill-wave text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="glass-card rounded-2xl p-6 border border-white/5">
        <h3 class="text-sm font-bold text-white mb-4"><i class="fa-solid fa-bolt mr-2 text-indigo-400"></i>Aksi Cepat CMS</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('cms.events.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-white/10 hover:border-white/15 transition-all text-center group cursor-pointer">
                <i class="fa-solid fa-circle-plus text-indigo-400 text-xl mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-semibold text-gray-200">Buat Event</span>
            </a>
            <a href="{{ route('cms.events.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-white/10 hover:border-white/15 transition-all text-center group cursor-pointer">
                <i class="fa-solid fa-calendar-days text-indigo-400 text-xl mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-semibold text-gray-200">Kelola Event</span>
            </a>
            <a href="{{ route('home') }}" target="_blank" class="flex flex-col items-center justify-center p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-white/10 hover:border-white/15 transition-all text-center group cursor-pointer">
                <i class="fa-solid fa-eye text-indigo-400 text-xl mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-semibold text-gray-200">Preview Web</span>
            </a>
            <a href="#system" class="flex flex-col items-center justify-center p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-white/10 hover:border-white/15 transition-all text-center group cursor-pointer">
                <i class="fa-solid fa-server text-indigo-400 text-xl mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-semibold text-gray-200">Info Server</span>
            </a>
        </div>
    </div>

    <!-- Data Tables Panel Split -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Left Table: Recent Events -->
        <div class="glass-card rounded-2xl border border-white/5 overflow-hidden shadow-xl">
            <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-sm font-bold text-white"><i class="fa-solid fa-calendar-days text-violet-400 mr-2"></i>Event Terbaru</h3>
                <a href="{{ route('cms.events.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold">Semua Event &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-gray-400 uppercase bg-white/5 border-b border-white/5 font-semibold">
                        <tr>
                            <th class="px-6 py-4">Judul Event</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($recentEvents as $event)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('cms.events.show', $event->id) }}" class="font-semibold text-white hover:text-indigo-400 block transition-colors">
                                        {{ $event->title }}
                                    </a>
                                    <span class="text-[10px] text-gray-500 block mt-0.5">Dibuat {{ $event->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($event->voting_type === 'public_email')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">EMAIL</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-500/10 text-purple-400 border border-purple-500/20">TOKEN</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($event->status === 'active')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-green-500/10 text-green-400 border border-green-500/20">AKTIF</span>
                                    @elseif($event->status === 'draft')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-500/10 text-gray-400 border border-gray-500/20">DRAFT</span>
                                    @elseif($event->status === 'paused')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">PAUSED</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-red-500/10 text-red-400 border border-red-500/20">CLOSED</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada event terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Table: Recent Vote Feed -->
        <div class="glass-card rounded-2xl border border-white/5 overflow-hidden shadow-xl">
            <div class="px-6 py-5 border-b border-white/5">
                <h3 class="text-sm font-bold text-white"><i class="fa-solid fa-clock-rotate-left text-emerald-400 mr-2"></i>Aktivitas Suara Terbaru</h3>
            </div>
            
            <div class="divide-y divide-white/5 overflow-y-auto max-h-[350px]">
                @forelse($recentVotes as $vote)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-white">
                                Voter memilih <span class="text-indigo-400 font-bold">#{{ $vote->candidate->candidate_number }} {{ $vote->candidate->name }}</span>
                            </p>
                            <p class="text-[10px] text-gray-500">
                                Event: {{ $vote->event->title }}
                            </p>
                        </div>
                        <div class="text-right flex flex-col items-end space-y-1">
                            <span class="text-[10px] font-semibold text-gray-400 bg-white/5 py-1 px-2 rounded-md">ID: {{ substr($vote->voter_identifier, 0, 7) }}...</span>
                            <span class="text-[9px] text-gray-500">{{ $vote->voted_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">Belum ada suara masuk.</div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Server & Technology Panel -->
    <div id="system" class="glass-card rounded-2xl p-6 border border-white/5">
        <h3 class="text-sm font-bold text-white mb-4"><i class="fa-solid fa-microchip mr-2 text-indigo-400"></i>Informasi Sistem</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-xs text-gray-400">
            <div class="space-y-1">
                <p class="font-bold text-gray-500 uppercase tracking-wide">Kernel Framework</p>
                <p class="text-sm text-gray-200">Laravel v{{ app()->version() }}</p>
            </div>
            <div class="space-y-1">
                <p class="font-bold text-gray-500 uppercase tracking-wide">Environment Server</p>
                <p class="text-sm text-gray-200">PHP v{{ PHP_VERSION }}</p>
            </div>
            <div class="space-y-1">
                <p class="font-bold text-gray-500 uppercase tracking-wide">Tipe Database</p>
                <p class="text-sm text-gray-200">SQLite (Ukuran: <span class="font-bold text-white">{{ $dbSize }}</span>)</p>
            </div>
        </div>
    </div>

</div>
@endsection
