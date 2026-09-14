@extends('layouts.app')

@section('title', $event->title . ' - eVoters')

@section('content')
<div class="space-y-8 animate-fade-in pb-12">
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-2 text-xs text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-[#ba7c21] transition-colors">Beranda</a>
        <span>&rarr;</span>
        <a href="{{ route('events.list') }}" class="hover:text-[#ba7c21] transition-colors">Event</a>
        <span>&rarr;</span>
        <span class="text-slate-900 font-bold line-clamp-1 max-w-sm">{{ $event->title }}</span>
    </div>

    <!-- Event Header Card -->
    <div class="rounded-3xl overflow-hidden border border-slate-200/80 bg-white shadow-sm relative">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Banner / Accent -->
            <div class="h-48 md:h-full w-full relative bg-slate-100 overflow-hidden">
                @if($event->banner_image)
                    <img src="{{ asset($event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-tr from-amber-50 to-slate-100 flex items-center justify-center">
                        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ba7c21_1px,transparent_1px)] [background-size:20px_20px]"></div>
                        <img src="{{ asset('images/logo2.png') }}" alt="Placeholder Logo" class="h-10 w-auto opacity-30">
                    </div>
                @endif
                
                <!-- Status Badge -->
                <div class="absolute top-4 left-4">
                    @if($event->isOpen())
                        <span class="inline-flex items-center px-3 py-1 rounded-full shadow-sm text-[10px] font-extrabold tracking-wider uppercase" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
                            <span class="w-1.5 h-1.5 rounded-full animate-pulse mr-1.5" style="background: #ba7c21;"></span> Voting Dibuka
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-extrabold tracking-wider uppercase">
                            Voting Ditutup
                        </span>
                    @endif
                </div>
            </div>

            <!-- Content Details (col-span 2) -->
            <div class="p-6 md:p-8 md:col-span-2 flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight">{{ $event->title }}</h1>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        {{ $event->description ?: 'Pilih kandidat terbaik Anda dalam pelaksanaan event pemungutan suara ini.' }}
                    </p>
                </div>

                <!-- Date Info & Action -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-slate-500">
                    <div class="space-y-1">
                        <div class="flex items-center text-slate-600">
                            <i class="fa-solid fa-calendar mr-2 text-[#ba7c21]"></i>
                            <span>Pelaksanaan: 
                                <span class="text-slate-900 font-bold">
                                    {{ $event->start_time ? $event->start_time->format('d M Y') : 'Mulai Sekarang' }}
                                    -
                                    {{ $event->end_time ? $event->end_time->format('d M Y H:i') : 'Selesai' }}
                                </span>
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('event.results', $event->slug) }}" class="font-bold flex items-center text-xs sm:text-sm transition-colors hover:opacity-80" style="color: #ba7c21;">
                        <i class="fa-solid fa-chart-simple mr-1.5"></i> Lihat Hasil Real-Time 
                        <span class="ml-1">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ballot Box Candidates Grid -->
    <div class="space-y-6">
        <div class="text-center space-y-1.5 max-w-xl mx-auto">
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-900">Kertas Suara Pemilihan</h2>
            <p class="text-xs text-slate-500">Silakan pelajari profil kandidat, lalu klik tombol "Pilih" di bawah kandidat pilihan Anda.</p>
        </div>

        @if($event->candidates->isEmpty())
            <div class="rounded-3xl p-12 text-center border border-slate-200 bg-white text-slate-400 space-y-2 shadow-sm">
                <i class="fa-solid fa-users-slash text-4xl block mb-2 text-slate-300"></i>
                <p class="text-sm font-bold text-slate-700">Belum ada kandidat terdaftar untuk event ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($event->candidates as $candidate)
                    <div class="rounded-3xl overflow-hidden border border-slate-200/80 bg-white flex flex-col justify-between group hover:-translate-y-1 hover:shadow-xl transition-all duration-300 shadow-sm">
                        <!-- Photo Header -->
                        <div class="h-60 w-full relative bg-slate-100 flex-shrink-0">
                            @if($candidate->photo)
                                <img src="{{ asset($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-amber-50 to-slate-100 flex items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-user text-6xl text-[#ba7c21] opacity-40"></i>
                                </div>
                            @endif
                            
                            <!-- Ballot Number -->
                            <div class="absolute top-3.5 left-3.5">
                                <div class="w-10 h-10 rounded-2xl font-black text-white text-base flex items-center justify-center shadow-lg" style="background: #0f172a;">
                                    {{ sprintf("%02d", $candidate->candidate_number) }}
                                </div>
                            </div>
                        </div>

                        <!-- Candidate info -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-1.5">
                                <span class="text-[11px] font-extrabold tracking-wider uppercase" style="color: #ba7c21;">
                                    Kandidat No. {{ sprintf("%02d", $candidate->candidate_number) }}
                                </span>
                                <h3 class="text-lg font-extrabold text-slate-900 truncate">{{ $candidate->name }}</h3>
                                <p class="text-xs text-slate-600 line-clamp-4 leading-relaxed whitespace-pre-line">
                                    {{ $candidate->description ?: 'Kandidat ini belum mengisi deskripsi visi & misi.' }}
                                </p>
                            </div>

                            @if($event->isOpen())
                                <button 
                                    onclick="openVotingModal({{ $candidate->id }}, '{{ addslashes($candidate->name) }}', '{{ sprintf('%02d', $candidate->candidate_number) }}', '{{ $candidate->photo ? asset($candidate->photo) : '' }}')"
                                    class="w-full text-white font-bold text-xs py-3.5 rounded-xl transition-all cursor-pointer shadow-md hover:opacity-90 flex items-center justify-center gap-1.5"
                                    style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);"
                                >
                                    <i class="fa-solid fa-check-to-slot"></i>
                                    <span>Pilih Kandidat {{ sprintf("%02d", $candidate->candidate_number) }}</span>
                                </button>
                            @else
                                <button 
                                    disabled
                                    class="w-full bg-slate-100 border border-slate-200 text-slate-400 font-bold text-xs py-3.5 rounded-xl cursor-not-allowed"
                                >
                                    Voting Ditutup
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Modal Dialog Box (Voting Form validation) -->
<div id="voting-modal" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md">
    <div class="w-full relative bg-white text-slate-800 my-auto max-w-md rounded-[2.25rem] p-6 md:p-7 shadow-2xl border border-slate-100 overflow-hidden space-y-5">
        
        <!-- Ambient decorative lights -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#ba7c21]/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-[#9b5f1a]/10 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Header Modal with Close Button -->
        <div class="flex items-start justify-between gap-3 relative z-10">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200/80">
                    <i class="fa-solid fa-square-check text-[#ba7c21]"></i>
                    <span>Konfirmasi Pilihan</span>
                </span>
                <h3 class="text-xl font-black text-slate-900 tracking-tight mt-1.5">Tentukan Dukungan Suara</h3>
            </div>
            <!-- Close button -->
            <button type="button" onclick="closeVotingModal()" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-800 flex items-center justify-center transition-all cursor-pointer flex-shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Selected Candidate Card with Photo -->
        <div class="flex items-center gap-3.5 p-3.5 rounded-2xl bg-gradient-to-br from-[#fefcf6] to-[#fcf5e2] border border-[#f7e6bb] shadow-xs relative z-10">
            <!-- Candidate Photo -->
            <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-[#ba7c21]/30 bg-white shadow-sm flex-shrink-0 flex items-center justify-center">
                <img id="modal-candidate-img" src="" alt="Foto Kandidat" class="w-full h-full object-cover hidden">
                <div id="modal-candidate-placeholder" class="w-full h-full flex items-center justify-center bg-amber-100 text-[#ba7c21]">
                    <i class="fa-solid fa-user text-xl"></i>
                </div>
            </div>

            <!-- Candidate Details -->
            <div class="min-w-0 flex-grow text-left">
                <div class="flex items-center gap-1.5 mb-0.5">
                    <span class="text-[9px] font-black text-white px-2 py-0.5 rounded-md tracking-wider uppercase" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                        NO. <span id="modal-candidate-num">01</span>
                    </span>
                    <span class="text-[9px] font-extrabold uppercase text-[#9b5f1a] tracking-wider">Kandidat Pilihan</span>
                </div>
                <h4 id="modal-candidate-name" class="text-sm md:text-base font-black text-slate-900 truncate leading-snug">Nama Kandidat</h4>
                <p class="text-[11px] text-slate-500 truncate mt-0.5">{{ $event->title }}</p>
            </div>
        </div>

        <form action="{{ route('event.vote', $event->slug) }}" method="POST" id="main-vote-form" class="space-y-4 relative z-10">
            @csrf
            
            <!-- Hidden inputs -->
            <input type="hidden" name="candidate_id" id="hidden-candidate-id" value="">
            <input type="hidden" name="voting_type" value="{{ $event->voting_type }}">

            @if($event->price > 0)
                <!-- Name Input -->
                <div class="text-left space-y-1.5">
                    <label for="voter-name" class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 block">Nama Lengkap Pemilih</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        <input 
                            type="text" 
                            name="name" 
                            id="voter-name" 
                            required
                            value="{{ auth()->check() ? auth()->user()->name : old('name') }}"
                            placeholder="Ketik nama Anda di sini..." 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-10 pr-4 py-3 text-xs md:text-sm font-bold text-slate-800 placeholder-slate-400 outline-none focus:bg-white focus:border-[#ba7c21] focus:ring-4 focus:ring-[#ba7c21]/10 transition-all"
                        >
                    </div>
                </div>

                <!-- Price + Quantity Counter -->
                <div class="flex items-center gap-2.5">
                    <div class="min-w-[95px] p-2.5 rounded-2xl text-center border border-[#f7e6bb] bg-gradient-to-br from-[#fefcf6] to-[#fcf5e2] flex-shrink-0">
                        <div class="text-[8px] font-black uppercase text-[#9b5f1a] tracking-wider">Per Suara</div>
                        <div class="text-xs md:text-sm font-black text-[#ba7c21] mt-0.5">Rp {{ number_format($event->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="flex-grow flex items-center justify-between p-1.5 rounded-2xl border border-slate-200 bg-slate-50">
                        <button type="button" onclick="decrementVotes()" class="w-9 h-9 rounded-xl bg-white border border-slate-200/80 shadow-xs hover:bg-slate-100 active:scale-95 text-slate-700 text-xs font-black cursor-pointer flex items-center justify-center transition-all">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <input 
                            type="number" 
                            name="quantity" 
                            id="vote-quantity" 
                            required 
                            min="1"
                            value="1" 
                            class="w-16 text-center text-lg font-black text-slate-900 border-none bg-transparent outline-none"
                            onchange="updateTotalPayment()"
                        >
                        <button type="button" onclick="incrementVotes()" class="w-9 h-9 rounded-xl bg-white border border-slate-200/80 shadow-xs hover:bg-slate-100 active:scale-95 text-slate-700 text-xs font-black cursor-pointer flex items-center justify-center transition-all">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Quick Selection (Pilih Cepat Nominal) -->
                @php
                    $multipliers = [1, 2, 5, 10, 20, 50];
                @endphp
                <div class="text-left space-y-1.5">
                    <label class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 block">Pilih Cepat Nominal</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($multipliers as $mult)
                            <button 
                                type="button" 
                                onclick="setVotes({{ $mult }})" 
                                data-qty="{{ $mult }}"
                                class="quick-vote-btn py-2 px-2 rounded-xl border border-slate-200 bg-slate-50/80 hover:bg-slate-100 text-slate-800 cursor-pointer text-center flex flex-col items-center justify-center transition-all duration-150"
                            >
                                <span class="text-xs font-black leading-tight">Rp {{ number_format($event->price * $mult / 1000, 0, ',', '.') }}k</span>
                                <span class="quick-qty-tag text-[9px] font-extrabold text-slate-400 mt-0.5">({{ $mult }}x)</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Total Payment Summary Box -->
                <div class="p-3.5 rounded-2xl bg-gradient-to-r from-[#fefcf6] to-[#fcf5e2] border border-[#f7e6bb] flex items-center justify-between shadow-xs">
                    <div class="text-left">
                        <span class="text-[9px] font-black uppercase text-[#9b5f1a] tracking-wider block">Total Pembayaran</span>
                        <span id="summary-qty-text" class="text-[11px] font-bold text-slate-600 block mt-0.5">1 Suara Terpilih</span>
                    </div>
                    <span id="total-payment-display" class="text-xl md:text-2xl font-black text-[#ba7c21] tracking-tight">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                </div>
            @elseif($event->voting_type === 'public_email')
                
                <!-- Email Input -->
                <div class="space-y-1.5 text-left">
                    <label for="voter-email" class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 block">Alamat Email</label>
                    <div class="flex gap-2">
                        <div class="relative flex-grow">
                            <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                            <input 
                                type="email" 
                                name="email" 
                                id="voter-email" 
                                required
                                value="{{ auth()->check() ? auth()->user()->email : old('email') }}"
                                placeholder="nama@email.com" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-10 pr-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-[#ba7c21] transition-all"
                            >
                        </div>
                        <button 
                            type="button" 
                            id="otp-btn"
                            onclick="requestOTP()" 
                            class="text-xs font-black px-4 rounded-2xl text-white cursor-pointer flex-shrink-0 shadow-md transition-all hover:opacity-95"
                            style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);"
                        >
                            Kirim OTP
                        </button>
                    </div>
                </div>

                <!-- OTP Input -->
                <div class="space-y-1.5 text-left">
                    <label for="voter-otp" class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 block">Kode Verifikasi OTP</label>
                    <div class="relative">
                        <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        <input 
                            type="text" 
                            name="otp" 
                            id="voter-otp" 
                            required 
                            maxlength="6"
                            placeholder="6 digit OTP" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-10 pr-4 py-3 text-center font-black tracking-widest text-sm text-slate-900 outline-none focus:bg-white focus:border-[#ba7c21] transition-all"
                        >
                    </div>
                </div>

            @else
                
                <!-- Token Input -->
                <div class="space-y-1.5 text-left">
                    <label for="voter-token" class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 block">Masukkan Kode Token Anda</label>
                    <div class="relative">
                        <i class="fa-solid fa-ticket absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        <input 
                            type="text" 
                            name="token" 
                            id="voter-token" 
                            required
                            placeholder="VT-XXXXXX" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-10 pr-4 py-3 text-center font-mono font-black uppercase tracking-widest text-sm text-slate-900 outline-none focus:bg-white focus:border-[#ba7c21] transition-all"
                        >
                    </div>
                    <p class="text-[10px] text-slate-400">Minta kode token unik kepada panitia penyelenggara event ini.</p>
                </div>

            @endif

            <!-- Submit Button (Checkout) -->
            <button 
                type="submit" 
                class="w-full py-3.5 px-6 rounded-2xl text-white font-black text-sm shadow-lg shadow-[#ba7c21]/30 hover:shadow-[#ba7c21]/45 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150 cursor-pointer flex items-center justify-center space-x-2 border-none"
                style="background: linear-gradient(135deg, #ba7c21 0%, #9b5f1a 100%);"
            >
                @if($event->price > 0)
                    <i class="fa-solid fa-credit-card text-xs"></i>
                    <span>Lanjut ke Pembayaran QRIS</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                @else
                    <i class="fa-solid fa-check-to-slot text-xs"></i>
                    <span>Kirim Suara Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                @endif
            </button>

            <!-- Trust seal -->
            <div class="text-center pt-0.5">
                <span class="inline-flex items-center text-[10px] font-semibold text-slate-400 gap-1.5">
                    <i class="fa-solid fa-shield-halved text-emerald-600 text-[9px]"></i>
                    <span>Pembayaran Aman Resmi QRIS Bank Indonesia</span>
                </span>
            </div>
        </form>

        <div id="modal-error" class="hidden text-xs text-center font-bold text-red-600 mt-2"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openVotingModal(candidateId, candidateName, candidateNum, candidatePhoto) {
        document.getElementById('hidden-candidate-id').value = candidateId;
        document.getElementById('modal-candidate-name').innerText = candidateName;
        document.getElementById('modal-candidate-num').innerText = candidateNum;
        
        const imgEl = document.getElementById('modal-candidate-img');
        const placeholderEl = document.getElementById('modal-candidate-placeholder');
        if (candidatePhoto && candidatePhoto.trim() !== '') {
            imgEl.src = candidatePhoto;
            imgEl.style.display = 'block';
            if (placeholderEl) placeholderEl.style.display = 'none';
        } else {
            imgEl.src = '';
            imgEl.style.display = 'none';
            if (placeholderEl) placeholderEl.style.display = 'flex';
        }
        
        const modal = document.getElementById('voting-modal');
        modal.style.display = 'flex';
        
        // Initialize payment display and pills
        updateTotalPayment();
    }

    function closeVotingModal() {
        const modal = document.getElementById('voting-modal');
        modal.style.display = 'none';
        
        // Reset form inputs & errors
        const errorDiv = document.getElementById('modal-error');
        if (errorDiv) errorDiv.style.display = 'none';
        
        const emailInput = document.getElementById('voter-email');
        if (emailInput) emailInput.value = '';
        
        const otpInput = document.getElementById('voter-otp');
        if (otpInput) otpInput.value = '';
        
        const tokenInput = document.getElementById('voter-token');
        if (tokenInput) tokenInput.value = '';

        const qtyInput = document.getElementById('vote-quantity');
        if (qtyInput) {
            qtyInput.value = '1';
            updateTotalPayment();
        }

        const debugToast = document.getElementById('debug-otp-toast');
        if (debugToast) debugToast.style.display = 'none';
    }

    function incrementVotes() {
        const input = document.getElementById('vote-quantity');
        if (input) {
            input.value = parseInt(input.value || 0) + 1;
            updateTotalPayment();
        }
    }

    function decrementVotes() {
        const input = document.getElementById('vote-quantity');
        if (input) {
            const val = parseInt(input.value || 0);
            if (val > 1) {
                input.value = val - 1;
                updateTotalPayment();
            }
        }
    }

    function updateQuickVotePills(qty) {
        const pills = document.querySelectorAll('.quick-vote-btn');
        pills.forEach(pill => {
            const pillQty = parseInt(pill.getAttribute('data-qty'));
            const tag = pill.querySelector('.quick-qty-tag');
            if (pillQty === qty) {
                pill.style.background = 'linear-gradient(135deg, #fefcf6 0%, #fcf5e2 100%)';
                pill.style.borderColor = '#ba7c21';
                pill.style.borderWidth = '1.5px';
                pill.style.color = '#9b5f1a';
                pill.style.boxShadow = '0 4px 12px rgba(186,124,33,0.18)';
                pill.style.transform = 'translateY(-1px)';
                if (tag) tag.style.color = '#ba7c21';
            } else {
                pill.style.background = '#f8fafc';
                pill.style.borderColor = '#e2e8f0';
                pill.style.borderWidth = '1px';
                pill.style.color = '#1e293b';
                pill.style.boxShadow = 'none';
                pill.style.transform = 'none';
                if (tag) tag.style.color = '#94a3b8';
            }
        });
    }

    function setVotes(qty) {
        const input = document.getElementById('vote-quantity');
        if (input) {
            input.value = qty;
            updateTotalPayment();
        }
    }

    function updateTotalPayment() {
        const input = document.getElementById('vote-quantity');
        if (!input) return;
        const val = Math.max(1, parseInt(input.value || 1));
        input.value = val;
        const price = {{ $event->price ?? 0 }};
        const total = val * price;
        
        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(total).replace('IDR', 'Rp');
        
        document.getElementById('total-payment-display').textContent = formatted;
        
        const summaryQty = document.getElementById('summary-qty-text');
        if (summaryQty) {
            summaryQty.textContent = val + ' Suara Terpilih';
        }
        
        // Highlight corresponding pill
        updateQuickVotePills(val);
    }

    function requestOTP() {
        const email = document.getElementById('voter-email').value.trim();
        const errorDiv = document.getElementById('modal-error');
        const otpBtn = document.getElementById('otp-btn');
        
        if (!email) {
            errorDiv.innerText = "Masukkan alamat email terlebih dahulu.";
            errorDiv.style.display = 'block';
            return;
        }
        
        errorDiv.style.display = 'none';
        otpBtn.disabled = true;
        otpBtn.innerText = "Mengirim...";

        fetch(`{{ url('/event/' . $event->slug . '/otp') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            otpBtn.disabled = false;
            otpBtn.innerText = "Kirim OTP";
            
            if (data.success) {
                alert(data.message);
                
                // Show developer mode OTP if returned
                if (data.mock) {
                    const debugToast = document.getElementById('debug-otp-toast');
                    const debugCode = document.getElementById('debug-otp-code');
                    if (debugToast && debugCode) {
                        debugCode.innerText = data.mock;
                        debugToast.style.display = 'block';
                    }
                }
            } else {
                errorDiv.innerText = data.message;
                errorDiv.style.display = 'block';
            }
        })
        .catch(err => {
            console.error(err);
            otpBtn.disabled = false;
            otpBtn.innerText = "Kirim OTP";
            errorDiv.innerText = "Gagal menghubungi server untuk mengirim OTP.";
            errorDiv.style.display = 'block';
        });
    }
</script>
@endsection
