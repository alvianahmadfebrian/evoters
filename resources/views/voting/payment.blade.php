@extends('layouts.app')

@section('title', 'Pembayaran QRIS Resmi - eVoters')

@section('content')
<div class="max-w-xl mx-auto py-6 md:py-10 px-4">
    <!-- Stepper Progress Tracker -->
    <div class="flex items-center justify-between max-w-sm mx-auto mb-8 px-4">
        <!-- Step 1 -->
        <div class="flex flex-col items-center flex-1 relative">
            <div class="w-8 h-8 rounded-full text-white font-extrabold text-xs flex items-center justify-center shadow-md shadow-[#ba7c21]/25 border-2 border-[#f7e6bb]" style="background: #ba7c21;">
                <i class="fa-solid fa-check"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-400 mt-2 uppercase tracking-wider">Event</span>
        </div>
        
        <!-- Line -->
        <div class="h-[2px] flex-grow -mt-6" style="background: #ba7c21;"></div>

        <!-- Step 2 -->
        <div class="flex flex-col items-center flex-1 relative">
            <div class="w-8 h-8 rounded-full text-white font-extrabold text-xs flex items-center justify-center shadow-md shadow-[#ba7c21]/25 border-2 border-[#f7e6bb]" style="background: #ba7c21;">
                <i class="fa-solid fa-check"></i>
            </div>
            <span class="text-[9px] font-bold text-slate-400 mt-2 uppercase tracking-wider">Pilih</span>
        </div>

        <!-- Line -->
        <div class="h-[2px] flex-grow -mt-6" style="background: #ba7c21;"></div>

        <!-- Step 3 -->
        <div class="flex flex-col items-center flex-1 relative">
            <div class="w-8 h-8 rounded-full text-white font-black text-xs flex items-center justify-center shadow-lg shadow-[#ba7c21]/30 border-2 border-[#f7e6bb] animate-pulse" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                3
            </div>
            <span class="text-[9px] font-black text-[#9b5f1a] mt-2 uppercase tracking-wider">Bayar QRIS</span>
        </div>
    </div>

    <!-- Main Payment Container Card -->
    <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] p-5 md:p-8 border border-slate-200/90 shadow-xl relative overflow-hidden space-y-6">
        
        <!-- Ambient subtle background glow -->
        <div class="absolute -top-32 -left-32 w-64 h-64 bg-[#ba7c21]/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-64 h-64 bg-[#9b5f1a]/5 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Header -->
        <div class="text-center space-y-1.5 relative z-10">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full text-[10px] font-extrabold tracking-wider uppercase bg-amber-50 text-amber-800 border border-amber-200/80" id="payment-status-badge">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                <span>Menunggu Pembayaran</span>
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight" style="letter-spacing: -0.03em;">Selesaikan Pembayaran Voting</h2>
            <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">Pindai kode QRIS di bawah menggunakan aplikasi perbankan atau e-wallet pilihan Anda.</p>
        </div>

        <!-- Candidate Selected Summary Bar -->
        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70 relative z-10">
            <div class="flex items-center space-x-3 min-w-0">
                <div class="w-11 h-11 rounded-xl overflow-hidden flex-shrink-0 bg-white border border-slate-200 shadow-sm flex items-center justify-center">
                    @if($candidate->photo)
                        <img src="{{ asset($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-user text-base text-slate-400"></i>
                    @endif
                </div>
                <div class="text-left truncate">
                    <span class="text-[8px] uppercase font-bold px-1.5 py-0.5 rounded bg-amber-100 text-amber-900">Kandidat</span>
                    <h4 class="font-extrabold text-slate-800 text-xs md:text-sm truncate mt-0.5">{{ $candidate->name }}</h4>
                    <p class="text-[10px] text-slate-500 truncate">{{ $event->title }}</p>
                </div>
            </div>
            <div class="text-right flex-shrink-0 pl-2">
                <span class="inline-block px-2 py-0.5 rounded-lg bg-white text-slate-800 text-[11px] font-bold border border-slate-200 shadow-xs">
                    {{ $vote->quantity }}x Suara
                </span>
                <div class="text-xs font-black text-[#ba7c21] mt-0.5">Rp {{ number_format($vote->amount, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- STANDARDIZED QRIS OFFICIAL VOUCHER CARD -->
        <div class="relative bg-white rounded-3xl p-5 md:p-6 border-2 border-slate-200/90 shadow-md text-center overflow-hidden z-10">
            
            <!-- QRIS Top Official Header Strip -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <!-- QRIS Official Logo Style -->
                <div class="flex items-center space-x-1.5">
                    <span class="text-base font-black italic tracking-tighter text-slate-900 font-sans">
                        QR<span class="text-red-600">I</span>S
                    </span>
                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest pl-1 border-l border-slate-200">
                        Pembayaran Nasional
                    </span>
                </div>
                <!-- GPN Badge -->
                <div class="flex items-center space-x-1 px-2 py-0.5 rounded bg-slate-100 border border-slate-200">
                    <span class="text-[9px] font-black tracking-wider text-red-600">G</span>
                    <span class="text-[9px] font-black tracking-wider text-blue-600">P</span>
                    <span class="text-[9px] font-black tracking-wider text-slate-800">N</span>
                </div>
            </div>

            <!-- Merchant Details -->
            <div class="pt-3 pb-2 text-center">
                <h3 class="text-sm md:text-base font-black text-slate-900 uppercase tracking-tight">{{ config('company.brand', 'EVOTERS.ID') }}</h3>
                <p class="text-[10px] text-slate-400 font-mono mt-0.5 tracking-wide">NMID: ID1020053243804</p>
                <div class="mt-1">
                    <span class="inline-block font-mono text-[9px] font-bold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full border border-slate-200/70">
                        Ref: {{ $vote->payment_ref }}
                    </span>
                </div>
            </div>

            <!-- QR Code Box -->
            <div class="my-3 inline-block mx-auto p-3 bg-white rounded-2xl border-2 border-slate-100 shadow-inner relative">
                <div id="qris-wrapper" class="w-52 h-52 md:w-60 md:h-60 flex items-center justify-center relative overflow-hidden bg-white">
                    @php
                        $qrImageUrl = $vote->qr_image;
                    @endphp

                    @if($qrImageUrl && filter_var($qrImageUrl, FILTER_VALIDATE_URL))
                        <img id="qris-image" src="{{ $qrImageUrl }}" alt="QRIS Code Pembayaran" class="w-full h-full object-contain rounded-lg" onerror="handleQrImageError(this)">
                        <div id="qrcode-canvas" class="w-full h-full flex items-center justify-center hidden"></div>
                    @else
                        <div id="qrcode-canvas" class="w-full h-full flex items-center justify-center"></div>
                    @endif

                    <!-- Subtle Smooth Scanning Radar Laser -->
                    <div class="scan-laser absolute inset-x-0 h-[2px] bg-gradient-to-r from-transparent via-[#ba7c21] to-transparent shadow-[0_0_8px_#ba7c21] pointer-events-none animate-scan"></div>
                </div>
            </div>

            <p class="text-[10px] font-semibold text-slate-400 mb-4">Dicetak & Diverifikasi Otomatis oleh Sistem Pembayaran QRIS</p>

            <!-- Amount & Countdown Info Cards Grid -->
            <div class="grid grid-cols-2 gap-3 max-w-sm mx-auto text-left mb-4">
                <div class="bg-slate-50 border border-slate-200/80 p-3 rounded-xl">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Batas Waktu</span>
                    <div class="flex items-center space-x-1.5 text-amber-600 font-mono font-black text-sm mt-0.5">
                        <i class="fa-regular fa-clock text-xs"></i>
                        <span id="countdown">14:59</span>
                    </div>
                </div>
                <div class="bg-slate-50 border border-slate-200/80 p-3 rounded-xl">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Total Pembayaran</span>
                    <div class="text-slate-900 font-black text-sm mt-0.5 flex items-center justify-between">
                        <span>Rp {{ number_format($vote->amount, 0, ',', '.') }}</span>
                        <button type="button" onclick="copyAmount('{{ $vote->amount }}')" title="Salin Nominal" class="text-slate-400 hover:text-slate-700 text-xs cursor-pointer p-0.5">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-center gap-2.5 pt-1">
                <button type="button" onclick="downloadQRIS()" class="flex-1 max-w-[180px] text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all cursor-pointer flex items-center justify-center space-x-1.5 hover:opacity-95" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>Download QR</span>
                </button>
                <button type="button" onclick="checkStatusManual()" id="btn-check-status" class="flex-1 max-w-[180px] bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 px-4 rounded-xl border border-slate-300 transition-all cursor-pointer flex items-center justify-center space-x-1.5">
                    <i class="fa-solid fa-arrows-rotate text-xs text-slate-500"></i>
                    <span>Cek Status</span>
                </button>
            </div>
        </div>

        <!-- Supported Payment Methods Logos -->
        <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60 text-center space-y-2 relative z-10">
            <span class="text-[9px] uppercase font-bold text-slate-400 tracking-widest block">Mendukung Seluruh Aplikasi Pembayaran</span>
            <div class="flex flex-wrap items-center justify-center gap-2 text-[11px] font-bold text-slate-600">
                <span class="px-2.5 py-1 bg-white rounded-lg border border-slate-200/80 shadow-xs text-blue-700">BCA</span>
                <span class="px-2.5 py-1 bg-white rounded-lg border border-slate-200/80 shadow-xs text-amber-700">Mandiri</span>
                <span class="px-2.5 py-1 bg-white rounded-lg border border-slate-200/80 shadow-xs text-blue-600">BRI</span>
                <span class="px-2.5 py-1 bg-white rounded-lg border border-slate-200/80 shadow-xs text-teal-700">BNI</span>
                <span class="px-2.5 py-1 bg-white rounded-lg border border-slate-200/80 shadow-xs text-cyan-600">GoPay</span>
                <span class="px-2.5 py-1 bg-white rounded-lg border border-slate-200/80 shadow-xs text-blue-500">DANA</span>
                <span class="px-2.5 py-1 bg-white rounded-lg border border-slate-200/80 shadow-xs text-purple-600">OVO</span>
                <span class="px-2.5 py-1 bg-white rounded-lg border border-slate-200/80 shadow-xs text-orange-600">ShopeePay</span>
            </div>
        </div>

        <!-- How to Pay Step by Step -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 space-y-2.5 text-left relative z-10">
            <h4 class="text-xs font-extrabold text-slate-800 flex items-center space-x-2">
                <i class="fa-solid fa-circle-question text-[#ba7c21]"></i>
                <span>Panduan Pembayaran Singkat:</span>
            </h4>
            <ol class="text-xs text-slate-600 space-y-1.5 list-decimal list-inside leading-relaxed">
                <li>Buka aplikasi <strong>m-Banking</strong> atau <strong>e-Wallet</strong> favorit Anda.</li>
                <li>Pilih fitur <strong>Scan / Bayar QRIS</strong>.</li>
                <li>Pindai QR code di atas (atau klik <em>Download QR</em> lalu pilih file dari galeri).</li>
                <li>Konfirmasi nominal <strong>Rp {{ number_format($vote->amount, 0, ',', '.') }}</strong> dan masukkan PIN Anda.</li>
                <li>Selesai! Halaman ini otomatis mendeteksi ketika pembayaran berhasil.</li>
            </ol>
        </div>

        <!-- Footer / Cancel Link -->
        <div class="pt-1 flex flex-col items-center space-y-3 relative z-10">
            <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Batal & Kembali ke Beranda
            </a>
            <span class="inline-flex items-center text-[10px] text-slate-400 space-x-1">
                <i class="fa-solid fa-shield-halved text-[9px] text-emerald-600"></i>
                <span>Enkripsi SSL 256-bit & Standar QRIS Bank Indonesia</span>
            </span>
        </div>
    </div>
</div>

<!-- Success Celebration Overlay Modal -->
<div id="payment-success-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm hidden transition-all duration-300 opacity-0">
    <div class="bg-white rounded-3xl p-8 max-w-sm mx-4 text-center shadow-2xl border border-slate-100 space-y-4 transform scale-95 transition-all duration-300">
        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl shadow-lg shadow-emerald-600/20 animate-bounce">
            <i class="fa-solid fa-check"></i>
        </div>
        <div class="space-y-1">
            <h3 class="text-xl font-black text-slate-900">Pembayaran Berhasil!</h3>
            <p class="text-xs text-slate-500">Terima kasih, suara voting Anda telah resmi terekam di sistem.</p>
        </div>
        <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-100 text-xs text-emerald-800 font-bold">
            Mengalihkan ke hasil voting...
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    const qrString = @json($vote->qr_string ?? '');
    
    function renderQrCode(container) {
        if (!container || container.dataset.rendered === 'true') return;
        container.dataset.rendered = 'true';
        container.innerHTML = '';
        
        const payload = qrString || ('00020101021226580014ID.LINKAJA.WWW01189360091100223030380208102030400303UMI51440014ID.CO.QRIS.WWW0215ID10200532438040303UMI5204581253033605404{{ $vote->amount }}5802ID5910eVoters.id6005Bogor61051696062180714{{ $vote->payment_ref }}6304A1B2');
        
        new QRCode(container, {
            text: payload,
            width: 220,
            height: 220,
            colorDark : "#0f172a",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.M
        });
    }

    function handleQrImageError(imgEl) {
        imgEl.style.display = 'none';
        const canvasEl = document.getElementById('qrcode-canvas');
        if (canvasEl) {
            canvasEl.classList.remove('hidden');
            renderQrCode(canvasEl);
        }
    }

    const qrImg = document.getElementById('qris-image');
    const qrCanvas = document.getElementById('qrcode-canvas');
    if (!qrImg && qrCanvas) {
        renderQrCode(qrCanvas);
    }

    // 15 Minutes Countdown Timer
    let duration = 15 * 60;
    const countdownEl = document.getElementById('countdown');
    
    const countdownInterval = setInterval(() => {
        let minutes = Math.floor(duration / 60);
        let seconds = duration % 60;
        
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        
        if (countdownEl) {
            countdownEl.textContent = `${minutes}:${seconds}`;
        }
        
        if (duration <= 0) {
            clearInterval(countdownInterval);
            if (countdownEl) countdownEl.textContent = "Kedaluwarsa";
        }
        
        duration--;
    }, 1000);

    // Auto Polling for Real-Time Payment Detection
    const voteId = '{{ $vote->id }}';
    const statusUrl = '{{ route("vote.status", $vote->id) }}';
    let isChecking = false;
    let pollInterval = null;

    async function checkPaymentStatus() {
        if (isChecking) return;
        isChecking = true;

        try {
            const response = await fetch(statusUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const data = await response.json();
                if (data.is_completed) {
                    clearInterval(pollInterval);
                    showSuccessModal(data.redirect_url);
                }
            }
        } catch (e) {
            console.error('Polling error:', e);
        } finally {
            isChecking = false;
        }
    }

    // Start Polling every 2.5 seconds
    pollInterval = setInterval(checkPaymentStatus, 2500);

    function checkStatusManual() {
        const btn = document.getElementById('btn-check-status');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i><span>Memeriksa...</span>';
        
        fetch(statusUrl)
            .then(res => res.json())
            .then(data => {
                btn.innerHTML = '<i class="fa-solid fa-arrows-rotate text-xs text-slate-500"></i><span>Cek Status</span>';
                if (data.is_completed) {
                    showSuccessModal(data.redirect_url);
                } else {
                    alert('Pembayaran belum terdeteksi. Silakan selesaikan pembayaran di aplikasi Anda lalu coba lagi.');
                }
            })
            .catch(err => {
                btn.innerHTML = '<i class="fa-solid fa-arrows-rotate text-xs text-slate-500"></i><span>Cek Status</span>';
                alert('Gagal memeriksa status. Coba lagi dalam beberapa saat.');
            });
    }

    function showSuccessModal(redirectUrl) {
        const badge = document.getElementById('payment-status-badge');
        if (badge) {
            badge.className = 'inline-flex items-center space-x-2 px-3.5 py-1 rounded-full text-[10px] font-black tracking-wider uppercase bg-emerald-100 text-emerald-800 border border-emerald-300';
            badge.innerHTML = '<i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i><span>Pembayaran Berhasil!</span>';
        }

        const modal = document.getElementById('payment-success-modal');
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                const box = modal.querySelector('div');
                if (box) box.classList.remove('scale-95');
            }, 50);
        }

        setTimeout(() => {
            window.location.href = redirectUrl || '{{ route("event.results", $vote->event->slug) }}';
        }, 2200);
    }

    function copyAmount(amount) {
        navigator.clipboard.writeText(amount).then(() => {
            alert('Nominal Rp ' + parseInt(amount).toLocaleString('id-ID') + ' berhasil disalin!');
        });
    }

    function downloadQRIS() {
        const img = document.getElementById('qris-image');
        if (img && img.src) {
            const link = document.createElement('a');
            link.href = img.src;
            link.download = 'QRIS-eVoters-{{ $vote->payment_ref }}.png';
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } else {
            const canvas = document.querySelector('#qrcode-canvas canvas');
            const qrCanvasImg = document.querySelector('#qrcode-canvas img');
            if (canvas) {
                const link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = 'QRIS-eVoters-{{ $vote->payment_ref }}.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else if (qrCanvasImg && qrCanvasImg.src) {
                const link = document.createElement('a');
                link.href = qrCanvasImg.src;
                link.download = 'QRIS-eVoters-{{ $vote->payment_ref }}.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                alert('Gambar QRIS sedang dimuat.');
            }
        }
    }
</script>

<style>
    @keyframes scan {
        0% { top: 0; }
        50% { top: 100%; }
        100% { top: 0; }
    }
    .animate-scan {
        animation: scan 2.8s ease-in-out infinite;
    }
</style>
@endsection
