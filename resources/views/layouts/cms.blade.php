<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin CMS - eVoters')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo1.png') }}" type="image/x-icon">

    <!-- Google Fonts & Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
        .glass-sidebar {
            background: rgba(17, 24, 39, 0.85);
            backdrop-filter: blur(16px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        .glass-card {
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }
        .glass-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-input:focus {
            border-color: rgba(16, 185, 129, 0.5);
            background: rgba(255, 255, 255, 0.05);
            outline: none;
        }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex flex-col antialiased">
    
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="glass-sidebar w-full md:w-64 flex-shrink-0 flex flex-col z-20">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between px-6 py-3 border-b border-white/5">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="eVoters Logo" class="h-11 w-auto">
                    <span class="text-xs font-bold bg-emerald-500/10 text-emerald-600 px-1.5 py-0.5 rounded uppercase tracking-wider">CMS</span>
                </a>
            </div>

            <!-- Sidebar Nav Links -->
            <nav class="flex-grow p-4 space-y-1.5 overflow-y-auto">
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-500 px-3 mb-2">NAVIGASI UTAMA</p>
                
                <a href="{{ route('cms.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('cms.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center mr-3 text-lg"></i>
                    Dashboard
                </a>

                <a href="{{ route('cms.events.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('cms.events.*') && !request()->routeIs('cms.events.create') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fa-solid fa-calendar-check w-5 text-center mr-3 text-lg"></i>
                    Semua Event
                </a>

                <a href="{{ route('cms.events.create') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('cms.events.create') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fa-solid fa-calendar-plus w-5 text-center mr-3 text-lg"></i>
                    Buat Event Baru
                </a>

                <div class="pt-6 border-t border-white/5 mt-6">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-500 px-3 mb-2">AKSES CEPAT</p>
                    <a href="{{ route('home') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fa-solid fa-globe w-5 text-center mr-3"></i>
                        Lihat Situs Voter
                    </a>
                </div>
            </nav>

            <!-- Sidebar User Profile Info & Logout -->
            <div class="p-4 border-t border-white/5 glass-sidebar">
                <div class="flex items-center space-x-3 px-2 mb-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center font-bold text-white shadow-inner">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <h4 class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</h4>
                        <p class="text-[10px] text-gray-500 truncate">{{ auth()->user()->email ?? 'admin@evoters.test' }}</p>
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-3 py-2 rounded-xl text-xs font-semibold text-red-400 hover:text-white hover:bg-red-500/10 border border-red-500/20 hover:border-red-500/30 transition-all cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Log Out Admin
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Body -->
        <div class="flex-grow flex flex-col overflow-hidden">
            <!-- Topbar Header -->
            <header class="h-16 border-b border-white/5 glass-card flex items-center justify-between px-6 md:px-8 z-10">
                <div class="flex items-center">
                    <h2 class="text-md font-semibold text-gray-300">@yield('page_title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- DB size badge -->
                    <div class="hidden sm:flex items-center space-x-1.5 text-xs text-gray-400 bg-white/5 py-1.5 px-3 rounded-lg border border-white/5">
                        <i class="fa-solid fa-database text-indigo-400"></i>
                        <span>SQLite DB:</span>
                        <span class="font-bold text-gray-300">@yield('db_size', 'Connected')</span>
                    </div>

                    <a href="{{ route('home') }}" class="text-xs font-semibold text-gray-400 hover:text-white transition-colors bg-white/5 hover:bg-white/10 px-3 py-2 rounded-lg border border-white/5">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Kunjungi Situs
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow p-6 md:p-8 overflow-y-auto max-w-7xl w-full mx-auto">
                <!-- Toast Alerts -->
                @if(session('success'))
                    <div id="cms-success-alert" class="glass-card mb-6 p-4 rounded-xl border-green-500/30 bg-green-950/20 text-green-300 flex items-center justify-between shadow-xl">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-circle-check text-green-400 text-lg"></i>
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                        <button onclick="document.getElementById('cms-success-alert').remove()" class="text-green-400 hover:text-green-300 transition-colors">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div id="cms-error-alert" class="glass-card mb-6 p-4 rounded-xl border-red-500/30 bg-red-950/20 text-red-300 shadow-xl">
                        <div class="flex items-start justify-between">
                            <div class="flex space-x-3">
                                <i class="fa-solid fa-triangle-exclamation text-red-400 text-lg mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-semibold mb-1">Kesalahan Input:</p>
                                    <ul class="list-disc list-inside text-xs space-y-1 text-red-400/90">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button onclick="document.getElementById('cms-error-alert').remove()" class="text-red-400 hover:text-red-300 transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
