<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'eVoters - Platform Voting Online Terpercaya')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="/images/logo2.png" type="image/x-icon">

    <!-- Google Fonts & Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom styling helper for extra premium touches -->
    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }
        img {
            max-width: 100%;
        }
        nav img {
            height: 56px !important;
            max-height: 56px !important;
            width: auto !important;
            object-fit: contain !important;
        }
        footer img {
            height: 48px !important;
            max-height: 48px !important;
            width: auto !important;
            object-fit: contain !important;
        }
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #0b0f19;
            background-image: 
                radial-gradient(at 0% 0%, hsla(222,47%,11%,1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(234,60%,15%,0.25) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(260,60%,15%,0.2) 0, transparent 50%);
            background-attachment: fixed;
        }
        .glass-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        nav {
            position: relative !important;
            overflow: visible !important;
        }
        #desktop-menu {
            display: flex;
            align-items: center;
        }
        #mobile-menu-btn-container {
            display: none;
        }
        #mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: rgba(15, 23, 42, 0.98);
            border-top: 1px solid rgba(99, 102, 241, 0.2);
            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
            padding: 16px 24px;
            z-index: 9999;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        }
        #mobile-menu a {
            display: block;
            color: #cbd5e1 !important;
            background-color: transparent;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.15rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        #mobile-menu a:hover, #mobile-menu a.active-link {
            color: #818cf8 !important;
            background-color: rgba(99, 102, 241, 0.15);
        }

        /* Screen sizes below 768px (Mobile) */
        @media (max-width: 767.98px) {
            #desktop-menu {
                display: none !important;
            }
            #mobile-menu-btn-container {
                display: flex !important;
            }
        }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex flex-col antialiased">
    
    <!-- Navbar -->
    <nav class="glass-card sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-3">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('images/logo2.png') }}?v=20260908" alt="eVoters Logo" class="h-14 sm:h-16 w-auto transition-transform hover:scale-105" style="height: 58px; max-height: 60px; width: auto; object-fit: contain;">
                    </a>
                </div>

                <!-- Desktop Navigation Links (hidden on mobile) -->
                <div id="desktop-menu" class="items-center space-x-2">
                    <a href="{{ route('home') }}" class="text-sm font-semibold {{ Route::is('home') ? 'text-white bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-colors py-2 px-3 rounded-lg">
                        Beranda
                    </a>
                    
                    <a href="{{ route('events.list') }}" class="text-sm font-semibold {{ Route::is('events.list') ? 'text-white bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-colors py-2 px-3 rounded-lg">
                        Event
                    </a>

                    <a href="{{ route('about') }}" class="text-sm font-semibold {{ Route::is('about') ? 'text-white bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-colors py-2 px-3 rounded-lg">
                        Tentang
                    </a>

                    <a href="{{ route('faq') }}" class="text-sm font-semibold {{ Route::is('faq') ? 'text-white bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-colors py-2 px-3 rounded-lg">
                        FAQ
                    </a>

                    <a href="{{ route('contact') }}" class="text-sm font-semibold {{ Route::is('contact') ? 'text-white bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-colors py-2 px-3 rounded-lg">
                        Kontak
                    </a>
                    
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('cms.dashboard') }}" class="text-xs font-semibold text-indigo-300 hover:text-indigo-200 transition-colors py-1.5 px-3 rounded-lg bg-indigo-500/10 border border-indigo-500/20">
                                <i class="fa-solid fa-gauge mr-1"></i> Panel CMS
                            </a>
                        @endif
                        <div class="inline-flex items-center space-x-2 pl-2 border-l border-slate-300">
                            <span class="text-xs font-bold text-slate-700 flex items-center space-x-1.5 bg-slate-100/80 py-1 px-2.5 rounded-xl border border-slate-200">
                                <span class="w-5 h-5 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[10px] font-extrabold uppercase">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </span>
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            </span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 p-1.5 rounded-lg transition-colors cursor-pointer" title="Keluar">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="inline-flex items-center space-x-2 pl-2 border-l border-slate-300">
                            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 hover:text-[#ba7c21] transition-colors py-2 px-3 rounded-xl hover:bg-slate-100">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="text-xs font-bold text-white transition-all py-2 px-3.5 rounded-xl shadow-sm hover:opacity-90" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Mobile Menu Button (hidden on desktop) -->
                <div id="mobile-menu-btn-container" class="items-center">
                    <button id="mobile-menu-btn" type="button" class="text-gray-400 hover:text-white focus:outline-none p-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu Dropdown (hidden by default) -->
        <div id="mobile-menu">
            <a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active-link' : '' }}">
                Beranda
            </a>
            
            <a href="{{ route('events.list') }}" class="{{ Route::is('events.list') ? 'active-link' : '' }}">
                Event
            </a>

            <a href="{{ route('about') }}" class="{{ Route::is('about') ? 'active-link' : '' }}">
                Tentang
            </a>

            <a href="{{ route('faq') }}" class="{{ Route::is('faq') ? 'active-link' : '' }}">
                FAQ
            </a>

            <a href="{{ route('contact') }}" class="{{ Route::is('contact') ? 'active-link' : '' }}">
                Kontak
            </a>
            
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('cms.dashboard') }}" class="{{ Route::is('cms.dashboard') ? 'active-link' : '' }}" style="color: #ba7c21 !important;">
                        <i class="fa-solid fa-gauge mr-1"></i> Dashboard CMS
                    </a>
                @endif
                <div class="px-4 py-2 text-xs text-slate-500 font-semibold border-t border-slate-200 mt-2 flex items-center justify-between">
                    <span>Halo, <strong>{{ Auth::user()->name }}</strong></span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-rose-600 font-bold hover:underline cursor-pointer">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                        </button>
                    </form>
                </div>
            @else
                <div class="pt-3 border-t border-slate-200 grid grid-cols-2 gap-2 px-3 mt-2">
                    <a href="{{ route('login') }}" class="text-center py-2 text-xs font-bold text-slate-700 border border-slate-300 rounded-xl hover:bg-slate-50">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-center py-2 text-xs font-bold text-white rounded-xl shadow-sm hover:opacity-90" style="background: linear-gradient(135deg, #ba7c21, #9b5f1a);">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        <!-- Toast Alerts -->
        @if(session('success'))
            <div id="alert-success" class="glass-card mb-6 p-4 rounded-xl border-amber-500/30 bg-amber-950/20 text-amber-300 flex items-center justify-between shadow-xl animate-fade-in">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-amber-400 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('alert-success').remove()" class="text-amber-400 hover:text-amber-300 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div id="alert-info" class="glass-card mb-6 p-4 rounded-xl border-amber-500/30 bg-amber-500/10 text-amber-800 flex items-center justify-between shadow-xl animate-fade-in">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-info text-amber-600 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('info') }}</p>
                </div>
                <button onclick="document.getElementById('alert-info').remove()" class="text-amber-600 hover:text-amber-700 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div id="alert-error" class="glass-card mb-6 p-4 rounded-xl border-red-500/30 bg-red-950/20 text-red-300 shadow-xl">
                <div class="flex items-start justify-between">
                    <div class="flex space-x-3">
                        <i class="fa-solid fa-triangle-exclamation text-red-400 text-lg mt-0.5"></i>
                        <div>
                            <p class="text-sm font-semibold mb-1">Terjadi kesalahan:</p>
                            <ul class="list-disc list-inside text-xs space-y-1 text-red-400/90">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button onclick="document.getElementById('alert-error').remove()" class="text-red-400 hover:text-red-300 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-slate-200/80 pt-12 pb-8 bg-white/95 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pb-10 border-b border-slate-100">
                
                <!-- Col 1: Brand & Identity -->
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="inline-block">
                        <img src="{{ asset('images/logo2.png') }}?v=20260908" alt="eVoters Logo" class="h-14 w-auto" style="height: 56px; max-height: 58px; width: auto; object-fit: contain;">
                    </a>
                    <p class="text-xs text-slate-600 leading-relaxed max-w-sm">
                        Platform pemungutan suara online terpercaya dan berintegritas tinggi. Menghadirkan proses demokrasi digital yang praktis, aman, terenkripsi, dan transparan untuk berbagai instansi dan organisasi.
                    </p>
                    <div class="pt-1 text-[11px] text-slate-500 space-y-0.5">
                        <p class="font-medium text-slate-500">Badan Usaha / Pengelola:</p>
                        <p class="font-bold text-[#ba7c21]">{{ config('company.name') }}</p>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Navigasi</h4>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-[#ba7c21] transition-colors">Beranda</a>
                        </li>
                        <li>
                            <a href="{{ route('events.list') }}" class="hover:text-[#ba7c21] transition-colors">Event Voting</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:text-[#ba7c21] transition-colors">Tentang Kami</a>
                        </li>
                        <li>
                            <a href="{{ route('faq') }}" class="hover:text-[#ba7c21] transition-colors">Pusat Bantuan (FAQ)</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="hover:text-[#ba7c21] transition-colors">Hubungi Kami</a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Kebijakan & Legalitas -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Legal & Kebijakan</h4>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li>
                            <a href="{{ route('terms') }}" class="hover:text-[#ba7c21] transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-file-contract text-[10px] text-[#ba7c21]"></i>
                                <span>Syarat & Ketentuan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('refund') }}" class="hover:text-[#ba7c21] transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-receipt text-[10px] text-[#ba7c21]"></i>
                                <span>Kebijakan Pengembalian Dana</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terms') }}#privasi" class="hover:text-[#ba7c21] transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-halved text-[10px] text-[#ba7c21]"></i>
                                <span>Kebijakan Privasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="hover:text-[#ba7c21] transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-address-book text-[10px] text-[#ba7c21]"></i>
                                <span>Halaman Kontak</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Alamat & Kontak Usaha Sesuai iPaymu -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Kontak & Alamat Usaha</h4>
                    <div class="space-y-2.5 text-xs text-slate-600">
                        <div class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-[#ba7c21] mt-0.5 flex-shrink-0"></i>
                            <span class="leading-relaxed">{{ config('company.address') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-[#ba7c21] flex-shrink-0"></i>
                            <a href="https://wa.me/{{ config('company.whatsapp') }}" target="_blank" rel="noopener noreferrer" class="hover:text-[#ba7c21] transition-colors">
                                {{ config('company.phone') }}
                            </a>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-[#ba7c21] flex-shrink-0"></i>
                            <a href="mailto:{{ config('company.email') }}" class="hover:text-[#ba7c21] transition-colors">
                                {{ config('company.email') }}
                            </a>
                        </div>
                        <div class="flex items-center gap-2 text-[11px] text-slate-500 pt-1">
                            <i class="fa-solid fa-clock text-[#ba7c21]/70 flex-shrink-0"></i>
                            <span>{{ config('company.hours') }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright Bar -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} eVoters.id - {{ config('company.name') }}. All rights reserved.</p>
                <div class="flex items-center gap-4 text-slate-500">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-3 py-1 rounded-full shadow-sm" style="background: #fcf5e2; border: 1px solid #f7e6bb; color: #9b5f1a;">
                        <i class="fa-solid fa-shield-check text-xs text-[#ba7c21]"></i>
                        <span>Transaksi Terverifikasi & Aman</span>
                    </span>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')

    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            
            if (btn && menu) {
                // Initialize default state
                menu.style.display = 'none';
                
                btn.addEventListener('click', function() {
                    const isHidden = menu.style.display === 'none';
                    if (isHidden) {
                        menu.style.setProperty('display', 'block', 'important');
                        const icon = btn.querySelector('i');
                        if (icon) {
                            icon.className = 'fa-solid fa-xmark text-xl';
                        }
                    } else {
                        menu.style.setProperty('display', 'none', 'important');
                        const icon = btn.querySelector('i');
                        if (icon) {
                            icon.className = 'fa-solid fa-bars text-xl';
                        }
                    }
                });
            }
        });
    </script>



    @include('partials.vera-chat')
</body>
</html>
