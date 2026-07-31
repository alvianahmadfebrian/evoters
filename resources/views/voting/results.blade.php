@extends('layouts.app')

@section('title', 'Hasil Voting: ' . $event->title . ' - eVoters')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-2 text-xs text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
        <span>&rarr;</span>
        <a href="{{ route('event.show', $event->slug) }}" class="hover:text-white transition-colors">{{ $event->title }}</a>
        <span>&rarr;</span>
        <span class="text-gray-300">Hasil Voting</span>
    </div>

    <!-- Error/Notice Block (If results are restricted) -->
    @if(isset($error))
        <div class="glass-card rounded-3xl p-8 md:p-12 text-center border border-white/5 space-y-6 max-w-2xl mx-auto shadow-2xl relative overflow-hidden">
            <div class="w-16 h-16 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-full flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="space-y-2">
                <h2 class="text-xl font-bold text-white">Hasil Voting Dikunci</h2>
                <p class="text-sm text-gray-400 leading-relaxed font-medium">{{ $error }}</p>
            </div>
            <div class="pt-4 flex justify-center space-x-4">
                <a href="{{ route('event.show', $event->slug) }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs py-3 px-6 rounded-xl transition-all cursor-pointer">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Ballot
                </a>
                <a href="{{ route('home') }}" class="bg-white/5 hover:bg-white/10 text-gray-300 border border-white/5 font-semibold text-xs py-3 px-6 rounded-xl transition-all">
                    Lihat Event Lain
                </a>
            </div>
        </div>
    @else
        <!-- Results Page Main Content -->
        <div class="space-y-8">
            <div class="text-center space-y-2 max-w-xl mx-auto">
                <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-wider">Hasil Pemungutan Suara Real-Time</span>
                <h1 class="text-2xl md:text-4xl font-extrabold text-white leading-tight">{{ $event->title }}</h1>
                <p class="text-xs text-gray-400">Data diperbarui secara otomatis setiap kali suara baru didaftarkan.</p>
            </div>

            <!-- Stats & Charts Container Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: Chart.js Canvas (Col Span 2) -->
                <div class="lg:col-span-2 glass-card p-6 md:p-8 rounded-3xl border border-white/5 shadow-2xl space-y-6 flex flex-col justify-center">
                    <h3 class="text-sm font-bold text-white"><i class="fa-solid fa-chart-pie mr-2 text-indigo-400"></i>Visualisasi Data</h3>
                    
                    <div class="relative h-64 md:h-80 w-full flex items-center justify-center">
                        <canvas id="resultsChart"></canvas>
                    </div>
                </div>

                <!-- Right: Vote details statistics -->
                <div class="glass-card p-6 md:p-8 rounded-3xl border border-white/5 shadow-2xl space-y-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-white mb-4"><i class="fa-solid fa-box-archive mr-2 text-indigo-400"></i>Informasi Partisipasi</h3>
                        
                        <div class="space-y-4 text-xs text-gray-400">
                            <div class="p-4 rounded-2xl bg-white/5 border border-white/5 space-y-1">
                                <span class="text-[10px] text-gray-500 block uppercase font-bold">Total Suara Terdaftar</span>
                                <span class="text-3xl font-extrabold text-white">{{ $totalVotes }} Suara</span>
                            </div>

                            <div class="space-y-1 text-gray-400">
                                <span class="text-gray-500">Status Pemilihan</span>
                                <span class="text-white block font-bold">
                                    @if($event->status === 'active')
                                        <span class="text-green-400 animate-pulse"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Sedang Berlangsung</span>
                                    @elseif($event->status === 'closed')
                                        <span class="text-red-400"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Pemilihan Selesai</span>
                                    @else
                                        <span class="text-gray-400">Ditangguhkan</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('event.show', $event->slug) }}" class="w-full bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white border border-white/5 font-semibold text-xs py-3 rounded-xl text-center transition-all cursor-pointer">
                        <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Ballot Suara
                    </a>
                </div>
            </div>

            <!-- Detailed breakdown list of candidate counts -->
            <div class="glass-card rounded-3xl border border-white/5 p-6 md:p-8 space-y-6 shadow-2xl">
                <h3 class="text-sm font-bold text-white"><i class="fa-solid fa-list-ol mr-2 text-indigo-400"></i>Rincian Perolehan Suara</h3>
                
                <div class="space-y-4">
                    @foreach($candidates as $candidate)
                        @php 
                            $candidateVotes = $candidate->votes_sum_quantity ?? 0;
                            $percentage = $totalVotes > 0 ? round(($candidateVotes / $totalVotes) * 100, 2) : 0; 
                        @endphp
                        
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs sm:text-sm">
                                <div class="flex items-center space-x-3 min-w-0">
                                    <span class="w-7 h-7 rounded-lg bg-indigo-600/10 border border-indigo-500/20 text-indigo-400 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                        {{ sprintf("%02d", $candidate->candidate_number) }}
                                    </span>
                                    <span class="font-bold text-white truncate">{{ $candidate->name }}</span>
                                </div>
                                <div class="flex items-center space-x-4 flex-shrink-0 text-right">
                                    <span class="text-gray-400 font-semibold">{{ $candidateVotes }} Suara</span>
                                    <span class="text-indigo-400 font-extrabold w-12">{{ $percentage }}%</span>
                                </div>
                            </div>
                            <!-- Bar fill container -->
                            <div class="w-full bg-white/5 rounded-full h-3.5 relative overflow-hidden border border-white/5">
                                <div class="bg-gradient-to-r from-violet-600 to-indigo-500 h-full rounded-full transition-all duration-1000 ease-out" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
@if(!isset($error) && $candidates->isNotEmpty())
    <!-- Load Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('resultsChart').getContext('2d');
            
            // Candidate names and vote counts from server template variables
            const labels = [@foreach($candidates as $c) "{{ sprintf('%02d', $c->candidate_number) }}. {{ $c->name }}", @endforeach];
            const data = [@foreach($candidates as $c) {{ $c->votes_sum_quantity ?? 0 }}, @endforeach];
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Perolehan Suara',
                        data: data,
                        backgroundColor: [
                            'rgba(99, 102, 241, 0.45)',  // Indigo
                            'rgba(139, 92, 246, 0.45)',  // Violet
                            'rgba(236, 72, 153, 0.45)',  // Pink
                            'rgba(20, 184, 166, 0.45)',  // Teal
                            'rgba(245, 158, 11, 0.45)'   // Amber
                        ],
                        borderColor: [
                            'rgb(99, 102, 241)',
                            'rgb(139, 92, 246)',
                            'rgb(236, 72, 153)',
                            'rgb(20, 184, 166)',
                            'rgb(245, 158, 11)'
                        ],
                        borderWidth: 1.5,
                        borderRadius: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y', // Horizontal bars
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.parsed.x} suara`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.06)'
                            },
                            ticks: {
                                color: 'rgba(15, 23, 42, 0.6)',
                                stepSize: 1
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: 'rgba(15, 23, 42, 0.9)',
                                font: {
                                    size: 11,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endif
@endsection
