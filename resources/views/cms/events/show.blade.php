@extends('layouts.cms')

@section('title', 'Monitor Event - ' . $event->title)
@section('page_title', 'Monitor Voting Event')

@section('content')
<div class="space-y-8 animate-fade-in">
    
    <!-- Top breadcrumb and action triggers -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-2 text-xs text-gray-500">
            <a href="{{ route('cms.events.index') }}" class="hover:text-white transition-colors">Event</a>
            <span>&rarr;</span>
            <span class="text-gray-300">{{ $event->title }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('event.show', $event->slug) }}" target="_blank" class="bg-white/5 hover:bg-white/10 border border-white/5 text-gray-300 hover:text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all cursor-pointer">
                <i class="fa-solid fa-square-arrow-up-right mr-1.5"></i> Lihat Ballot Voter
            </a>
            <a href="{{ route('cms.events.edit', $event->id) }}" class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all shadow-md shadow-indigo-600/10 cursor-pointer">
                <i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit Detail
            </a>
        </div>
    </div>

    <!-- Event Quick Detail & Statistics Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Quick Detail -->
        <div class="glass-card p-6 rounded-2xl border border-white/5 lg:col-span-2 space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-wider">Detil Event</span>
                    <h2 class="text-xl font-bold text-white">{{ $event->title }}</h2>
                </div>
                <!-- Status Badge -->
                @if($event->status === 'active')
                    <span class="px-2.5 py-1 rounded bg-green-500/10 text-green-400 border border-green-500/20 text-xs font-bold uppercase tracking-wider">AKTIF</span>
                @elseif($event->status === 'paused')
                    <span class="px-2.5 py-1 rounded bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 text-xs font-bold uppercase tracking-wider">PAUSED</span>
                @elseif($event->status === 'closed')
                    <span class="px-2.5 py-1 rounded bg-red-500/10 text-red-400 border border-red-500/20 text-xs font-bold uppercase tracking-wider">CLOSED</span>
                @else
                    <span class="px-2.5 py-1 rounded bg-gray-500/10 text-gray-400 border border-gray-500/20 text-xs font-bold uppercase tracking-wider">DRAFT</span>
                @endif
            </div>

            <p class="text-xs text-gray-400 leading-relaxed font-medium">
                {{ $event->description ?: 'Tidak ada deskripsi event.' }}
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-white/5 text-xs text-gray-400">
                <div class="space-y-1">
                    <span class="text-gray-500 block">Tipe Validasi Voter</span>
                    <span class="text-white font-bold">
                        @if($event->voting_type === 'public_email')
                            <i class="fa-solid fa-envelope mr-1.5 text-emerald-400"></i> Email Terbuka (OTP)
                        @else
                            <i class="fa-solid fa-ticket mr-1.5 text-purple-400"></i> Token Privat
                        @endif
                    </span>
                </div>
                <div class="space-y-1">
                    <span class="text-gray-500 block">Publikasi Hasil</span>
                    <span class="text-white font-semibold">
                        @if($event->show_results === 'always') Selalu Terbuka
                        @elseif($event->show_results === 'after_voting') Setelah Voter Memilih
                        @elseif($event->show_results === 'after_closed') Setelah Event Tutup
                        @else Rahasia (Admin Only)
                        @endif
                    </span>
                </div>
                <div class="space-y-1">
                    <span class="text-gray-500 block">Waktu Mulai</span>
                    <span class="text-white font-semibold">{{ $event->start_time ? $event->start_time->format('d M Y - H:i') : 'Tanpa batas' }}</span>
                </div>
                <div class="space-y-1">
                    <span class="text-gray-500 block">Waktu Selesai</span>
                    <span class="text-white font-semibold">{{ $event->end_time ? $event->end_time->format('d M Y - H:i') : 'Tanpa batas' }}</span>
                </div>
                <div class="space-y-1">
                    <span class="text-gray-500 block">Tarif Voting</span>
                    <span class="text-emerald-600 font-bold">
                        @if($event->price > 0)
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Right: Small Stats -->
        <div class="glass-card p-6 rounded-2xl border border-white/5 flex flex-col justify-between space-y-4">
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Statistik Suara</span>
            <div class="space-y-1">
                <h4 class="text-gray-400 text-xs font-semibold">Total Suara Terkumpul</h4>
                <div class="text-4xl font-extrabold text-white">{{ $totalVotes }}</div>
                @if($event->voting_type === 'token_only')
                    <p class="text-[10px] text-gray-500 font-medium">Dari total {{ $totalTokens }} token yang digenerate</p>
                @endif
            </div>

            <!-- Turnout progress bar -->
            @if($event->voting_type === 'token_only' && $totalTokens > 0)
                @php $pct = round(($usedTokens / $totalTokens) * 100, 1); @endphp
                <div class="space-y-1">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-gray-400">Tingkat Partisipasi</span>
                        <span class="text-indigo-400">{{ $pct }}%</span>
                    </div>
                    <div class="w-full bg-white/5 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @else
                <div class="py-2.5 px-3 rounded-xl bg-white/5 border border-white/5 flex items-center space-x-2 text-xs text-gray-400">
                    <i class="fa-solid fa-circle-check text-green-400 text-sm"></i>
                    <span>Sistem voting saat ini aktif menerima respon.</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Candidate Management Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: List Candidates (Col Span 2) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-md font-bold text-white">Daftar Kandidat / Pilihan</h3>
                    <p class="text-xs text-gray-400">Kandidat yang akan tampil pada kertas suara/ballot.</p>
                </div>
                <button onclick="toggleCandidateForm()" class="bg-indigo-600/10 hover:bg-indigo-600/20 border border-indigo-500/20 text-indigo-400 hover:text-indigo-300 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors cursor-pointer">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Kandidat
                </button>
            </div>

            <!-- Add Candidate Form (Hidden by default) -->
            <div id="add-candidate-card" class="glass-card rounded-2xl p-6 border border-indigo-500/20 bg-indigo-950/5 hidden animate-fade-in">
                <h4 class="text-sm font-bold text-white mb-4"><i class="fa-solid fa-user-plus mr-1.5 text-indigo-400"></i>Tambah Kandidat Baru</h4>
                <form action="{{ route('cms.candidates.store', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="space-y-1 sm:col-span-2">
                            <label for="c_name" class="text-xs font-semibold text-gray-400">Nama Kandidat</label>
                            <input type="text" name="name" id="c_name" required placeholder="Nama Lengkap Kandidat" class="w-full px-3 py-2 rounded-lg glass-input text-sm text-white">
                        </div>
                        <div class="space-y-1">
                            <label for="c_num" class="text-xs font-semibold text-gray-400">Nomor Urut</label>
                            <input type="number" name="candidate_number" id="c_num" required placeholder="Contoh: 1" class="w-full px-3 py-2 rounded-lg glass-input text-sm text-white">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="c_desc" class="text-xs font-semibold text-gray-400">Visi, Misi & Deskripsi Singkat</label>
                        <textarea name="description" id="c_desc" rows="3" placeholder="Tulis visi, misi, atau program kerja..." class="w-full px-3 py-2 rounded-lg glass-input text-xs text-white"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label for="c_photo" class="text-xs font-semibold text-gray-400">Foto Kandidat (Opsional, Max 2MB)</label>
                        <input type="file" name="photo" id="c_photo" accept="image/*" class="w-full text-xs text-gray-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white/5 file:text-gray-300 hover:file:bg-white/10 transition-colors">
                    </div>

                    <div class="flex items-center justify-end space-x-2 pt-2">
                        <button type="button" onclick="toggleCandidateForm()" class="text-xs font-semibold text-gray-400 hover:text-white px-3 py-1.5 rounded-lg bg-white/5">Batal</button>
                        <button type="submit" class="text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-1.5 rounded-lg transition-colors cursor-pointer">Simpan Kandidat</button>
                    </div>
                </form>
            </div>

            <!-- Candidates Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($event->candidates as $candidate)
                    <div class="glass-card rounded-2xl overflow-hidden border border-white/5 flex flex-col justify-between">
                        <div class="p-5 flex items-start space-x-4">
                            <!-- Photo -->
                            <div class="w-16 h-16 rounded-xl bg-gray-900 border border-white/10 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                @if($candidate->photo)
                                    <img src="{{ asset($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-user text-2xl text-gray-700"></i>
                                @endif
                            </div>
                            
                            <!-- Profile details -->
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center space-x-2">
                                    <span class="w-6 h-6 rounded-md bg-indigo-600 text-white font-bold text-xs flex items-center justify-center flex-shrink-0">
                                        {{ sprintf("%02d", $candidate->candidate_number) }}
                                    </span>
                                    <h4 class="text-sm font-bold text-white truncate">{{ $candidate->name }}</h4>
                                </div>
                                <p class="text-xs text-gray-400 mt-2 line-clamp-3">
                                    {{ $candidate->description ?: 'Tidak ada deskripsi visi/misi.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer actions & vote metrics -->
                        <div class="px-5 py-3.5 bg-white/[0.01] border-t border-white/5 flex items-center justify-between text-xs">
                            <span class="text-gray-400 font-semibold">
                                <i class="fa-solid fa-box-archive mr-1.5 text-indigo-400"></i> 
                                <span class="text-white">{{ $candidate->votes_sum_quantity ?? 0 }}</span> Suara
                            </span>
                            
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('cms.candidates.edit', $candidate->id) }}" class="text-gray-400 hover:text-white transition-colors py-1 px-2 rounded hover:bg-white/5 cursor-pointer" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                
                                <form action="{{ route('cms.candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kandidat ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition-colors py-1 px-2 rounded hover:bg-red-500/10 cursor-pointer" title="Hapus">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 glass-card rounded-2xl p-8 text-center text-gray-500">
                        <i class="fa-solid fa-users-slash text-3xl text-gray-600 block mb-2"></i>
                        <p class="text-xs">Belum ada kandidat terdaftar untuk event ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Live Activity Log (Col Span 1) -->
        <div class="space-y-4">
            <h3 class="text-md font-bold text-white"><i class="fa-solid fa-clock-rotate-left mr-2 text-indigo-400"></i>Log Suara Masuk</h3>
            <div class="glass-card rounded-2xl border border-white/5 divide-y divide-white/5 max-h-[350px] overflow-y-auto">
                @forelse($recentVotes as $vote)
                    <div class="p-4 space-y-1 hover:bg-white/[0.01] transition-colors">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="text-indigo-400 font-bold">Kandidat Urut {{ sprintf("%02d", $vote->candidate->candidate_number) }}</span>
                            <span class="text-gray-500">{{ $vote->voted_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[10px] text-gray-400">
                            <span class="truncate">Voter Hash: {{ substr($vote->voter_identifier, 0, 10) }}...</span>
                            <span class="text-emerald-500 font-bold font-mono">{{ $vote->quantity }} vote</span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 text-xs">Belum ada suara masuk.</div>
                @endforelse
            </div>
            @if($recentVotes->hasPages())
                <div class="text-center pt-2">
                    {{ $recentVotes->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Private Tokens Generator Section (Only visible if voting_type is token_only) -->
    @if($event->voting_type === 'token_only')
        <div class="pt-6 border-t border-white/5 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-md font-bold text-white">Kelola Kode Token Pemilih</h3>
                    <p class="text-xs text-gray-400">Generate dan distribusikan kode unik ini kepada voter terdaftar Anda.</p>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <!-- Export -->
                    <a href="{{ route('cms.tokens.export', $event->id) }}" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition-all shadow-md shadow-emerald-600/10 cursor-pointer">
                        <i class="fa-solid fa-file-arrow-down mr-1"></i> Unduh Semua Token
                    </a>
                    
                    <!-- Copy unused codes utility -->
                    <button onclick="copyUnusedTokens()" class="bg-indigo-600/10 hover:bg-indigo-600/20 border border-indigo-500/20 text-indigo-400 text-xs font-semibold px-3.5 py-2 rounded-xl transition-colors cursor-pointer">
                        <i class="fa-solid fa-copy mr-1"></i> Salin Semua Token Unused
                    </button>
                    
                    <!-- Clear unused -->
                    <form action="{{ route('cms.tokens.clear', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh token yang belum terpakai?')" class="inline-block">
                        @csrf
                        <button type="submit" class="bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 text-xs font-semibold px-3.5 py-2 rounded-xl transition-all cursor-pointer">
                            <i class="fa-solid fa-trash-can mr-1"></i> Bersihkan Unused
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Left: Bulk Token Generator Form -->
                <div class="glass-card rounded-2xl p-6 border border-white/5 space-y-4">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider"><i class="fa-solid fa-gears mr-1.5 text-indigo-400"></i>Generate Token Baru</h4>
                    
                    <form action="{{ route('cms.tokens.generate', $event->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label for="quantity" class="text-xs text-gray-400">Jumlah Token (Min 1, Max 1000)</label>
                            <input type="number" name="quantity" id="quantity" required min="1" max="1000" value="50" class="w-full px-3 py-2 rounded-lg glass-input text-sm text-white">
                        </div>
                        
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs py-2.5 rounded-lg transition-colors shadow-md shadow-indigo-600/10 cursor-pointer">
                            <i class="fa-solid fa-bolt mr-1"></i> Generate Sekarang
                        </button>
                    </form>
                </div>

                <!-- Right: Tokens Table (Col Span 2) -->
                <div class="lg:col-span-2 glass-card rounded-2xl border border-white/5 overflow-hidden shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="text-[10px] text-gray-400 uppercase bg-white/5 border-b border-white/5 font-bold">
                                <tr>
                                    <th class="px-5 py-3">Kode Token</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Waktu Vote</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-gray-300">
                                @forelse($tokens as $token)
                                    <tr class="hover:bg-white/[0.01]">
                                        <td class="px-5 py-2.5 font-mono text-white text-xs select-all">
                                            {{ $token->code }}
                                        </td>
                                        <td class="px-5 py-2.5">
                                            @if($token->is_used)
                                                <span class="px-2 py-0.5 rounded bg-red-500/10 text-red-400 border border-red-500/20 text-[9px] font-bold">TERPA KAI</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded bg-green-500/10 text-green-400 border border-green-500/20 text-[9px] font-bold token-code-unused">{{ $token->code }}</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-2.5 text-gray-500">
                                            {{ $token->voted_at ? $token->voted_at->format('d M Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-5 py-8 text-center text-gray-500">Belum ada token digenerate.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($tokens->hasPages())
                        <div class="px-5 py-3.5 border-t border-white/5 bg-white/[0.005]">
                            {{ $tokens->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    function toggleCandidateForm() {
        const card = document.getElementById('add-candidate-card');
        if (card.classList.contains('hidden')) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    }

    function copyUnusedTokens() {
        // Find all elements containing unused token codes
        const elements = document.querySelectorAll('.token-code-unused');
        if (elements.length === 0) {
            alert('Tidak ada token berstatus unused (belum terpakai) di halaman ini.');
            return;
        }

        let codes = [];
        elements.forEach(el => {
            codes.push(el.innerText.trim());
        });

        const text = codes.join('\n');
        
        // Copy to clipboard
        navigator.clipboard.writeText(text).then(() => {
            alert(`Berhasil menyalin ${codes.length} token (unused) di halaman ini ke clipboard!`);
        }).catch(err => {
            console.error('Gagal menyalin token: ', err);
            alert('Gagal menyalin token ke clipboard.');
        });
    }
</script>
@endsection
