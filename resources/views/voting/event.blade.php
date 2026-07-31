@extends('layouts.app')

@section('title', $event->title . ' - eVoters')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-2 text-xs text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
        <span>&rarr;</span>
        <span class="text-gray-300">{{ $event->title }}</span>
    </div>

    <!-- Event Header Card -->
    <div class="glass-card rounded-3xl overflow-hidden border border-white/5 shadow-2xl relative">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Banner / Accent -->
            <div class="h-48 md:h-full w-full relative bg-slate-900 overflow-hidden">
                @if($event->banner_image)
                    <img src="{{ asset($event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-tr from-cyan-950 via-slate-900 to-emerald-950 flex items-center justify-center">
                        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:20px_20px]"></div>
                        <img src="{{ asset('images/logo.png') }}" alt="Placeholder Logo" class="h-8 w-auto opacity-20 filter grayscale">
                    </div>
                @endif
                
                <!-- Status Badge -->
                <div class="absolute top-4 left-4">
                    @if($event->isOpen())
                        <span class="inline-flex items-center px-2.5 py-1 rounded bg-green-500/10 border border-green-500/20 text-green-400 text-[10px] font-bold tracking-wider uppercase animate-pulse">
                            <i class="fa-solid fa-circle text-[6px] mr-1 text-green-400"></i> Voting Dibuka
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded bg-red-500/10 border border-red-500/20 text-red-400 text-[10px] font-bold tracking-wider uppercase">
                            Voting Ditutup
                        </span>
                    @endif
                </div>
            </div>

            <!-- Content Details (col-span 2) -->
            <div class="p-6 md:p-8 md:col-span-2 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white leading-snug">{{ $event->title }}</h1>
                    <p class="text-sm text-gray-400 leading-relaxed font-medium">
                        {{ $event->description ?: 'Tidak ada deskripsi detail.' }}
                    </p>
                </div>

                <!-- Date Info & Action -->
                <div class="pt-4 border-t border-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-gray-400">
                    <div class="space-y-1">
                        <div class="flex items-center text-gray-400">
                            <i class="fa-solid fa-calendar mr-2 text-indigo-400"></i>
                            <span>Pelaksanaan: 
                                <span class="text-white font-semibold">
                                    {{ $event->start_time ? $event->start_time->format('d M Y') : 'Mulai Sekarang' }}
                                    -
                                    {{ $event->end_time ? $event->end_time->format('d M Y H:i') : 'Selesai' }}
                                </span>
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('event.results', $event->slug) }}" class="text-indigo-400 hover:text-indigo-300 font-semibold flex items-center">
                        <i class="fa-solid fa-chart-simple mr-1.5"></i> Lihat Hasil Real-Time &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ballot Box Candidates Grid -->
    <div class="space-y-6">
        <div class="text-center space-y-1.5 max-w-xl mx-auto">
            <h2 class="text-xl md:text-2xl font-bold text-white">Kertas Suara Pemilihan</h2>
            <p class="text-xs text-gray-400">Silakan pelajari profil kandidat, lalu klik tombol "Pilih" di bawah kandidat pilihan Anda.</p>
        </div>

        @if($event->candidates->isEmpty())
            <div class="glass-card rounded-2xl p-12 text-center border border-white/5 text-gray-500">
                <i class="fa-solid fa-users-slash text-4xl block mb-2 text-gray-600"></i>
                <p class="text-sm">Belum ada kandidat terdaftar untuk event ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($event->candidates as $candidate)
                    <div class="glass-card rounded-3xl overflow-hidden border border-white/5 flex flex-col justify-between group hover:border-indigo-500/30 transition-all duration-300 shadow-xl">
                        <!-- Photo Header -->
                        <div class="h-60 w-full relative bg-slate-950 flex-shrink-0">
                            @if($candidate->photo)
                                <img src="{{ asset($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-slate-900 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-6xl text-gray-800"></i>
                                </div>
                            @endif
                            
                            <!-- Ballot Number -->
                            <div class="absolute top-4 left-4">
                                <div class="w-10 h-10 rounded-2xl bg-indigo-600 border border-indigo-400 font-extrabold text-white text-lg flex items-center justify-center shadow-lg shadow-indigo-500/20">
                                    {{ sprintf("%02d", $candidate->candidate_number) }}
                                </div>
                            </div>
                        </div>

                        <!-- Candidate info -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="text-lg font-extrabold text-white truncate">{{ $candidate->name }}</h3>
                                <p class="text-xs text-gray-400 line-clamp-4 leading-relaxed whitespace-pre-line font-medium">
                                    {{ $candidate->description ?: 'Kandidat ini belum mengisi deskripsi visi & misi.' }}
                                </p>
                            </div>

                            @if($event->isOpen())
                                <button 
                                    onclick="openVotingModal({{ $candidate->id }}, '{{ $candidate->name }}', '{{ sprintf('%02d', $candidate->candidate_number) }}')"
                                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs py-3 rounded-xl transition-all cursor-pointer shadow-lg shadow-indigo-600/10"
                                >
                                    Pilih Kandidat {{ sprintf("%02d", $candidate->candidate_number) }}
                                </button>
                            @else
                                <button 
                                    disabled
                                    class="w-full bg-white/5 border border-white/5 text-gray-500 font-semibold text-xs py-3 rounded-xl cursor-not-allowed"
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
<div id="voting-modal" class="fixed inset-0 z-50 overflow-y-auto hidden flex items-center justify-center p-4" style="background:rgba(15,23,42,0.45);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);">
    <div class="w-full rounded-[2.5rem] p-8 relative animate-scale-up border border-slate-200/80 shadow-2xl" style="max-width:440px;background:rgba(255,255,255,0.96);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);">
        
        <!-- Close button -->
        <button onclick="closeVotingModal()" class="absolute top-6 right-6 cursor-pointer text-slate-400 hover:text-slate-600 transition-colors p-1.5 rounded-full hover:bg-slate-100/80">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <!-- Header -->
        <div class="text-center" style="margin-bottom: 2rem;">
            <!-- Candidate Number Badge -->
            <div class="rounded-2xl flex items-center justify-center mx-auto mb-3 font-bold" style="background:linear-gradient(135deg,#059669,#0d9488);color:#fff;width:46px;height:46px;font-size:15px;box-shadow:0 4px 12px rgba(5,150,105,0.25);">
                <span id="modal-candidate-num">01</span>
            </div>
            
            <h3 class="font-black text-slate-900" style="font-size:18px;letter-spacing:-0.02em;">Konfirmasi Pilihan Anda</h3>
            
            <!-- Highlighted Selected Candidate Card (Spacious and No Overlaps) -->
            <div class="mt-3 p-3 rounded-2xl border border-emerald-500/10" style="background:rgba(16,185,129,0.04);">
                <p class="text-[9px] uppercase font-bold text-slate-400 tracking-wider">Kandidat Pilihan Anda</p>
                <p class="font-extrabold text-emerald-600 text-xs sm:text-sm mt-0.5" id="modal-candidate-name">Nama Kandidat</p>
            </div>
        </div>

        <form action="{{ route('event.vote', $event->slug) }}" method="POST" id="main-vote-form" class="space-y-4">
            @csrf
            
            <!-- Hidden inputs -->
            <input type="hidden" name="candidate_id" id="hidden-candidate-id" value="">
            <input type="hidden" name="voting_type" value="{{ $event->voting_type }}">

            @if($event->price > 0)
                <!-- Name Input -->
                <div class="text-left space-y-1.5">
                    <label for="voter-name" class="font-bold uppercase block text-[10px] tracking-wider text-slate-500">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-slate-400 text-[13px]"></i>
                        </div>
                        <input 
                            type="text" 
                            name="name" 
                            id="voter-name" 
                            required
                            placeholder="Masukkan nama lengkap Anda" 
                            class="w-full pr-4 py-3 rounded-2xl text-sm focus:outline-none transition-all"
                            style="padding-left: 2.75rem !important; background:#f8fafc; border:1px solid #e2e8f0; color:#0f172a;"
                        >
                    </div>
                </div>

                <!-- Price + Quantity -->
                <div class="flex items-center gap-3">
                    <div class="py-2.5 px-3 rounded-2xl text-center flex-shrink-0 border border-emerald-500/20 bg-emerald-50/50" style="min-width:85px;">
                        <div class="font-bold uppercase leading-none text-[8px] text-slate-400 tracking-wider">Per Vote</div>
                        <div class="font-black mt-1 text-emerald-600" style="font-size:13px;">Rp {{ number_format($event->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="flex-grow flex items-center rounded-2xl p-1 bg-slate-50 border border-slate-200/80">
                        <button type="button" onclick="decrementVotes()" class="rounded-xl flex items-center justify-center cursor-pointer select-none flex-shrink-0 transition-all hover:bg-slate-200 bg-slate-100 text-slate-600" style="width:36px;height:36px;border:none;">
                            <i class="fa-solid fa-minus text-xs"></i>
                        </button>
                        <input 
                            type="number" 
                            name="quantity" 
                            id="vote-quantity" 
                            required 
                            min="1"
                            value="1" 
                            class="flex-grow text-center font-extrabold focus:outline-none p-0 text-slate-900"
                            style="background:transparent !important;border:none !important;font-size:16px;width:50px;box-shadow:none !important;"
                        >
                        <button type="button" onclick="incrementVotes()" class="rounded-xl flex items-center justify-center cursor-pointer select-none flex-shrink-0 transition-all hover:bg-slate-200 bg-slate-100 text-slate-600" style="width:36px;height:36px;border:none;">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Quick Selection (2-col scrollable grid) -->
                @php
                    $multipliers = [1, 2, 5, 10, 20, 50];
                @endphp
                <div class="text-left space-y-1.5">
                    <label class="font-bold uppercase block text-[10px] tracking-wider text-slate-500">Pilih Cepat Nominal</label>
                    <div class="grid grid-cols-2 gap-2 pr-1" style="max-height:108px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:#cbd5e1 transparent;">
                        @foreach($multipliers as $mult)
                            <button 
                                type="button" 
                                onclick="setVotes({{ $mult }})" 
                                data-qty="{{ $mult }}"
                                class="quick-vote-btn py-2.5 px-3 rounded-2xl text-xs font-bold transition-all cursor-pointer focus:outline-none text-center"
                                style="background:#f8fafc;border:1px solid #e2e8f0;color:#334155;"
                            >
                                <span style="font-size:12px;">Rp {{ number_format($event->price * $mult / 1000, 0, ',', '.') }}k</span>
                                <span style="color:#94a3b8;font-size:9px;font-weight:400;" class="ml-1">({{ $mult }}x)</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Total Payment -->
                <div class="p-4 rounded-2xl text-center relative overflow-hidden border border-emerald-500/20" style="background:linear-gradient(135deg,#ecfdf5,#f0fdfa);">
                    <div style="position:absolute;top:-20px;left:-20px;width:60px;height:60px;background:rgba(16,185,129,0.06);border-radius:50%;filter:blur(20px);"></div>
                    <div style="position:absolute;bottom:-20px;right:-20px;width:60px;height:60px;background:rgba(13,148,136,0.06);border-radius:50%;filter:blur(20px);"></div>
                    <div class="flex items-center justify-between relative" style="z-index:1;">
                        <span class="font-bold uppercase text-[10px] text-slate-500 tracking-wider">Total Pembayaran</span>
                        <span id="total-payment-display" class="font-black tracking-tight text-emerald-600 text-xl">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            @elseif($event->voting_type === 'public_email')
                
                <!-- Email Input -->
                <div class="space-y-1.5 text-left">
                    <label for="voter-email" class="text-xs font-bold uppercase tracking-wider text-slate-500">Alamat Email</label>
                    <div class="flex gap-2">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-slate-400 text-[13px]"></i>
                            </div>
                            <input 
                                type="email" 
                                name="email" 
                                id="voter-email" 
                                required
                                placeholder="nama@email.com" 
                                class="w-full pr-4 py-3 rounded-2xl text-sm focus:outline-none"
                                style="padding-left: 2.75rem !important; background:#f8fafc; border:1px solid #e2e8f0; color:#0f172a;"
                            >
                        </div>
                        <button 
                            type="button" 
                            id="otp-btn"
                            onclick="requestOTP()" 
                            class="text-xs font-bold px-4 rounded-2xl transition-all cursor-pointer flex-shrink-0 hover:bg-emerald-700 bg-emerald-600 text-white shadow-md shadow-emerald-600/10"
                        >
                            Kirim OTP
                        </button>
                    </div>
                </div>

                <!-- OTP Input -->
                <div class="space-y-1.5 text-left">
                    <label for="voter-otp" class="text-xs font-bold uppercase tracking-wider text-slate-500">Kode Verifikasi OTP</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-key text-slate-400 text-[13px]"></i>
                        </div>
                        <input 
                            type="text" 
                            name="otp" 
                            id="voter-otp" 
                            required 
                            maxlength="6"
                            placeholder="Masukkan 6 digit kode OTP" 
                            class="w-full pr-4 py-3 rounded-2xl text-center font-bold tracking-widest text-sm focus:outline-none"
                            style="padding-left: 2.75rem !important; background:#f8fafc; border:1px solid #e2e8f0; color:#0f172a;"
                        >
                    </div>
                </div>

                <!-- Local Developer Mode OTP Notice Alert -->
                @if(config('app.env') === 'local')
                    <div id="debug-otp-toast" class="p-3 rounded-2xl text-[10px] hidden font-semibold" style="background:#ecfdf5;border:1px solid #a7f3d0;color:#047857;">
                        <i class="fa-solid fa-bug mr-1"></i> Developer Mode OTP: 
                        <span id="debug-otp-code" class="font-bold select-all underline" style="color:#059669;">######</span>
                    </div>
                @endif

            @else
                
                <!-- Token Input -->
                <div class="space-y-1.5 text-left">
                    <label for="voter-token" class="text-xs font-bold uppercase tracking-wider text-slate-500">Masukkan Kode Token Anda</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-ticket text-slate-400 text-[13px]"></i>
                        </div>
                        <input 
                            type="text" 
                            name="token" 
                            id="voter-token" 
                            required
                            placeholder="Contoh: VT-XXXXXX" 
                            class="w-full pr-4 py-3 rounded-2xl text-center font-mono font-bold uppercase tracking-widest text-sm focus:outline-none"
                            style="padding-left: 2.75rem !important; background:#f8fafc; border:1px solid #e2e8f0; color:#0f172a;"
                        >
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Minta kode token unik kepada panitia penyelenggara event voting ini.</p>
                </div>

            @endif

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full font-bold py-3.5 px-4 rounded-2xl transition-all cursor-pointer text-sm text-center flex items-center justify-center space-x-2 hover:opacity-95 text-white bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg shadow-emerald-600/20 border-none"
            >
                @if($event->price > 0)
                    <span>Bayar Sekarang & Lanjut ke QRIS</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                @else
                    <span>Kirim Suara Saya</span>
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                @endif
            </button>
        </form>

        <div id="modal-error" class="text-xs mt-3 hidden text-center font-medium" style="color:#dc2626;"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openVotingModal(candidateId, candidateName, candidateNum) {
        document.getElementById('hidden-candidate-id').value = candidateId;
        document.getElementById('modal-candidate-name').innerText = candidateName;
        document.getElementById('modal-candidate-num').innerText = candidateNum;
        
        const modal = document.getElementById('voting-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Initialize payment display and pills
        updateTotalPayment();
    }

    function closeVotingModal() {
        const modal = document.getElementById('voting-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        
        // Reset form inputs & errors
        document.getElementById('modal-error').classList.add('hidden');
        
        const emailInput = document.getElementById('voter-email');
        if (emailInput) emailInput.value = '';
        
        const nameInput = document.getElementById('voter-name');
        if (nameInput) nameInput.value = '';
        
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
        if (debugToast) debugToast.classList.add('hidden');
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
            if (pillQty === qty) {
                pill.style.background = '#ecfdf5';
                pill.style.borderColor = '#34d399';
                pill.style.color = '#059669';
            } else {
                pill.style.background = '#f8fafc';
                pill.style.borderColor = '#e2e8f0';
                pill.style.color = '#334155';
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
        
        // Highlight corresponding pill
        updateQuickVotePills(val);
    }

    function requestOTP() {
        const email = document.getElementById('voter-email').value.trim();
        const errorDiv = document.getElementById('modal-error');
        const otpBtn = document.getElementById('otp-btn');
        
        if (!email) {
            errorDiv.innerText = "Masukkan alamat email terlebih dahulu.";
            errorDiv.classList.remove('hidden');
            return;
        }
        
        errorDiv.classList.add('hidden');
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
                        debugToast.classList.remove('hidden');
                    }
                }
            } else {
                errorDiv.innerText = data.message;
                errorDiv.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            otpBtn.disabled = false;
            otpBtn.innerText = "Kirim OTP";
            errorDiv.innerText = "Gagal menghubungi server untuk mengirim OTP.";
            errorDiv.classList.remove('hidden');
        });
    }
</script>
@endsection
