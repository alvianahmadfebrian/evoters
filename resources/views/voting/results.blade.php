@extends('layouts.app')

@section('title', 'Hasil Voting: ' . $event->title . ' - eVoters')

@section('content')
<div class="space-y-8 animate-fade-in pb-12">
    <!-- Breadcrumb & Top Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center space-x-2 text-xs text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <span>&rarr;</span>
            <a href="{{ route('event.show', $event->slug) }}" class="hover:text-white transition-colors">{{ $event->title }}</a>
            <span>&rarr;</span>
            <span class="text-indigo-400 font-semibold">Hasil Voting</span>
        </div>

        <div class="flex items-center space-x-2.5">
            <!-- Auto-refresh Toggle -->
            <button id="auto-refresh-btn" onclick="toggleAutoRefresh()" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-white/5 hover:bg-white/10 text-gray-300 border border-white/10 flex items-center space-x-1.5 transition-all cursor-pointer">
                <span id="refresh-dot" class="w-2 h-2 rounded-full bg-emerald-400 animate-ping inline-block mr-0.5"></span>
                <span id="refresh-label">Live Sync: 15s</span>
            </button>

            <!-- Manual Refresh -->
            <button onclick="window.location.reload()" title="Muat Ulang Data" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white border border-white/10 flex items-center justify-center transition-all cursor-pointer">
                <i class="fa-solid fa-rotate-right text-xs"></i>
            </button>

            <!-- Share Button -->
            <button onclick="copyShareLink()" title="Bagikan Hasil" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-300 border border-indigo-500/30 flex items-center space-x-1.5 transition-all cursor-pointer">
                <i class="fa-solid fa-share-nodes text-xs"></i>
                <span>Bagikan</span>
            </button>
        </div>
    </div>

    <!-- Error/Notice Block (If results are restricted) -->
    @if(isset($error))
        <div class="glass-card rounded-3xl p-8 md:p-12 text-center border border-white/10 space-y-6 max-w-2xl mx-auto shadow-2xl relative overflow-hidden bg-slate-900/60 backdrop-blur-xl">
            <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-full flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="space-y-2">
                <h2 class="text-xl font-bold text-white">Hasil Voting Dikunci</h2>
                <p class="text-sm text-gray-400 leading-relaxed font-medium">{{ $error }}</p>
            </div>
            <div class="pt-4 flex justify-center space-x-4">
                <a href="{{ route('event.show', $event->slug) }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs py-3 px-6 rounded-xl transition-all cursor-pointer shadow-lg shadow-indigo-600/20">
                    <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Ballot
                </a>
                <a href="{{ route('home') }}" class="bg-white/5 hover:bg-white/10 text-gray-300 border border-white/10 font-semibold text-xs py-3 px-6 rounded-xl transition-all">
                    Lihat Event Lain
                </a>
            </div>
        </div>
    @else
        <!-- Results Page Header Banner -->
        <div class="relative overflow-hidden rounded-3xl p-6 md:p-10 border border-white/10 bg-gradient-to-r from-slate-900 via-indigo-950/40 to-slate-900 shadow-2xl backdrop-blur-xl">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-500/15 border border-emerald-500/30 text-emerald-400">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse mr-1.5"></span>
                            Live Real-Time Leaderboard
                        </span>
                        @if($event->price > 0)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-500/10 border border-amber-500/25 text-amber-300">
                                <i class="fa-solid fa-coins text-[10px] mr-1.5"></i> Paid Voting (Rp {{ number_format($event->price, 0, ',', '.') }}/suara)
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-500/10 border border-blue-500/25 text-blue-300">
                                <i class="fa-solid fa-shield-halved text-[10px] mr-1.5"></i> Voting Gratis & Terverifikasi
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl md:text-4xl font-extrabold text-white tracking-tight leading-tight">
                        {{ $event->title }}
                    </h1>
                    <p class="text-xs md:text-sm text-gray-400 line-clamp-2 leading-relaxed">
                        {{ $event->description ?: 'Hasil perolehan suara resmi yang diperbarui secara langsung setiap kali ada dukungan suara baru masuk.' }}
                    </p>
                </div>

                <!-- CTA Action -->
                <div class="flex-shrink-0 flex flex-col sm:flex-row md:flex-col gap-2.5">
                    @if($event->isOpen())
                        <a href="{{ route('event.show', $event->slug) }}" class="inline-flex items-center justify-center px-6 py-3.5 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold text-xs shadow-lg shadow-indigo-600/30 hover:scale-[1.02] transition-all cursor-pointer text-center">
                            <i class="fa-solid fa-check-to-slot mr-2 text-sm"></i> Berikan Suara Sekarang
                        </a>
                    @else
                        <span class="inline-flex items-center justify-center px-6 py-3.5 rounded-2xl bg-white/5 border border-white/10 text-gray-400 font-bold text-xs text-center">
                            <i class="fa-solid fa-lock mr-2"></i> Voting Telah Berakhir
                        </span>
                    @endif
                </div>
            </div>
        </div>

        @php
            $leader = $candidates->first();
            $leaderVotes = $leader ? ($leader->votes_sum_quantity ?? 0) : 0;
            $leaderPercent = $totalVotes > 0 ? round(($leaderVotes / $totalVotes) * 100, 1) : 0;
        @endphp

        <!-- Key Stats Overview Row (4 KPI Cards) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <!-- Total Suara -->
            <div class="glass-card rounded-3xl p-5 md:p-6 border border-white/10 shadow-xl bg-slate-900/50 backdrop-blur-xl relative overflow-hidden group hover:border-indigo-500/40 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-gray-400">Total Suara Masuk</span>
                    <div class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-sm border border-indigo-500/20">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                </div>
                <div class="text-2xl md:text-3xl font-black text-white tracking-tight">
                    {{ number_format($totalVotes) }}
                </div>
                <span class="text-[11px] text-gray-500 mt-1 block">Suara tervalidasi</span>
            </div>

            <!-- Total Partisipan / Transaksi -->
            <div class="glass-card rounded-3xl p-5 md:p-6 border border-white/10 shadow-xl bg-slate-900/50 backdrop-blur-xl relative overflow-hidden group hover:border-emerald-500/40 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-gray-400">Total Partisipan</span>
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm border border-emerald-500/20">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="text-2xl md:text-3xl font-black text-white tracking-tight">
                    {{ number_format($totalVoters) }}
                </div>
                <span class="text-[11px] text-gray-500 mt-1 block">Aktivitas vote terdaftar</span>
            </div>

            <!-- Pemimpin Suara / Rank 1 -->
            <div class="glass-card rounded-3xl p-5 md:p-6 border border-amber-500/20 shadow-xl bg-gradient-to-br from-slate-900/60 via-amber-950/20 to-slate-900/60 backdrop-blur-xl relative overflow-hidden group hover:border-amber-500/40 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-amber-400 flex items-center">
                        <i class="fa-solid fa-crown mr-1.5 text-amber-400"></i> Pemimpin Suara
                    </span>
                    <span class="text-[11px] font-extrabold text-amber-300 bg-amber-500/10 px-2 py-0.5 rounded-lg border border-amber-500/20">
                        {{ $leaderPercent }}%
                    </span>
                </div>
                <div class="text-base md:text-lg font-black text-white truncate">
                    {{ $leader ? $leader->name : '-' }}
                </div>
                <span class="text-[11px] text-gray-400 mt-1 block">
                    {{ number_format($leaderVotes) }} suara terkumpul
                </span>
            </div>

            <!-- Status Pemilihan -->
            <div class="glass-card rounded-3xl p-5 md:p-6 border border-white/10 shadow-xl bg-slate-900/50 backdrop-blur-xl relative overflow-hidden group hover:border-violet-500/40 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-gray-400">Status Voting</span>
                    <div class="w-8 h-8 rounded-xl bg-violet-500/10 text-violet-400 flex items-center justify-center text-sm border border-violet-500/20">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
                <div class="text-base md:text-lg font-black text-white">
                    @if($event->status === 'active')
                        <span class="text-emerald-400 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping mr-2"></span> Berlangsung
                        </span>
                    @elseif($event->status === 'closed')
                        <span class="text-rose-400">Selesai</span>
                    @else
                        <span class="text-gray-400">Draft</span>
                    @endif
                </div>
                <span class="text-[11px] text-gray-500 mt-1 block truncate">
                    @if($event->end_time)
                        Berakhir: {{ $event->end_time->format('d M Y H:i') }}
                    @else
                        Batas waktu fleksibel
                    @endif
                </span>
            </div>
        </div>

        <!-- Candidate Podium / Leaderboard Showcase (Grid with Photos) -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg md:text-xl font-extrabold text-white flex items-center">
                        <i class="fa-solid fa-ranking-star mr-2 text-amber-400"></i> Klasemen & Perolehan Kandidat
                    </h2>
                    <p class="text-xs text-gray-400">Daftar kandidat diurutkan berdasarkan perolehan suara terbanyak saat ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($candidates as $index => $candidate)
                    @php
                        $votes = $candidate->votes_sum_quantity ?? 0;
                        $pct = $totalVotes > 0 ? round(($votes / $totalVotes) * 100, 1) : 0;
                        $rank = $index + 1;
                        $isWinner = $rank === 1 && $votes > 0;
                    @endphp

                    <div class="glass-card rounded-3xl overflow-hidden border {{ $isWinner ? 'border-amber-500/40 bg-gradient-to-b from-amber-500/5 via-slate-900/60 to-slate-900/90 shadow-amber-500/10' : 'border-white/10 bg-slate-900/60' }} shadow-2xl flex flex-col justify-between group hover:border-indigo-500/50 transition-all duration-300 relative">
                        
                        <!-- Top Header with Photo & Badges -->
                        <div class="relative h-64 w-full bg-slate-950 overflow-hidden flex-shrink-0">
                            @if($candidate->photo)
                                <img src="{{ asset($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-slate-900 via-indigo-950 to-slate-900 flex flex-col items-center justify-center text-gray-600">
                                    <i class="fa-solid fa-user text-6xl mb-2 opacity-40"></i>
                                    <span class="text-[11px] text-gray-500 font-medium">Foto Belum Tersedia</span>
                                </div>
                            @endif

                            <!-- Dark Overlay Gradient for text readability -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>

                            <!-- Rank Badge (Top Left) -->
                            <div class="absolute top-4 left-4 flex items-center space-x-2">
                                @if($rank === 1)
                                    <div class="px-3 py-1 rounded-xl bg-gradient-to-r from-amber-500 to-yellow-400 text-slate-950 font-black text-xs shadow-lg flex items-center space-x-1 border border-yellow-300/40">
                                        <i class="fa-solid fa-crown text-[10px]"></i>
                                        <span>PERINGKAT #1</span>
                                    </div>
                                @elseif($rank === 2)
                                    <div class="px-3 py-1 rounded-xl bg-gradient-to-r from-slate-300 to-slate-400 text-slate-950 font-black text-xs shadow-lg flex items-center space-x-1 border border-white/40">
                                        <i class="fa-solid fa-medal text-[10px]"></i>
                                        <span>PERINGKAT #2</span>
                                    </div>
                                @elseif($rank === 3)
                                    <div class="px-3 py-1 rounded-xl bg-gradient-to-r from-amber-700 to-amber-600 text-white font-black text-xs shadow-lg flex items-center space-x-1 border border-amber-400/40">
                                        <i class="fa-solid fa-award text-[10px]"></i>
                                        <span>PERINGKAT #3</span>
                                    </div>
                                @else
                                    <div class="px-2.5 py-1 rounded-xl bg-slate-900/80 backdrop-blur-md text-gray-300 font-bold text-xs border border-white/10">
                                        <span>POSISI #{{ $rank }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Ballot Number Badge (Top Right) -->
                            <div class="absolute top-4 right-4">
                                <div class="w-10 h-10 rounded-2xl bg-indigo-600/90 backdrop-blur-md border border-indigo-400/50 font-black text-white text-base flex items-center justify-center shadow-xl">
                                    {{ sprintf("%02d", $candidate->candidate_number) }}
                                </div>
                            </div>

                            <!-- Candidate Name overlay at bottom of photo -->
                            <div class="absolute bottom-4 left-4 right-4 space-y-1">
                                <span class="text-[10px] text-indigo-300 font-bold uppercase tracking-wider block">Kandidat No. {{ sprintf("%02d", $candidate->candidate_number) }}</span>
                                <h3 class="text-xl font-black text-white drop-shadow-md truncate">{{ $candidate->name }}</h3>
                            </div>
                        </div>

                        <!-- Card Body: Progress & Stats -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-5 bg-slate-900/80">
                            <!-- Votes & Percentage Highlight Box -->
                            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-gray-400 font-semibold uppercase block">Perolehan Suara</span>
                                        <div class="text-2xl font-black text-white flex items-baseline space-x-1">
                                            <span>{{ number_format($votes) }}</span>
                                            <span class="text-xs text-gray-400 font-semibold">Suara</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] text-gray-400 font-semibold uppercase block">Persentase</span>
                                        <div class="text-2xl font-black text-indigo-400">
                                            {{ $pct }}%
                                        </div>
                                    </div>
                                </div>

                                <!-- Animated Progress Bar -->
                                <div class="w-full bg-white/5 rounded-full h-3 overflow-hidden border border-white/5 relative p-0.5">
                                    <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $isWinner ? 'bg-gradient-to-r from-amber-500 via-yellow-400 to-indigo-500' : 'bg-gradient-to-r from-indigo-600 to-violet-500' }}" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>

                            <!-- Candidate Description / Vision snippet -->
                            @if($candidate->description)
                                <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed">
                                    {{ Str::limit(strip_tags($candidate->description), 120) }}
                                </p>
                            @endif

                            <!-- Card Action Button -->
                            @if($event->isOpen())
                                <a href="{{ route('event.show', $event->slug) }}" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-center transition-all flex items-center justify-center space-x-2 {{ $isWinner ? 'bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold shadow-lg shadow-amber-500/20' : 'bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-300 border border-indigo-500/30 hover:border-indigo-400' }}">
                                    <i class="fa-solid fa-vote-yea text-xs"></i>
                                    <span>Vote No. {{ sprintf("%02d", $candidate->candidate_number) }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section Grid: Left (Chart Visuals) & Right (Top Supporters / Leaderboard) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Visualisasi Data (Chart.js) -->
            <div class="lg:col-span-2 glass-card p-6 md:p-8 rounded-3xl border border-white/10 shadow-2xl space-y-6 bg-slate-900/60 backdrop-blur-xl flex flex-col justify-between">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-white/5 pb-4">
                    <div>
                        <h3 class="text-base font-extrabold text-white flex items-center">
                            <i class="fa-solid fa-chart-simple mr-2 text-indigo-400"></i> Perbandingan Suara Antar Kandidat
                        </h3>
                        <p class="text-xs text-gray-400">Diagram perbandingan distribusi suara secara keseluruhan.</p>
                    </div>
                    <span class="text-[11px] font-semibold text-gray-400 bg-white/5 px-3 py-1 rounded-xl border border-white/5 self-start">
                        Total {{ number_format($totalVotes) }} Suara
                    </span>
                </div>

                <div class="relative h-72 md:h-84 w-full flex items-center justify-center py-2">
                    <canvas id="resultsChart"></canvas>
                </div>

                <div class="pt-4 border-t border-white/5 text-[11px] text-gray-500 flex items-center justify-between">
                    <span>* Diperbarui secara otomatis saat transaksi pembayaran selesai.</span>
                    <span class="text-indigo-400 font-semibold">100% Terverifikasi</span>
                </div>
            </div>

            <!-- Right: Top Contributors / Sultan Voting -->
            <div class="glass-card p-6 md:p-8 rounded-3xl border border-white/10 shadow-2xl space-y-6 bg-slate-900/60 backdrop-blur-xl flex flex-col justify-between">
                <div class="border-b border-white/5 pb-4">
                    <h3 class="text-base font-extrabold text-white flex items-center">
                        <i class="fa-solid fa-fire mr-2 text-amber-400"></i> Top Pendukung Terbanyak
                    </h3>
                    <p class="text-xs text-gray-400">Voter dengan kontribusi suara terbesar.</p>
                </div>

                <!-- Top Voters List -->
                <div class="space-y-3 flex-grow">
                    @forelse($topVoters as $idx => $voter)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] hover:bg-white/[0.06] border border-white/5 transition-all">
                            <div class="flex items-center space-x-3 min-w-0">
                                <!-- Rank Medal / Number -->
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs flex-shrink-0 {{ $idx === 0 ? 'bg-amber-500 text-slate-950 shadow-md shadow-amber-500/20' : ($idx === 1 ? 'bg-slate-300 text-slate-950' : ($idx === 2 ? 'bg-amber-700 text-white' : 'bg-white/5 text-gray-400')) }}">
                                    @if($idx === 0)
                                        <i class="fa-solid fa-crown text-[10px]"></i>
                                    @else
                                        {{ $idx + 1 }}
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-white truncate">
                                        {{ $voter->voter_display_name ?: 'Pendukung Anonim' }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 truncate flex items-center space-x-1">
                                        <span>Untuk:</span>
                                        <span class="text-indigo-300 font-semibold">{{ $voter->candidate ? $voter->candidate->name : '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right flex-shrink-0 ml-2">
                                <span class="px-2.5 py-1 rounded-xl text-xs font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    +{{ number_format($voter->total_qty) }} Suara
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 space-y-2">
                            <i class="fa-solid fa-users text-3xl opacity-30"></i>
                            <p class="text-xs">Belum ada data pendukung yang tercatat.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Info note -->
                <div class="p-3 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-[11px] text-indigo-300 flex items-center space-x-2">
                    <i class="fa-solid fa-circle-info text-indigo-400"></i>
                    <span>Setiap suara Anda langsung membantu posisi kandidat naik di klasemen!</span>
                </div>
            </div>
        </div>

        <!-- Recent Voter Activity Feed ("Riwayat & Nama-Nama yang Vote") -->
        <div class="glass-card rounded-3xl border border-white/10 p-6 md:p-8 space-y-6 shadow-2xl bg-slate-900/60 backdrop-blur-xl">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-white/5 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-white flex items-center">
                        <i class="fa-solid fa-bolt mr-2 text-indigo-400"></i> Riwayat Dukungan Suara Terkini
                    </h3>
                    <p class="text-xs text-gray-400">Daftar voter yang baru saja memberikan suara secara real-time.</p>
                </div>
                <span class="text-[11px] text-gray-400 flex items-center self-start">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse mr-1.5"></span>
                    Menampilkan 15 transaksi terakhir
                </span>
            </div>

            @if($recentVotes->isEmpty())
                <div class="text-center py-12 text-gray-500 space-y-3">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center mx-auto text-gray-400 text-2xl border border-white/5">
                        <i class="fa-regular fa-paper-plane"></i>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-white">Belum Ada Suara yang Masuk</p>
                        <p class="text-xs text-gray-400">Jadilah pendukung pertama yang memberikan suara untuk kandidat favorit Anda!</p>
                    </div>
                    @if($event->isOpen())
                        <div class="pt-2">
                            <a href="{{ route('event.show', $event->slug) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-all shadow-md shadow-indigo-600/20">
                                Berikan Suara Pertama
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="divide-y divide-white/5">
                    @foreach($recentVotes as $vote)
                        <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-white/[0.02] px-2 rounded-2xl transition-colors">
                            <div class="flex items-center space-x-3.5 min-w-0">
                                <!-- Avatar initial -->
                                @php
                                    $displayName = $vote->voter_name ?: 'Voter #' . substr($vote->voter_identifier, 0, 6);
                                    $initial = strtoupper(substr($displayName, 0, 1));
                                @endphp
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white font-black text-sm flex items-center justify-center flex-shrink-0 shadow-md">
                                    {{ $initial }}
                                </div>

                                <div class="min-w-0">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-bold text-white text-sm truncate">{{ $displayName }}</span>
                                        <span class="text-[10px] px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-400 font-semibold border border-emerald-500/20 flex-shrink-0">
                                            <i class="fa-solid fa-check text-[8px] mr-1"></i> Terverifikasi
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-400 flex flex-wrap items-center gap-1.5 mt-0.5">
                                        <span>memberikan dukungan untuk</span>
                                        @if($vote->candidate)
                                            <span class="font-semibold text-indigo-300">
                                                No. {{ sprintf("%02d", $vote->candidate->candidate_number) }} - {{ $vote->candidate->name }}
                                            </span>
                                        @else
                                            <span class="font-semibold text-gray-400">Kandidat</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end space-x-4 flex-shrink-0">
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-xl text-xs font-black bg-gradient-to-r from-indigo-500/20 to-violet-500/20 text-indigo-300 border border-indigo-500/30 inline-block shadow-sm">
                                        +{{ number_format($vote->quantity) }} Suara
                                    </span>
                                </div>
                                <span class="text-[11px] text-gray-500 whitespace-nowrap">
                                    <i class="fa-regular fa-clock mr-1 text-[10px]"></i>
                                    {{ $vote->voted_at ? $vote->voted_at->diffForHumans() : $vote->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Toast notification for copy link -->
<div id="copy-toast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
    <div class="bg-slate-900 border border-emerald-500/40 text-white px-5 py-3 rounded-2xl shadow-2xl flex items-center space-x-3">
        <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs">
            <i class="fa-solid fa-check"></i>
        </div>
        <span class="text-xs font-semibold">Tautan hasil voting berhasil disalin!</span>
    </div>
</div>
@endsection

@section('scripts')
@if(!isset($error) && $candidates->isNotEmpty())
    <!-- Load Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('resultsChart').getContext('2d');
            
            const labels = [@foreach($candidates as $c) "No. {{ sprintf('%02d', $c->candidate_number) }} {{ $c->name }}", @endforeach];
            const data = [@foreach($candidates as $c) {{ $c->votes_sum_quantity ?? 0 }}, @endforeach];
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Perolehan Suara',
                        data: data,
                        backgroundColor: [
                            'rgba(99, 102, 241, 0.7)',   // Indigo
                            'rgba(168, 85, 247, 0.7)',   // Purple
                            'rgba(236, 72, 153, 0.7)',   // Pink
                            'rgba(20, 184, 166, 0.7)',   // Teal
                            'rgba(245, 158, 11, 0.7)',   // Amber
                            'rgba(59, 130, 246, 0.7)'    // Blue
                        ],
                        borderColor: [
                            'rgb(129, 140, 248)',
                            'rgb(192, 132, 252)',
                            'rgb(244, 114, 182)',
                            'rgb(45, 212, 191)',
                            'rgb(251, 191, 36)',
                            'rgb(96, 165, 250)'
                        ],
                        borderWidth: 1.5,
                        borderRadius: 12,
                        hoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#e2e8f0',
                            borderColor: 'rgba(99, 102, 241, 0.3)',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ` Total: ${context.parsed.x.toLocaleString()} suara`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                color: 'rgba(148, 163, 184, 0.8)',
                                font: {
                                    size: 11,
                                    family: 'Inter, system-ui, sans-serif'
                                },
                                stepSize: 1
                            }
                        },
                        y: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#ffffff',
                                font: {
                                    size: 12,
                                    weight: 'bold',
                                    family: 'Inter, system-ui, sans-serif'
                                }
                            }
                        }
                    }
                }
            });
        });

        // Auto-refresh logic
        let autoRefreshInterval = null;
        let refreshSeconds = 15;
        let isRefreshing = true;

        function startAutoRefresh() {
            autoRefreshInterval = setInterval(() => {
                window.location.reload();
            }, refreshSeconds * 1000);
        }

        function toggleAutoRefresh() {
            const dot = document.getElementById('refresh-dot');
            const label = document.getElementById('refresh-label');
            if (isRefreshing) {
                clearInterval(autoRefreshInterval);
                isRefreshing = false;
                dot.classList.remove('animate-ping', 'bg-emerald-400');
                dot.classList.add('bg-gray-500');
                label.innerText = 'Live Sync: Off';
            } else {
                startAutoRefresh();
                isRefreshing = true;
                dot.classList.remove('bg-gray-500');
                dot.classList.add('animate-ping', 'bg-emerald-400');
                label.innerText = 'Live Sync: 15s';
            }
        }

        startAutoRefresh();

        // Copy Share Link
        function copyShareLink() {
            const url = window.location.href;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    showToast();
                });
            } else {
                const temp = document.createElement('input');
                document.body.appendChild(temp);
                temp.value = url;
                temp.select();
                document.execCommand('copy');
                document.body.removeChild(temp);
                showToast();
            }
        }

        function showToast() {
            const toast = document.getElementById('copy-toast');
            if (toast) {
                toast.classList.remove('translate-y-20', 'opacity-0');
                setTimeout(() => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3000);
            }
        }
    </script>
@endif
@endsection
