<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - eVoters</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <!-- Google Fonts & Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #080c14;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%),
                radial-gradient(at 50% 50%, hsla(225,39%,30%,0.15) 0, transparent 50%),
                radial-gradient(at 100% 100%, hsla(263,45%,20%,0.1) 0, transparent 50%);
            background-attachment: fixed;
        }
        .glass-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-input:focus {
            border-color: rgba(99, 102, 241, 0.5);
            background: rgba(255, 255, 255, 0.05);
            outline: none;
            box-ring: rgba(99, 102, 241, 0.2);
        }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="w-full max-w-md space-y-8 animate-fade-in">
        <!-- Logo Header -->
        <div class="text-center space-y-3">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="eVoters Logo" class="h-16 w-auto">
                <span class="text-xs font-bold bg-emerald-500/10 text-emerald-600 px-1.5 py-0.5 rounded uppercase tracking-wider">CMS</span>
            </a>
            <p class="text-xs text-gray-400">Silakan login menggunakan akun administrator untuk mengakses panel kontrol.</p>
        </div>

        <!-- Glass Login Card -->
        <div class="glass-card rounded-3xl p-8 border border-white/5 shadow-2xl relative overflow-hidden">
            <!-- Glow background decorator -->
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl"></div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6 relative z-10">
                @csrf

                @if($errors->any())
                    <div class="p-3.5 rounded-xl border border-red-500/20 bg-red-950/20 text-red-400 text-xs font-semibold flex items-center space-x-2">
                        <i class="fa-solid fa-circle-exclamation text-red-500 text-sm"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Email/Username Input -->
                <div class="space-y-2">
                    <label for="login_identity" class="text-xs font-semibold text-gray-300">Email atau Username Admin</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <input 
                            type="text" 
                            name="login_identity" 
                            id="login_identity" 
                            required 
                            value="{{ old('login_identity') }}"
                            placeholder="Email atau username admin" 
                            class="w-full pl-10 pr-4 py-3 rounded-xl glass-input text-white text-sm placeholder-gray-600 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/10 transition-all"
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-xs font-semibold text-gray-300">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required
                            placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-3 rounded-xl glass-input text-white text-sm placeholder-gray-600 focus:outline-none focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/10 transition-all"
                        >
                    </div>
                </div>

                <!-- Remember Me & Reset Link -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-gray-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-white/10 text-indigo-600 bg-white/5 focus:ring-indigo-500/30">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white font-semibold py-3 px-4 rounded-xl transition-all cursor-pointer shadow-lg shadow-indigo-600/20 text-sm">
                    Masuk ke CMS <i class="fa-solid fa-right-to-bracket ml-1.5"></i>
                </button>
            </form>
        </div>

        <!-- Back to site link -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-gray-300 transition-colors font-medium">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Situs Voting
            </a>
        </div>
    </div>

</body>
</html>
