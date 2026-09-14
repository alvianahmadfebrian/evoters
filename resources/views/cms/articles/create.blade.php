@extends('layouts.cms')

@section('title', 'Tulis Berita Baru - eVoters')
@section('page_title', 'Tulis Berita Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-white">Buat Artikel Berita Baru</h3>
            <p class="text-xs text-gray-400">Isi informasi dan konten berita untuk dipublikasikan.</p>
        </div>
        <a href="{{ route('cms.articles.index') }}" class="text-xs font-semibold text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 px-3.5 py-2 rounded-xl border border-white/5 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="glass-card rounded-2xl border border-white/5 p-6 md:p-8 shadow-2xl">
        <form action="{{ route('cms.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title (Full width) -->
                <div class="md:col-span-2 space-y-1.5">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-gray-300">
                        Judul Berita <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title') }}" 
                        placeholder="Contoh: Sukses Digelar, Pemilihan Ketua Umum Berjalan Transparan" 
                        class="glass-input w-full px-4 py-3 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:ring-1 focus:ring-indigo-500"
                        required
                    >
                </div>

                <!-- Category -->
                <div class="space-y-1.5">
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-gray-300">
                        Kategori Berita
                    </label>
                    <input 
                        type="text" 
                        name="category" 
                        id="category" 
                        value="{{ old('category', 'Berita') }}" 
                        placeholder="Contoh: Informasi, Event, Pengumuman, Edukasi" 
                        class="glass-input w-full px-4 py-2.5 rounded-xl text-xs text-gray-100 placeholder-gray-500 focus:ring-1 focus:ring-indigo-500"
                    >
                </div>

                <!-- Author -->
                <div class="space-y-1.5">
                    <label for="author_name" class="block text-xs font-bold uppercase tracking-wider text-gray-300">
                        Nama Penulis / Editor
                    </label>
                    <input 
                        type="text" 
                        name="author_name" 
                        id="author_name" 
                        value="{{ old('author_name', auth()->user()->name ?? 'Admin eVoters') }}" 
                        class="glass-input w-full px-4 py-2.5 rounded-xl text-xs text-gray-100 placeholder-gray-500 focus:ring-1 focus:ring-indigo-500"
                    >
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-gray-300">
                        Status Publikasi <span class="text-red-400">*</span>
                    </label>
                    <select name="status" id="status" class="glass-input w-full px-4 py-2.5 rounded-xl text-xs text-gray-300 focus:ring-1 focus:ring-indigo-500 bg-[#0d1424]">
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Dipublikasikan Sekarang</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                    </select>
                </div>

                <!-- Published At Date -->
                <div class="space-y-1.5">
                    <label for="published_at" class="block text-xs font-bold uppercase tracking-wider text-gray-300">
                        Tanggal Publikasi
                    </label>
                    <input 
                        type="datetime-local" 
                        name="published_at" 
                        id="published_at" 
                        value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" 
                        class="glass-input w-full px-4 py-2.5 rounded-xl text-xs text-gray-100 focus:ring-1 focus:ring-indigo-500 bg-[#0d1424]"
                    >
                </div>

                <!-- Image Upload (Full width) -->
                <div class="md:col-span-2 space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300">
                        Foto / Banner Berita (Thumbnail)
                    </label>
                    <div class="flex items-center gap-4">
                        <div id="image-preview" class="w-32 h-20 rounded-xl bg-slate-800 border border-white/10 flex items-center justify-center overflow-hidden flex-shrink-0 text-gray-500">
                            <i class="fa-solid fa-image text-2xl"></i>
                        </div>
                        <div class="flex-grow">
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                accept="image/*" 
                                onchange="previewImage(this)"
                                class="glass-input w-full px-4 py-2 rounded-xl text-xs text-gray-300 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer"
                            >
                            <p class="text-[10px] text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maksimal 3MB. Rekomendasi rasio landscape (16:9 atau 4:3).</p>
                        </div>
                    </div>
                </div>

                <!-- Excerpt (Ringkasan singkat) -->
                <div class="md:col-span-2 space-y-1.5">
                    <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-gray-300">
                        Ringkasan Berita (Excerpt)
                    </label>
                    <textarea 
                        name="excerpt" 
                        id="excerpt" 
                        rows="2" 
                        placeholder="Ringkasan singkat yang akan muncul di kartu berita utama..."
                        class="glass-input w-full px-4 py-2.5 rounded-xl text-xs text-gray-100 placeholder-gray-500 focus:ring-1 focus:ring-indigo-500 leading-relaxed"
                    >{{ old('excerpt') }}</textarea>
                    <p class="text-[10px] text-gray-500">Opsional: Jika dikosongkan, sistem akan otomatis mengambil kalimat pembuka dari isi berita.</p>
                </div>

                <!-- Full Content -->
                <div class="md:col-span-2 space-y-1.5">
                    <label for="content" class="block text-xs font-bold uppercase tracking-wider text-gray-300">
                        Isi Lengkap Berita <span class="text-red-400">*</span>
                    </label>
                    <textarea 
                        name="content" 
                        id="content" 
                        rows="12" 
                        placeholder="Tuliskan isi berita atau artikel secara lengkap di sini..."
                        class="glass-input w-full px-4 py-3 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:ring-1 focus:ring-indigo-500 leading-relaxed"
                        required
                    >{{ old('content') }}</textarea>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-white/5 flex items-center justify-end gap-3">
                <a href="{{ route('cms.articles.index') }}" class="text-xs font-semibold text-gray-400 hover:text-white px-4 py-2.5 rounded-xl border border-white/5 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20 transition-all cursor-pointer flex items-center gap-1.5">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Simpan & Publikasikan Berita</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
