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

                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors py-2 px-3 rounded-lg hover:bg-white/5">
                        <i class="fa-solid fa-house mr-1"></i> Beranda
                    </a>
                    
                    @auth
                        <a href="{{ route('cms.dashboard') }}" class="text-sm font-medium text-indigo-300 hover:text-indigo-200 transition-colors py-2 px-3 rounded-lg bg-indigo-500/10 border border-indigo-500/20">
                            <i class="fa-solid fa-gauge mr-1"></i> Dashboard CMS
                        </a>
                    @endauth
                </div>
            </div>
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
            <p class="text-xs text-gray-500">&copy; {{ date('Y') }} eVoters. Platform Voting Online Terbuka & Transparan. Terinspirasi dari Votera.id.</p>
            <div class="flex space-x-4 text-gray-400 text-xs">
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <span>&bull;</span>
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
