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
<div id="voting-modal" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center p-4" style="background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
    <div class="w-full relative bg-white text-slate-800 my-auto" style="max-width: 430px; border-radius: 28px; padding: 24px 26px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.8);">
        
        <!-- Header Modal with Close Button in flex row -->
        <div class="flex items-start justify-between gap-3 mb-4">
            <div>
                <h3 style="font-size: 19px; font-weight: 900; color: #0f172a; margin: 0; line-height: 1.25; letter-spacing: -0.02em;">Konfirmasi Pilihan Anda</h3>
                <p style="font-size: 12px; color: #64748b; margin-top: 3px; margin-bottom: 0;">Pastikan kandidat dan jumlah suara sudah sesuai.</p>
            </div>
            <!-- Close button -->
            <button type="button" onclick="closeVotingModal()" class="cursor-pointer transition-all flex items-center justify-center flex-shrink-0" style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; border: none; color: #64748b;" onmouseover="this.style.background='#e2e8f0';this.style.color='#0f172a'" onmouseout="this.style.background='#f1f5f9';this.style.color='#64748b'">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Selected Candidate Card with Photo -->
        <div class="flex items-center gap-3.5 mb-4" style="background: linear-gradient(135deg, #fffdf8 0%, #fbf5e6 100%); border: 1px solid #f1ddb0; border-radius: 20px; padding: 12px 14px;">
            <!-- Candidate Photo / Avatar Container -->
            <div class="flex-shrink-0 flex items-center justify-center overflow-hidden" style="width: 56px; height: 56px; border-radius: 14px; border: 1.5px solid #d4a359; background: #ffffff; box-shadow: 0 3px 8px rgba(186,124,33,0.15);">
                <img id="modal-candidate-img" src="" alt="Foto Kandidat" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                <div id="modal-candidate-placeholder" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #fef3c7; color: #b45309;">
                    <i class="fa-solid fa-user text-xl"></i>
                </div>
            </div>

            <!-- Candidate Details -->
            <div class="min-w-0 flex-grow">
                <div class="flex items-center gap-1.5 mb-0.5">
                    <span style="background: linear-gradient(135deg, #ba7c21, #9b5f1a); color: #ffffff; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 6px; letter-spacing: 0.5px; line-height: normal;">
                        NO. <span id="modal-candidate-num">01</span>
                    </span>
                    <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; color: #9b5f1a; letter-spacing: 0.5px;">Kandidat Pilihan</span>
                </div>
                <h4 id="modal-candidate-name" style="font-size: 15px; font-weight: 900; color: #0f172a; margin: 3px 0 2px 0; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Nama Kandidat</h4>
                <p style="font-size: 11px; color: #64748b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $event->title }}</p>
            </div>
        </div>

        <form action="{{ route('event.vote', $event->slug) }}" method="POST" id="main-vote-form" class="space-y-3.5">
            @csrf
            
            <!-- Hidden inputs -->
            <input type="hidden" name="candidate_id" id="hidden-candidate-id" value="">
            <input type="hidden" name="voting_type" value="{{ $event->voting_type }}">

            @if($event->price > 0)
                <!-- Name Input -->
                <div class="text-left">
                    <label for="voter-name" style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; display: block; margin-bottom: 5px;">Nama Lengkap</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-user" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none;"></i>
                        <input 
                            type="text" 
                            name="name" 
                            id="voter-name" 
                            required
                            value="{{ auth()->check() ? auth()->user()->name : old('name') }}"
                            placeholder="Masukkan nama lengkap Anda" 
                            style="width: 100%; box-sizing: border-box; padding: 10px 14px 10px 38px; border-radius: 14px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1; background: #f8fafc; color: #0f172a; outline: none; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#ba7c21';this.style.background='#ffffff';this.style.boxShadow='0 0 0 3px rgba(186,124,33,0.12)'"
                            onblur="this.style.borderColor='#cbd5e1';this.style.background='#f8fafc';this.style.boxShadow='none'"
                        >
                    </div>
                </div>

                <!-- Price + Quantity -->
                <div class="flex items-center gap-2.5">
                    <div style="min-width: 90px; padding: 7px 10px; border-radius: 14px; text-align: center; border: 1px solid #f1ddb0; background: #fbf5e6; box-sizing: border-box; flex-shrink: 0;">
                        <div style="font-size: 8px; font-weight: 800; text-transform: uppercase; color: #8c601d; letter-spacing: 0.5px;">Per Vote</div>
                        <div style="font-size: 13px; font-weight: 900; color: #ba7c21; margin-top: 1px;">Rp {{ number_format($event->price, 0, ',', '.') }}</div>
                    </div>
                    <div style="flex-grow: 1; display: flex; align-items: center; justify-content: space-between; padding: 3px 5px; border-radius: 14px; border: 1px solid #cbd5e1; background: #f8fafc; box-sizing: border-box;">
                        <button type="button" onclick="decrementVotes()" style="width: 34px; height: 34px; border-radius: 10px; border: none; background: #ffffff; color: #334155; font-size: 12px; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08); transition: background 0.15s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <input 
                            type="number" 
                            name="quantity" 
                            id="vote-quantity" 
                            required 
                            min="1"
                            value="1" 
                            style="width: 50px; text-align: center; font-size: 16px; font-weight: 900; color: #0f172a; border: none; background: transparent; outline: none;"
                        >
                        <button type="button" onclick="incrementVotes()" style="width: 34px; height: 34px; border-radius: 10px; border: none; background: #ffffff; color: #334155; font-size: 12px; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08); transition: background 0.15s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Quick Selection (3-col clean grid, no scrolling) -->
                @php
                    $multipliers = [1, 2, 5, 10, 20, 50];
                @endphp
                <div class="text-left">
                    <label style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; display: block; margin-bottom: 5px;">Pilih Cepat Nominal</label>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px;">
                        @foreach($multipliers as $mult)
                            <button 
                                type="button" 
                                onclick="setVotes({{ $mult }})" 
                                data-qty="{{ $mult }}"
                                class="quick-vote-btn"
                                style="padding: 7px 4px; border-radius: 12px; border: 1px solid #e2e8f0; background: #f8fafc; color: #1e293b; cursor: pointer; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1px; transition: all 0.15s ease;"
                            >
                                <span style="font-size: 12px; font-weight: 800; line-height: 1.1;">Rp {{ number_format($event->price * $mult / 1000, 0, ',', '.') }}k</span>
                                <span class="quick-qty-tag" style="font-size: 9px; font-weight: 700; color: #94a3b8;">({{ $mult }}x)</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Total Payment -->
                <div style="background: linear-gradient(135deg, #fffdf8 0%, #fbf5e6 100%); border: 1px solid #f1ddb0; border-radius: 16px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <span style="font-size: 9px; font-weight: 800; text-transform: uppercase; color: #8c601d; letter-spacing: 0.5px; display: block;">Total Pembayaran</span>
                        <span id="summary-qty-text" style="font-size: 11px; font-weight: 700; color: #64748b; display: block; margin-top: 1px;">1 Suara Terpilih</span>
                    </div>
                    <span id="total-payment-display" style="font-size: 19px; font-weight: 900; color: #ba7c21; letter-spacing: -0.5px;">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                </div>
            @elseif($event->voting_type === 'public_email')
                
                <!-- Email Input -->
                <div class="space-y-1.5 text-left">
                    <label for="voter-email" style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; display: block;">Alamat Email</label>
                    <div class="flex gap-2">
                        <div style="position: relative; flex-grow: 1;">
                            <i class="fa-solid fa-envelope" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none;"></i>
                            <input 
                                type="email" 
                                name="email" 
                                id="voter-email" 
                                required
                                value="{{ auth()->check() ? auth()->user()->email : old('email') }}"
                                placeholder="nama@email.com" 
                                style="width: 100%; box-sizing: border-box; padding: 10px 14px 10px 38px; border-radius: 14px; font-size: 13px; font-weight: 600; border: 1px solid #cbd5e1; background: #f8fafc; color: #0f172a; outline: none;"
                            >
                        </div>
                        <button 
                            type="button" 
                            id="otp-btn"
                            onclick="requestOTP()" 
                            style="font-size: 12px; font-weight: 800; padding: 0 14px; border-radius: 14px; border: none; background: linear-gradient(135deg, #ba7c21, #9b5f1a); color: #ffffff; cursor: pointer; flex-shrink: 0;"
                        >
                            Kirim OTP
                        </button>
                    </div>
                </div>

                <!-- OTP Input -->
                <div class="space-y-1.5 text-left">
                    <label for="voter-otp" style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; display: block;">Kode Verifikasi OTP</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-key" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none;"></i>
                        <input 
                            type="text" 
                            name="otp" 
                            id="voter-otp" 
                            required 
                            maxlength="6"
                            placeholder="Masukkan 6 digit kode OTP" 
                            style="width: 100%; box-sizing: border-box; padding: 10px 14px 10px 38px; border-radius: 14px; text-align: center; font-weight: 800; letter-spacing: 4px; font-size: 14px; border: 1px solid #cbd5e1; background: #f8fafc; color: #0f172a; outline: none;"
                        >
                    </div>
                </div>

                <!-- Local Developer Mode OTP Notice Alert -->
                @if(config('app.env') === 'local')
                    <div id="debug-otp-toast" style="display: none; padding: 8px 12px; border-radius: 12px; font-size: 11px; font-weight: 600; background: #fbf5e6; border: 1px solid #f1ddb0; color: #9b5f1a;">
                        <i class="fa-solid fa-bug mr-1"></i> Developer Mode OTP: 
                        <span id="debug-otp-code" class="font-bold select-all underline" style="color:#ba7c21;">######</span>
                    </div>
                @endif

            @else
                
                <!-- Token Input -->
                <div class="space-y-1.5 text-left">
                    <label for="voter-token" style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; display: block;">Masukkan Kode Token Anda</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-ticket" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none;"></i>
                        <input 
                            type="text" 
                            name="token" 
                            id="voter-token" 
                            required
                            placeholder="Contoh: VT-XXXXXX" 
                            style="width: 100%; box-sizing: border-box; padding: 10px 14px 10px 38px; border-radius: 14px; text-align: center; font-family: monospace; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; font-size: 14px; border: 1px solid #cbd5e1; background: #f8fafc; color: #0f172a; outline: none;"
                        >
                    </div>
                    <p style="font-size: 10px; color: #94a3b8; margin-top: 4px;">Minta kode token unik kepada panitia penyelenggara event voting ini.</p>
                </div>

            @endif

            <!-- Submit Button (Checkout) -->
            <button 
                type="submit" 
                style="width: 100%; box-sizing: border-box; padding: 13px 20px; border-radius: 14px; border: none; background: linear-gradient(135deg, #ba7c21 0%, #9b5f1a 100%); color: #ffffff; font-size: 14px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 14px; box-shadow: 0 8px 20px -4px rgba(186,124,33,0.4); transition: opacity 0.15s;"
                onmouseover="this.style.opacity='0.95'"
                onmouseout="this.style.opacity='1'"
            >
                @if($event->price > 0)
                    <i class="fa-solid fa-cart-shopping text-xs"></i>
                    <span>Checkout</span>
                    <i class="fa-solid fa-arrow-right text-xs" style="margin-left: 2px;"></i>
                @else
                    <i class="fa-solid fa-check-to-slot text-xs"></i>
                    <span>Kirim Suara Saya</span>
                    <i class="fa-solid fa-arrow-right text-xs" style="margin-left: 2px;"></i>
                @endif
            </button>
        </form>

        <div id="modal-error" style="display: none; font-size: 12px; margin-top: 10px; text-align: center; font-weight: 600; color: #dc2626;"></div>
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
                pill.style.background = '#fef3c7';
                pill.style.borderColor = '#ba7c21';
                pill.style.color = '#92400e';
                pill.style.boxShadow = '0 2px 6px rgba(186,124,33,0.15)';
                if (tag) tag.style.color = '#b45309';
            } else {
                pill.style.background = '#f8fafc';
                pill.style.borderColor = '#e2e8f0';
                pill.style.color = '#1e293b';
                pill.style.boxShadow = 'none';
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
