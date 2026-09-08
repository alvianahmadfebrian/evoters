@extends('layouts.app')

@section('title', 'Hasil Voting: ' . $event->title . ' - eVoters')

@section('content')
<div class="space-y-8 animate-fade-in pb-12">
    <!-- Breadcrumb & Top Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center space-x-2 text-xs text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-[#ba7c21] transition-colors">Beranda</a>
            <span>&rarr;</span>
            <a href="{{ route('event.show', $event->slug) }}" class="hover:text-[#ba7c21] transition-colors line-clamp-1 max-w-[200px]">{{ $event->title }}</a>
            <span>&rarr;</span>
            <span class="font-bold text-[#ba7c21]">Hasil Voting</span>
        </div>

        <div class="flex items-center space-x-2.5">
            <!-- Auto-refresh Toggle -->
            <button id="auto-refresh-btn" onclick="toggleAutoRefresh()" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 shadow-sm flex items-center space-x-2 hover:bg-slate-50 transition-all cursor-pointer">
                <span id="refresh-dot" class="w-2 h-2 rounded-full animate-ping inline-block" style="background: #ba7c21;"></span>
                <span id="refresh-label">Live Sync: 15s</span>
            </button>

            <!-- Manual Refresh -->
            <button onclick="window.location.reload()" title="Muat Ulang Data" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-[#ba7c21] shadow-sm flex items-center justify-center transition-all cursor-pointer">
                <i class="fa-solid fa-rotate-right text-xs"></i>
            </button>

            <!-- Share Button -->
            <button onclick="copyShareLink()" title="Bagikan Hasil" class="px-4 py-2 rounded-xl text-xs font-bold text-white shadow-sm flex items-center space-x-1.5 transition-all cursor-pointer hover:opacity-90" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                <i class="fa-solid fa-share-nodes text-xs"></i>
                <span>Bagikan</span>
            </button>
        </div>
    </div>

    <!-- Error/Notice Block (If results are restricted) -->
    @if(isset($error))
        <div class="rounded-3xl p-8 md:p-12 text-center border border-slate-200 bg-white space-y-6 max-w-2xl mx-auto shadow-sm relative overflow-hidden">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto text-2xl" style="background: #fcf5e2; color: #ba7c21;">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="space-y-2">
                <h2 class="text-xl font-bold text-slate-900">Hasil Voting Dikunci</h2>
                <p class="text-sm text-slate-600 leading-relaxed font-medium">{{ $error }}</p>
            </div>
            <div class="pt-4 flex justify-center space-x-4">
                <a href="{{ route('event.show', $event->slug) }}" class="text-white font-bold text-xs py-3 px-6 rounded-xl transition-all cursor-pointer shadow-md" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                    <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Ballot
                </a>
                <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs py-3 px-6 rounded-xl transition-all">
                    Lihat Event Lain
                </a>
            </div>
        </div>
    @else
        <!-- Results Page Header Banner -->
        <div class="relative overflow-hidden rounded-3xl p-6 md:p-10 border border-slate-200/80 bg-white shadow-sm">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-[#ba7c21]/[0.06] rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-[#9b5f1a]/[0.05] rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold shadow-sm" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
                            <span class="w-2 h-2 rounded-full animate-pulse mr-1.5" style="background: #ba7c21;"></span>
                            Live Real-Time Leaderboard
                        </span>
                        @if($event->price > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-slate-900 text-white shadow-sm">
                                <i class="fa-solid fa-coins text-[10px] mr-1.5 text-[#ba7c21]"></i> Paid Voting (Rp {{ number_format($event->price, 0, ',', '.') }}/suara)
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                                <i class="fa-solid fa-shield-halved text-[10px] mr-1.5"></i> Voting Gratis & Terverifikasi
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ $event->title }}
                    </h1>
                    <p class="text-xs md:text-sm text-slate-600 line-clamp-2 leading-relaxed">
                        {{ $event->description ?: 'Hasil perolehan suara resmi yang diperbarui secara langsung setiap kali ada dukungan suara baru masuk.' }}
                    </p>
                </div>

                <!-- CTA Action -->
                <div class="flex-shrink-0 flex flex-col sm:flex-row md:flex-col gap-2.5">
                    @if($event->isOpen())
                        <a href="{{ route('event.show', $event->slug) }}" class="inline-flex items-center justify-center px-6 py-3.5 rounded-2xl text-white font-bold text-xs shadow-md hover:opacity-95 transition-all cursor-pointer text-center" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                            <i class="fa-solid fa-check-to-slot mr-2 text-sm"></i> Berikan Suara Sekarang
                        </a>
                    @else
                        <span class="inline-flex items-center justify-center px-6 py-3.5 rounded-2xl bg-slate-100 border border-slate-200 text-slate-500 font-bold text-xs text-center">
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
            <div class="rounded-3xl p-5 md:p-6 border border-slate-200/80 shadow-sm bg-white relative overflow-hidden transition-all hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-slate-500">Total Suara Masuk</span>
                    <div class="w-9 h-9 rounded-2xl flex items-center justify-center text-sm shadow-sm" style="background: #fcf5e2; color: #ba7c21;">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                </div>
                <div class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight" style="color: #ba7c21;">
                    {{ number_format($totalVotes) }}
                </div>
                <span class="text-[11px] text-slate-400 mt-1 block font-medium">Suara tervalidasi</span>
            </div>

            <!-- Total Partisipan / Transaksi -->
            <div class="rounded-3xl p-5 md:p-6 border border-slate-200/80 shadow-sm bg-white relative overflow-hidden transition-all hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-slate-500">Total Partisipan</span>
                    <div class="w-9 h-9 rounded-2xl flex items-center justify-center text-sm shadow-sm" style="background: #fcf5e2; color: #ba7c21;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                    {{ number_format($totalVoters) }}
                </div>
                <span class="text-[11px] text-slate-400 mt-1 block font-medium">Aktivitas vote terdaftar</span>
            </div>

            <!-- Pemimpin Suara / Rank 1 -->
            <div class="rounded-3xl p-5 md:p-6 border border-amber-200 shadow-sm bg-gradient-to-br from-amber-50/40 via-white to-amber-50/20 relative overflow-hidden transition-all hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-[#9b5f1a] flex items-center">
                        <i class="fa-solid fa-crown mr-1.5 text-[#ba7c21]"></i> Pemimpin Suara
                    </span>
                    <span class="text-[11px] font-black px-2 py-0.5 rounded-lg border shadow-sm" style="background: #fcf5e2; border-color: #f7e6bb; color: #9b5f1a;">
                        {{ $leaderPercent }}%
                    </span>
                </div>
                <div class="text-base md:text-lg font-black text-slate-900 truncate">
                    {{ $leader ? $leader->name : '-' }}
                </div>
                <span class="text-[11px] text-slate-500 mt-1 block font-medium">
                    {{ number_format($leaderVotes) }} suara terkumpul
                </span>
            </div>

            <!-- Status Pemilihan -->
            <div class="rounded-3xl p-5 md:p-6 border border-slate-200/80 shadow-sm bg-white relative overflow-hidden transition-all hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-slate-500">Status Voting</span>
                    <div class="w-9 h-9 rounded-2xl bg-slate-50 border border-slate-200 text-slate-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
                <div class="text-base md:text-lg font-black text-slate-900">
                    @if($event->status === 'active')
                        <span class="flex items-center font-extrabold" style="color: #ba7c21;">
                            <span class="w-2 h-2 rounded-full animate-ping mr-2" style="background: #ba7c21;"></span> Berlangsung
                        </span>
                    @elseif($event->status === 'closed')
                        <span class="text-rose-600 font-extrabold">Selesai</span>
                    @else
                        <span class="text-slate-500 font-extrabold">Draft</span>
                    @endif
                </div>
                <span class="text-[11px] text-slate-400 mt-1 block truncate font-medium">
                    @if($event->end_time)
                        Berakhir: {{ $event->end_time->format('d M Y H:i') }}
                    @else
                        Batas waktu fleksibel
                    @endif
                </span>
            </div>
        </div>

        <!-- Candidate Podium / Leaderboard Showcase (Grid with Photos) -->
        <div class="space-y-4 pt-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl md:text-2xl font-extrabold text-slate-900 flex items-center">
                        <i class="fa-solid fa-ranking-star mr-2 text-[#ba7c21]"></i> Klasemen & Perolehan Kandidat
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar kandidat diurutkan berdasarkan perolehan suara terbanyak saat ini.</p>
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

                    <div class="rounded-3xl overflow-hidden border border-slate-200/80 bg-white shadow-sm flex flex-col justify-between group hover:-translate-y-1 hover:shadow-xl transition-all duration-300 relative">
                        
                        <!-- Top Header with Photo & Badges -->
                        <div class="relative h-60 w-full bg-slate-100 overflow-hidden flex-shrink-0">
                            @if($candidate->photo)
                                <img src="{{ asset($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-amber-50 to-slate-100 flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-user text-5xl mb-2 opacity-50 text-[#ba7c21]"></i>
                                    <span class="text-[11px] text-slate-400 font-medium">Foto Belum Tersedia</span>
                                </div>
                            @endif

                            <!-- Rank Badge (Top Left) -->
                            <div class="absolute top-3.5 left-3.5 flex items-center space-x-2">
                                @if($rank === 1)
                                    <div class="px-3 py-1 rounded-xl text-white font-extrabold text-xs shadow-md flex items-center space-x-1" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                                        <i class="fa-solid fa-crown text-[10px]"></i>
                                        <span>PERINGKAT #1</span>
                                    </div>
                                @elseif($rank === 2)
                                    <div class="px-3 py-1 rounded-xl bg-slate-800/90 backdrop-blur-md text-white font-extrabold text-xs shadow-md flex items-center space-x-1">
                                        <i class="fa-solid fa-medal text-[10px] text-slate-300"></i>
                                        <span>PERINGKAT #2</span>
                                    </div>
                                @elseif($rank === 3)
                                    <div class="px-3 py-1 rounded-xl bg-amber-900/90 backdrop-blur-md text-amber-200 font-extrabold text-xs shadow-md flex items-center space-x-1">
                                        <i class="fa-solid fa-award text-[10px]"></i>
                                        <span>PERINGKAT #3</span>
                                    </div>
                                @else
                                    <div class="px-2.5 py-1 rounded-xl bg-slate-900/80 backdrop-blur-md text-white font-bold text-xs">
                                        <span>POSISI #{{ $rank }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Ballot Number Badge (Top Right) -->
                            <div class="absolute top-3.5 right-3.5">
                                <div class="w-9 h-9 rounded-xl font-black text-white text-sm flex items-center justify-center shadow-lg" style="background: #0f172a;">
                                    {{ sprintf("%02d", $candidate->candidate_number) }}
                                </div>
                            </div>
                        </div>

                        <!-- Card Body: Progress & Stats -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <!-- Candidate Name & Number -->
                            <div class="space-y-1">
                                <span class="text-[11px] font-extrabold tracking-wider uppercase" style="color: #ba7c21;">
                                    Kandidat No. {{ sprintf("%02d", $candidate->candidate_number) }}
                                </span>
                                <h3 class="text-lg font-extrabold text-slate-900 line-clamp-1 group-hover:text-[#ba7c21] transition-colors">
                                    {{ $candidate->name }}
                                </h3>
                            </div>

                            <!-- Votes & Percentage Highlight Box -->
                            <div class="p-4 rounded-2xl space-y-2.5" style="background: #fcf5e2; border: 1px solid #f7e6bb;">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] font-bold uppercase block text-slate-500">Perolehan Suara</span>
                                        <div class="text-2xl font-black text-slate-900 flex items-baseline space-x-1">
                                            <span>{{ number_format($votes) }}</span>
                                            <span class="text-xs text-slate-500 font-semibold">Suara</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] font-bold uppercase block text-slate-500">Persentase</span>
                                        <div class="text-2xl font-black" style="color: #9b5f1a;">
                                            {{ $pct }}%
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="w-full bg-amber-200/50 rounded-full h-2.5 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-700 ease-out" style="width: {{ $pct }}%; background: linear-gradient(90deg, #ba7c21, #9b5f1a);"></div>
                                </div>
                            </div>

                            <!-- Candidate Description / Vision snippet -->
                            @if($candidate->description)
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ Str::limit(strip_tags($candidate->description), 120) }}
                                </p>
                            @endif

                            <!-- Card Action Button -->
                            @if($event->isOpen())
                                <a href="{{ route('event.show', $event->slug) }}" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-center transition-all flex items-center justify-center space-x-2 text-white shadow-sm hover:opacity-90" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                                    <i class="fa-solid fa-check-to-slot text-xs"></i>
                                    <span>Vote No. {{ sprintf("%02d", $candidate->candidate_number) }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section Grid: Left (Chart Visuals) & Right (Top Supporters / Leaderboard) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-2">
            
            <!-- Left: Visualisasi Data (Chart.js) -->
            <div class="lg:col-span-2 p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-sm bg-white flex flex-col justify-between space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 flex items-center">
                            <i class="fa-solid fa-chart-simple mr-2" style="color: #ba7c21;"></i> Perbandingan Suara Antar Kandidat
                        </h3>
                        <p class="text-xs text-slate-500">Diagram perbandingan distribusi suara secara keseluruhan.</p>
                    </div>
                    <span class="text-xs font-bold text-slate-700 bg-slate-100 px-3.5 py-1.5 rounded-xl border border-slate-200 self-start">
                        Total {{ number_format($totalVotes) }} Suara
                    </span>
                </div>

                <div class="relative h-72 md:h-84 w-full flex items-center justify-center py-2">
                    <canvas id="resultsChart"></canvas>
                </div>

                <div class="pt-4 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
                    <span>* Diperbarui secara otomatis saat transaksi pembayaran selesai.</span>
                    <span class="font-bold flex items-center gap-1" style="color: #ba7c21;">
                        <i class="fa-solid fa-shield-check"></i> 100% Terverifikasi
                    </span>
                </div>
            </div>

            <!-- Right: Top Contributors / Sultan Voting -->
            <div class="p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-sm bg-white flex flex-col justify-between space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-extrabold text-slate-900 flex items-center">
                        <i class="fa-solid fa-fire mr-2 text-amber-500"></i> Top Pendukung Terbanyak
                    </h3>
                    <p class="text-xs text-slate-500">Voter dengan kontribusi suara terbesar.</p>
                </div>

                <!-- Top Voters List -->
                <div class="space-y-3 flex-grow">
                    @forelse($topVoters as $idx => $voter)
                        <div class="flex items-center justify-between p-3.5 rounded-2xl border border-slate-100 transition-all hover:bg-slate-50/80" style="background: #fbfbfb;">
                            <div class="flex items-center space-x-3 min-w-0">
                                <!-- Rank Medal / Number -->
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs flex-shrink-0 {{ $idx === 0 ? 'text-white shadow-sm' : 'bg-slate-100 text-slate-600 border border-slate-200' }}" style="{{ $idx === 0 ? 'background: linear-gradient(135deg, #ba7c21, #9b5f1a);' : '' }}">
                                    @if($idx === 0)
                                        <i class="fa-solid fa-crown text-[10px]"></i>
                                    @else
                                        {{ $idx + 1 }}
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <div class="text-xs font-extrabold text-slate-900 truncate">
                                        {{ $voter->voter_display_name ?: 'Pendukung Anonim' }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 truncate flex items-center space-x-1">
                                        <span>Untuk:</span>
                                        <span class="font-bold text-[#ba7c21]">{{ $voter->candidate ? $voter->candidate->name : '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right flex-shrink-0 ml-2">
                                <span class="px-2.5 py-1 rounded-xl text-xs font-black shadow-sm" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
                                    +{{ number_format($voter->total_qty) }} Suara
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 space-y-2">
                            <i class="fa-solid fa-users text-3xl opacity-30"></i>
                            <p class="text-xs">Belum ada data pendukung yang tercatat.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Info note -->
                <div class="p-3.5 rounded-2xl text-xs flex items-center space-x-2" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
                    <i class="fa-solid fa-circle-info text-[#ba7c21]"></i>
                    <span>Setiap suara Anda langsung membantu posisi kandidat naik di klasemen!</span>
                </div>
            </div>
        </div>

        <!-- Recent Voter Activity Feed ("Riwayat & Nama-Nama yang Vote") -->
        <div class="rounded-3xl border border-slate-200/80 p-6 md:p-8 space-y-6 shadow-sm bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900 flex items-center">
                        <i class="fa-solid fa-bolt mr-2 text-[#ba7c21]"></i> Riwayat Dukungan Suara Terkini
                    </h3>
                    <p class="text-xs text-slate-500">Daftar voter yang baru saja memberikan suara secara real-time.</p>
                </div>
                <span class="text-xs text-slate-500 flex items-center self-start">
                    <span class="w-2 h-2 rounded-full animate-pulse mr-1.5" style="background: #ba7c21;"></span>
                    Menampilkan 15 transaksi terakhir
                </span>
            </div>

            @if($recentVotes->isEmpty())
                <div class="text-center py-12 text-slate-400 space-y-3">
                    <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto text-slate-400 text-2xl border border-slate-200">
                        <i class="fa-regular fa-paper-plane"></i>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-slate-800">Belum Ada Suara yang Masuk</p>
                        <p class="text-xs text-slate-500">Jadilah pendukung pertama yang memberikan suara untuk kandidat favorit Anda!</p>
                    </div>
                    @if($event->isOpen())
                        <div class="pt-2">
                            <a href="{{ route('event.show', $event->slug) }}" class="inline-flex items-center px-5 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-md" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                                Berikan Suara Pertama
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach($recentVotes as $vote)
                        <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/60 px-2 rounded-2xl transition-colors">
                            <div class="flex items-center space-x-3.5 min-w-0">
                                <!-- Avatar initial -->
                                @php
                                    $displayName = $vote->voter_name ?: 'Voter #' . substr($vote->voter_identifier, 0, 6);
                                    $initial = strtoupper(substr($displayName, 0, 1));
                                @endphp
                                <div class="w-10 h-10 rounded-2xl text-white font-black text-sm flex items-center justify-center flex-shrink-0 shadow-sm" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                                    {{ $initial }}
                                </div>

                                <div class="min-w-0">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-bold text-slate-900 text-sm truncate">{{ $displayName }}</span>
                                        <span class="text-[10px] px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold border border-emerald-200 flex-shrink-0">
                                            <i class="fa-solid fa-check text-[8px] mr-1"></i> Terverifikasi
                                        </span>
                                    </div>
                                    <div class="text-xs text-slate-600 flex flex-wrap items-center gap-1.5 mt-0.5">
                                        <span>memberikan dukungan untuk</span>
                                        @if($vote->candidate)
                                            <span class="font-bold" style="color: #9b5f1a;">
                                                No. {{ sprintf("%02d", $vote->candidate->candidate_number) }} - {{ $vote->candidate->name }}
                                            </span>
                                        @else
                                            <span class="font-semibold text-slate-500">Kandidat</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end space-x-4 flex-shrink-0">
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-xl text-xs font-black shadow-sm inline-block" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
                                        +{{ number_format($vote->quantity) }} Suara
                                    </span>
                                </div>
                                <span class="text-xs text-slate-400 whitespace-nowrap">
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
    <div class="bg-slate-900 border border-amber-500/40 text-white px-5 py-3 rounded-2xl shadow-2xl flex items-center space-x-3">
        <div class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center text-xs">
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
            
            const labels = [@foreach($candidates as $c) "No. {{ sprintf('%02d', $c->candidate_number) }} - {{ $c->name }}", @endforeach];
            const data = [@foreach($candidates as $c) {{ $c->votes_sum_quantity ?? 0 }}, @endforeach];
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Perolehan Suara',
                        data: data,
                        backgroundColor: [
                            'rgba(186, 124, 33, 0.85)',   // Primary Gold
                            'rgba(155, 95, 26, 0.85)',    // Dark Gold / Caramel
                            'rgba(217, 119, 6, 0.85)',    // Warm Amber
                            'rgba(180, 83, 9, 0.85)',     // Brown Gold
                            'rgba(245, 158, 11, 0.85)',   // Honey Gold
                            'rgba(120, 53, 15, 0.85)'     // Deep Caramel
                        ],
                        borderColor: [
                            'rgb(186, 124, 33)',
                            'rgb(155, 95, 26)',
                            'rgb(217, 119, 6)',
                            'rgb(180, 83, 9)',
                            'rgb(245, 158, 11)',
                            'rgb(120, 53, 15)'
                        ],
                        borderWidth: 1.5,
                        borderRadius: 10,
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
                            borderColor: 'rgba(186, 124, 33, 0.4)',
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
                                color: 'rgba(0, 0, 0, 0.04)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 11,
                                    family: 'Instrument Sans, system-ui, sans-serif'
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
                                color: '#0f172a',
                                font: {
                                    size: 12,
                                    weight: 'bold',
                                    family: 'Instrument Sans, system-ui, sans-serif'
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
                dot.classList.remove('animate-ping');
                dot.style.background = '#94a3b8';
                label.innerText = 'Live Sync: Off';
            } else {
                startAutoRefresh();
                isRefreshing = true;
                dot.style.background = '#ba7c21';
                dot.classList.add('animate-ping');
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
