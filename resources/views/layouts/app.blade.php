<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'eVoters - Platform Voting Online Terpercaya')</title>

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
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #040d12;
            background-image: 
                radial-gradient(at 0% 0%, hsla(142,40%,6%,1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(142,60%,15%,0.25) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(187,60%,15%,0.2) 0, transparent 50%);
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
            background-color: rgba(240, 253, 244, 0.98);
            border-top: 1px solid rgba(16, 185, 129, 0.15);
            border-bottom: 1px solid rgba(16, 185, 129, 0.15);
            padding: 16px 24px;
            z-index: 9999;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        #mobile-menu a {
            display: block;
            color: #065f46 !important;
            background-color: transparent;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.15rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        #mobile-menu a:hover, #mobile-menu a.active-link {
            color: #047857 !important;
            background-color: rgba(16, 185, 129, 0.1);
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
                        <img src="{{ asset('images/logo.png') }}" alt="eVoters Logo" class="h-14 w-auto">
                    </a>
                </div>

                <!-- Desktop Navigation Links (hidden on mobile) -->
                <div id="desktop-menu" class="items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-base font-semibold {{ Route::is('home') ? 'text-white bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-colors py-2 px-4 rounded-lg">
                        Beranda
                    </a>
                    
                    <a href="{{ route('events.list') }}" class="text-base font-semibold {{ Route::is('events.list') ? 'text-white bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-colors py-2 px-4 rounded-lg">
                        Event
                    </a>

                    <a href="{{ route('about') }}" class="text-base font-semibold {{ Route::is('about') ? 'text-white bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/5' }} transition-colors py-2 px-4 rounded-lg">
                        Tentang
                    </a>
                    
                    @auth
                        <a href="{{ route('cms.dashboard') }}" class="text-base font-semibold text-indigo-300 hover:text-indigo-200 transition-colors py-2 px-4 rounded-lg bg-indigo-500/10 border border-indigo-500/20">
                            Dashboard CMS
                        </a>
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
            
            @auth
                <a href="{{ route('cms.dashboard') }}" class="{{ Route::is('cms.dashboard') ? 'active-link' : '' }}" style="color: #a5b4fc !important;">
                    Dashboard CMS
                </a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        <!-- Toast Alerts -->
        @if(session('success'))
            <div id="alert-success" class="glass-card mb-6 p-4 rounded-xl border-green-500/30 bg-green-950/20 text-green-300 flex items-center justify-between shadow-xl animate-fade-in">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-green-400 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('alert-success').remove()" class="text-green-400 hover:text-green-300 transition-colors">
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
    <footer class="mt-auto border-t border-white/5 py-8 glass-card">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="eVoters Logo" class="h-12 w-auto">
            </div>
            <p class="text-xs text-gray-500">&copy; {{ date('Y') }} eVoters. Platform Voting Online Terbuka & Transparan.</p>
            <div class="flex space-x-4 text-gray-400 text-xs">
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <span>&bull;</span>
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
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
