@extends('layouts.cms')

@section('title', 'Edit Kandidat - ' . $candidate->name)
@section('page_title', 'Edit Data Kandidat')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto animate-fade-in">
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-2 text-xs text-gray-500">
        <a href="{{ route('cms.events.index') }}" class="hover:text-white transition-colors">Event</a>
        <span>&rarr;</span>
        <a href="{{ route('cms.events.show', $candidate->event_id) }}" class="hover:text-white transition-colors">{{ $candidate->event->title }}</a>
        <span>&rarr;</span>
        <span class="text-gray-300">Edit Kandidat: {{ $candidate->name }}</span>
    </div>

    <!-- Form Card -->
    <div class="glass-card rounded-2xl border border-white/5 p-6 md:p-8 shadow-2xl relative overflow-hidden">
        <form action="{{ route('cms.candidates.update', $candidate->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Name -->
                <div class="space-y-2 sm:col-span-2">
                    <label for="name" class="text-xs font-semibold text-gray-300">Nama Kandidat / Pilihan</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        required 
                        value="{{ old('name', $candidate->name) }}"
                        class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm focus:outline-none"
                    >
                </div>

                <!-- Number -->
                <div class="space-y-2">
                    <label for="candidate_number" class="text-xs font-semibold text-gray-300">Nomor Urut Ballot</label>
                    <input 
                        type="number" 
                        name="candidate_number" 
                        id="candidate_number" 
                        required 
                        value="{{ old('candidate_number', $candidate->candidate_number) }}"
                        class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm focus:outline-none"
                    >
                </div>
            </div>

            <!-- Bio/Vision Description -->
            <div class="space-y-2">
                <label for="description" class="text-xs font-semibold text-gray-300">Visi, Misi & Program</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="5" 
                    placeholder="Tulis visi misi program kandidat..."
                    class="w-full px-4 py-3 rounded-xl glass-input text-white text-sm focus:outline-none"
                >{{ old('description', $candidate->description) }}</textarea>
            </div>

            <!-- Photo Upload with Preview Thumbnail -->
            <div class="space-y-3">
                <label for="photo" class="text-xs font-semibold text-gray-300">Ganti Foto Kandidat (Max 2MB)</label>
                <input 
                    type="file" 
                    name="photo" 
                    id="photo" 
                    accept="image/*"
                    class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 transition-colors focus:outline-none cursor-pointer"
                >
                @if($candidate->photo)
                    <div class="mt-2 text-left">
                        <span class="text-[10px] text-gray-500 block mb-1">Foto saat ini:</span>
                        <div class="w-24 h-24 rounded-xl overflow-hidden border border-white/10">
                            <img src="{{ asset($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-white/5 flex items-center justify-end space-x-3">
                <a href="{{ route('cms.events.show', $candidate->event_id) }}" class="text-xs font-semibold text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 px-5 py-3 rounded-xl transition-all cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs px-6 py-3 rounded-xl transition-all shadow-md cursor-pointer">
                    Simpan Perubahan <i class="fa-solid fa-cloud-arrow-up ml-1"></i>
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
