@extends('layouts.cms')

@section('title', 'Buat Event Baru - eVoters')
@section('page_title', 'Buat Event Baru')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto animate-fade-in">
    <!-- Breadcrumb / Header -->
    <div class="flex items-center space-x-2 text-xs text-gray-500">
        <a href="{{ route('cms.events.index') }}" class="hover:text-white transition-colors">Event</a>
        <span>&rarr;</span>
        <span class="text-gray-300">Buat Baru</span>
    </div>

    <!-- Create Card Form -->
    <div class="glass-card rounded-2xl border border-white/5 p-6 md:p-8 shadow-2xl relative overflow-hidden">
        <!-- Decoration glow -->
        <div class="absolute -top-32 -right-32 w-64 h-64 bg-violet-600/5 rounded-full blur-3xl"></div>

        <form action="{{ route('cms.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
            @csrf

            <!-- Event Title -->
            <div class="space-y-2">
                <label for="title" class="text-xs font-semibold text-gray-300">Judul Event / Pemilihan</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    required 
                    value="{{ old('title') }}"
                    placeholder="Contoh: Pemilihan Ketua OSIS SMA Negeri 1" 
                    class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm placeholder-gray-600"
                >
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="text-xs font-semibold text-gray-300">Deskripsi / Informasi Pendukung</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4" 
                    placeholder="Tuliskan petunjuk, tanggal pelaksanaan, tata tertib, atau info detail event..."
                    class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm placeholder-gray-600"
                >{{ old('description') }}</textarea>
            </div>

            <!-- Voting Config & Security (Three Column Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Voting Type -->
                <div class="space-y-2">
                    <label for="voting_type" class="text-xs font-semibold text-gray-300">Tipe Voting (Metode Verifikasi)</label>
                    <select name="voting_type" id="voting_type" required class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm bg-[#0a0f1d] border border-white/10">
                        <option value="public_email" {{ old('voting_type') === 'public_email' ? 'selected' : '' }}>Email Terbuka (Verifikasi OTP Email)</option>
                        <option value="token_only" {{ old('voting_type') === 'token_only' ? 'selected' : '' }}>Token Privat (Verifikasi Kode Token Khusus)</option>
                    </select>
                </div>

                <!-- Show Results -->
                <div class="space-y-2">
                    <label for="show_results" class="text-xs font-semibold text-gray-300">Publikasi Hasil Voting</label>
                    <select name="show_results" id="show_results" required class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm bg-[#0a0f1d] border border-white/10">
                        <option value="always" {{ old('show_results') === 'always' ? 'selected' : '' }}>Selalu Tampilkan Secara Umum</option>
                        <option value="after_voting" {{ old('show_results') === 'after_voting' ? 'selected' : '' }}>Tampilkan Setelah Voter Memilih</option>
                        <option value="after_closed" {{ old('show_results') === 'after_closed' ? 'selected' : '' }}>Hanya Setelah Event Ditutup</option>
                        <option value="secret" {{ old('show_results') === 'secret' ? 'selected' : '' }}>Rahasia (Hanya Admin / CMS)</option>
                    </select>
                </div>

                <!-- Price -->
                <div class="space-y-2">
                    <label for="price" class="text-xs font-semibold text-gray-300">Tarif Voting (Rp, 0 = Gratis)</label>
                    <input 
                        type="number" 
                        name="price" 
                        id="price" 
                        min="0" 
                        value="{{ old('price', 0) }}"
                        placeholder="Contoh: 5000" 
                        class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm"
                    >
                </div>
            </div>

            <!-- Dates (Two Column Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Start Time -->
                <div class="space-y-2">
                    <label for="start_time" class="text-xs font-semibold text-gray-300">Waktu Mulai (Opsional)</label>
                    <input 
                        type="datetime-local" 
                        name="start_time" 
                        id="start_time" 
                        value="{{ old('start_time') }}"
                        class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm"
                    >
                </div>

                <!-- End Time -->
                <div class="space-y-2">
                    <label for="end_time" class="text-xs font-semibold text-gray-300">Waktu Selesai (Opsional)</label>
                    <input 
                        type="datetime-local" 
                        name="end_time" 
                        id="end_time" 
                        value="{{ old('end_time') }}"
                        class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm"
                    >
                </div>
            </div>

            <!-- Status & Banner Image -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status -->
                <div class="space-y-2">
                    <label for="status" class="text-xs font-semibold text-gray-300">Status Awal</label>
                    <select name="status" id="status" required class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm bg-[#0a0f1d] border border-white/10">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Belum Aktif)</option>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif (Voting Dibuka)</option>
                        <option value="paused" {{ old('status') === 'paused' ? 'selected' : '' }}>Jeda (Voting Dihentikan Sementara)</option>
                        <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Tutup (Voting Berakhir Resmi)</option>
                    </select>
                </div>

                <!-- Banner image -->
                <div class="space-y-2">
                    <label for="banner_image" class="text-xs font-semibold text-gray-300">Banner Event (Opsional, Max 2MB)</label>
                    <input 
                        type="file" 
                        name="banner_image" 
                        id="banner_image" 
                        accept="image/*"
                        class="w-full text-xs text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 transition-colors focus:outline-none cursor-pointer"
                    >
                </div>
            </div>

            <!-- Action buttons -->
            <div class="pt-4 border-t border-white/5 flex items-center justify-end space-x-3">
                <a href="{{ route('cms.events.index') }}" class="text-xs font-semibold text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 px-5 py-3 rounded-xl transition-all cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs px-6 py-3 rounded-xl transition-all shadow-md shadow-indigo-600/10 cursor-pointer">
                    Buat Event <i class="fa-solid fa-square-check ml-1"></i>
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
