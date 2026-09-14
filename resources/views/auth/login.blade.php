@extends('layouts.app')

@section('title', 'Masuk Akun Voter - eVoters')

@section('content')
<div class="max-w-md mx-auto py-6 sm:py-12 relative animate-fade-in">
    <!-- Glow Background Decorators -->
    <div class="absolute -top-16 -left-20 w-72 h-72 bg-[#ba7c21]/[0.06] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -right-20 w-72 h-72 bg-[#9b5f1a]/[0.05] rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header Section -->
    <div class="text-center space-y-2 mb-6 relative z-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Login
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
            Silakan masuk untuk menggunakan hak pilih, memantau perolehan suara, atau mengelola akun Anda.
        </p>
    </div>

    <!-- Info banner if redirected from protected page -->
    @if(session('info'))
        <div class="mb-5 p-4 rounded-2xl border border-amber-300 bg-amber-50 text-amber-900 text-xs flex items-start space-x-3 shadow-xs relative z-10">
            <i class="fa-solid fa-circle-info text-amber-600 mt-0.5 text-sm flex-shrink-0"></i>
            <span class="leading-relaxed">{{ session('info') }}</span>
        </div>
    @endif

    <!-- Card -->
    <div class="rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl bg-white relative z-10 overflow-hidden">
        
        <!-- Error Alert -->
        @if ($errors->any())
            <div class="mb-5 p-4 rounded-2xl border border-rose-200 bg-rose-50 text-rose-800 text-xs space-y-1.5">
                <div class="flex items-center space-x-2 font-bold text-rose-700">
                    <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                    <span>Gagal Masuk:</span>
                </div>
                <ul class="list-disc list-inside pl-1 text-[11px] text-rose-700 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email or Username -->
            <div class="space-y-1.5 text-left">
                <label for="login_identity" class="block text-xs font-bold text-slate-700">Email atau Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </div>
                    <input 
                        type="text" 
                        name="login_identity" 
                        id="login_identity" 
                        required 
                        autofocus
                        value="{{ old('login_identity') }}"
                        placeholder="nama@email.com atau username" 
                        class="w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-200 bg-slate-50/60 text-slate-900 text-xs sm:text-sm focus:outline-none focus:border-[#ba7c21] focus:bg-white focus:ring-4 focus:ring-[#ba7c21]/15 transition-all shadow-xs placeholder:text-slate-400"
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-1.5 text-left">
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-xs font-bold text-slate-700">Password</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full pl-10 pr-11 py-3 rounded-2xl border border-slate-200 bg-slate-50/60 text-slate-900 text-xs sm:text-sm focus:outline-none focus:border-[#ba7c21] focus:bg-white focus:ring-4 focus:ring-[#ba7c21]/15 transition-all shadow-xs placeholder:text-slate-400"
                    >
                    <button type="button" onclick="togglePasswordVisibility('password', 'toggle-pass-icon')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer" aria-label="Lihat Password">
                        <i id="toggle-pass-icon" class="fa-solid fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="inline-flex items-center cursor-pointer select-none text-slate-600 hover:text-slate-900 transition-colors">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 shadow-xs h-4 w-4 accent-[#ba7c21] cursor-pointer">
                    <span class="ml-2 text-xs font-medium">Ingat saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full py-3.5 px-6 rounded-2xl text-white font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center space-x-2 cursor-pointer hover:opacity-95 mt-2"
                style="background: linear-gradient(135deg, #ba7c21 0%, #9b5f1a 100%);"
            >
                <span>Masuk Sekarang</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>
            <div class="relative flex justify-center text-xs">
                <span class="px-3 bg-white text-slate-400 text-xs font-semibold">Belum punya akun?</span>
            </div>
        </div>

        <!-- Register Link Button -->
        <div class="text-center">
            <a 
                href="{{ route('register') }}" 
                class="w-full inline-flex items-center justify-center py-3 px-4 rounded-2xl text-slate-700 font-bold text-xs sm:text-sm bg-slate-50 hover:bg-slate-100 border border-slate-200/90 transition-all shadow-xs"
            >
                <i class="fa-solid fa-user-plus mr-2 text-[#ba7c21]"></i> Buat Akun Baru
            </a>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection

