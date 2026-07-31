@extends('layouts.app')

@section('title', 'Checkout Pembayaran - eVoters')

@section('content')
<div class="max-w-xl mx-auto py-8 md:py-12">
    <!-- Stepper Progress Tracker -->
    <div class="flex items-center justify-between max-w-sm mx-auto mb-10 px-4">
        <!-- Step 1 -->
        <div class="flex flex-col items-center flex-1 relative">
            <div class="w-8 h-8 rounded-full bg-emerald-500 text-white font-extrabold text-xs flex items-center justify-center shadow-lg shadow-emerald-500/25 border-2 border-emerald-200">
                <i class="fa-solid fa-check"></i>
            </div>
            <span class="text-[9px] font-black text-slate-400 mt-2 uppercase tracking-wider">Event</span>
        </div>
        
        <!-- Line -->
        <div class="h-[2px] bg-emerald-500 flex-grow -mt-6"></div>

        <!-- Step 2 -->
        <div class="flex flex-col items-center flex-1 relative">
            <div class="w-8 h-8 rounded-full bg-emerald-500 text-white font-extrabold text-xs flex items-center justify-center shadow-lg shadow-emerald-500/25 border-2 border-emerald-200">
                <i class="fa-solid fa-check"></i>
            </div>
            <span class="text-[9px] font-black text-slate-400 mt-2 uppercase tracking-wider">Konfirmasi</span>
        </div>

        <!-- Line -->
        <div class="h-[2px] bg-emerald-500/60 flex-grow -mt-6"></div>

        <!-- Step 3 -->
        <div class="flex flex-col items-center flex-1 relative">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black text-xs flex items-center justify-center shadow-lg shadow-emerald-600/30 border-2 border-emerald-100 animate-pulse">
                3
            </div>
            <span class="text-[9px] font-black text-slate-800 mt-2 uppercase tracking-wider">Bayar</span>
        </div>
    </div>

    <!-- Main Glass Checkout Card -->
    <div class="glass-card rounded-[2.75rem] p-6 md:p-10 border border-slate-200/80 shadow-2xl relative overflow-hidden bg-white/95">
        <!-- Ambient light backdrops -->
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-emerald-500/5 rounded-full blur-[80px]"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-teal-500/5 rounded-full blur-[80px]"></div>

        <div class="relative z-10 space-y-6">
            <!-- Header section -->
            <div class="text-center space-y-2">
                <span class="inline-flex items-center px-3.5 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-[9px] font-black tracking-widest uppercase">
                    <i class="fa-solid fa-shield-halved mr-1.5 text-[10px]"></i> Secure Checkout
                </span>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight" style="font-size: 26px; letter-spacing: -0.03em;">Selesaikan Voting Anda</h2>
                <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">Suara Anda bernilai untuk menentukan pemenang. Lanjutkan ke metode pembayaran aman.</p>
            </div>

            <!-- Candidate Selected Profile Card -->
            <div class="flex items-center space-x-4 p-4.5 rounded-[2rem] bg-slate-50/50 border border-slate-200/30 hover:bg-slate-50 transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 bg-white border border-slate-200/50 shadow-sm flex items-center justify-center">
                    @if($candidate->photo)
                        <img src="{{ asset($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-user text-2xl text-slate-300"></i>
                    @endif
                </div>
                <div class="text-left flex-grow space-y-0.5">
                    <span class="text-[8px] uppercase font-bold text-emerald-600 bg-emerald-50 border border-emerald-100/55 px-2 py-0.5 rounded-lg tracking-wider">Kandidat Pilihan</span>
                    <h4 class="font-black text-slate-800 text-sm leading-snug mt-1">{{ $candidate->name }}</h4>
                    <p class="text-[10px] text-slate-500 line-clamp-1 mt-0.5">{{ $event->title }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-2xl bg-slate-100 text-slate-700 text-xs font-black border border-slate-200/40 shadow-sm">
                        {{ $vote->quantity }}x Vote
                    </span>
                </div>
            </div>

            <!-- Ticket-style Billing Breakdown -->
            <div class="relative rounded-3xl border border-slate-200/50 bg-white/50 overflow-hidden shadow-sm">
                <!-- Left Ticket Notch -->
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-4 h-8 bg-[#f8fafc] border-r border-slate-200/50 rounded-r-full z-20"></div>
                <!-- Right Ticket Notch -->
                <div class="absolute right-0 top-1/2 -translate-y-1/2 w-4 h-8 bg-[#f8fafc] border-l border-slate-200/50 rounded-l-full z-20"></div>

                <div class="p-6 space-y-4 text-left text-xs relative z-10">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold uppercase text-[9px] tracking-wider">No. Referensi</span>
                        <span class="font-mono text-slate-700 font-extrabold bg-slate-100/80 border border-slate-200/40 px-2.5 py-0.5 rounded-lg text-[10px]">{{ $vote->payment_ref }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold uppercase text-[9px] tracking-wider">Harga per Vote</span>
                        <span class="text-slate-700 font-bold text-sm">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold uppercase text-[9px] tracking-wider">Biaya Layanan</span>
                        <span class="text-emerald-600 font-extrabold uppercase text-[9px] tracking-wider bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">Gratis</span>
                    </div>

                    <!-- Dashed line for ticket look -->
                    <div class="border-t border-dashed border-slate-200 my-4 mx-2"></div>

                    <div class="flex justify-between items-center pt-1">
                        <span class="text-slate-400 font-bold uppercase text-[9px] tracking-wider">Batas Pembayaran</span>
                        <span class="text-amber-600 font-extrabold flex items-center space-x-1">
                            <i class="fa-regular fa-clock text-xs"></i>
                            <span id="countdown" class="font-mono text-xs">14:59</span>
                        </span>
                    </div>
                </div>

                <!-- Total Payment Highlight -->
                <div class="bg-gradient-to-r from-emerald-500/10 to-teal-500/5 border-t border-slate-200/30 px-6 py-5 flex items-center justify-between relative z-10">
                    <span class="text-slate-800 font-black text-xs uppercase tracking-widest">Total Pembayaran</span>
                    <span class="text-2xl font-black text-emerald-600 tracking-tight">Rp {{ number_format($vote->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Methods Supported Icons -->
            <div class="space-y-3 pt-1 text-center">
                <span class="text-[9px] uppercase font-bold text-slate-400 tracking-widest block">Metode Pembayaran Didukung</span>
                <div class="flex flex-wrap items-center justify-center gap-4 py-2.5 px-4 rounded-2xl bg-slate-50/50 border border-slate-200/20 max-w-sm mx-auto">
                    <span class="text-[11px] font-black italic tracking-wider text-slate-800">
                        QR<span class="text-cyan-500">I</span><span class="text-emerald-500">S</span>
                    </span>
                    <span class="h-3 w-[1px] bg-slate-200"></span>
                    <span class="text-[10px] font-black tracking-tight text-blue-600">GoPay</span>
                    <span class="h-3 w-[1px] bg-slate-200"></span>
                    <span class="text-[10px] font-extrabold tracking-tight text-orange-500">ShopeePay</span>
                    <span class="h-3 w-[1px] bg-slate-200"></span>
                    <span class="text-[10px] font-extrabold text-indigo-600">Virtual Account</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 pt-3">
                <!-- Main Pay Button -->
                <button type="button" onclick="triggerPayment()" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-sm py-4 px-6 rounded-2xl shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/30 transition-all cursor-pointer flex items-center justify-center space-x-2 border-none transform hover:-translate-y-0.5 active:translate-y-0 duration-150">
                    <i class="fa-solid fa-credit-card text-base"></i>
                    <span>Pilih Metode & Bayar Sekarang</span>
                </button>

                <!-- Local Developer Mock Trigger -->
                @if(config('app.env') === 'local')
                    <form action="{{ route('vote.pay.confirm', $vote->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-slate-50 hover:bg-slate-100 border border-slate-200/80 text-slate-500 hover:text-slate-700 font-bold text-xs py-3 px-6 rounded-2xl transition-all cursor-pointer flex items-center justify-center space-x-2 shadow-sm">
                            <i class="fa-solid fa-square-check text-slate-400"></i>
                            <span>Simulasikan Sukses (Hanya Mode Developer)</span>
                        </button>
                    </form>
                @endif
                
                <!-- Cancel Link -->
                <div class="pt-2 flex flex-col items-center space-y-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-1.5"></i> Batal & Kembali ke Beranda
                    </a>
                    
                    <!-- Secure transaction seal -->
                    <span class="inline-flex items-center text-[10px] text-slate-400 space-x-1">
                        <i class="fa-solid fa-lock text-[9px] text-slate-400"></i>
                        <span>Enkripsi SSL 256-bit Aman & Terpercaya</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // 15 minutes simple countdown timer
    let duration = 15 * 60;
    const countdownEl = document.getElementById('countdown');
    
    const interval = setInterval(() => {
        let minutes = Math.floor(duration / 60);
        let seconds = duration % 60;
        
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        
        countdownEl.textContent = `${minutes}:${seconds}`;
        
        if (duration <= 0) {
            clearInterval(interval);
            countdownEl.textContent = "Kedaluwarsa";
        }
        
        duration--;
    }, 1000);

    // Auto-redirect to DOKU when page is loaded
    const paymentUrl = '{{ $vote->payment_url }}';
    if (paymentUrl) {
        setTimeout(() => {
            triggerPayment();
        }, 800); // Small delay to let the page render smoothly
    }

    function triggerPayment() {
        if (!paymentUrl) {
            alert('Gagal mendapatkan URL pembayaran dari DOKU.');
            return;
        }
        window.location.href = paymentUrl;
    }
</script>
@endsection
