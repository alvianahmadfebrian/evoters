@extends('layouts.app')

@section('title', 'Masuk Akun Voter - eVoters')

@section('content')
<div class="max-w-md mx-auto py-8 md:py-16 animate-fade-in">
    <!-- Header Notice -->
    <div class="text-center space-y-2 mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-500 text-xl mb-1 shadow-sm">
            <i class="fa-solid fa-user-lock"></i>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900">Masuk Akun Voter</h2>
        <p class="text-xs text-slate-500 max-w-sm mx-auto">
            Silakan masuk untuk melihat hasil perolehan voting langsung atau mengelola akun Anda.
        </p>
    </div>

    <!-- Info banner if redirected from protected results page -->
    @if(session('info'))
        <div class="mb-5 p-4 rounded-xl border border-amber-500/20 bg-amber-500/10 text-amber-800 text-xs flex items-start space-x-2.5">
            <i class="fa-solid fa-circle-info text-amber-600 mt-0.5 text-sm flex-shrink-0"></i>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    <!-- Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xl bg-white/80 backdrop-blur-md relative overflow-hidden">
        
        <!-- Error Alert -->
        @if ($errors->any())
            <div class="mb-5 p-3.5 rounded-xl border border-rose-500/20 bg-rose-500/10 text-rose-700 text-xs space-y-1">
                <div class="flex items-center space-x-2 font-semibold">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                    <span>Terjadi kesalahan:</span>
                </div>
                <ul class="list-disc list-inside pl-1 text-[11px] text-rose-600 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
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
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition-all"
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
                        class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-xs focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition-all"
                    >
                    <button type="button" onclick="togglePasswordVisibility('password', 'toggle-pass-icon')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                        <i id="toggle-pass-icon" class="fa-solid fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="inline-flex items-center cursor-pointer select-none text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4">
                    <span class="ml-2 text-xs">Ingat saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full py-3 px-4 rounded-xl text-white font-bold text-xs bg-indigo-600 hover:bg-indigo-500 shadow-md hover:shadow-lg transition-all flex items-center justify-center space-x-2 cursor-pointer"
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
                <span class="px-3 bg-white text-slate-400 text-[11px] uppercase tracking-wider">Belum punya akun?</span>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <a 
                href="{{ route('register') }}" 
                class="w-full inline-flex items-center justify-center py-2.5 px-4 rounded-xl text-slate-700 font-semibold text-xs border border-slate-200 hover:bg-slate-50 transition-colors"
            >
                <i class="fa-solid fa-user-plus mr-1.5 text-slate-500"></i> Buat Akun Baru
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
