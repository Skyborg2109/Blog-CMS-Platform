@extends('layouts.public')

@section('title', isset($post) ? 'Edit Artikel: ' . $post->title : 'Tulis Artikel Baru')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-editor { 
        min-height: 600px; 
        border: none !important;
        padding: 0 !important;
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        line-height: 1.8;
        color: #1C1917;
    }
    trix-toolbar {
        border: none !important;
        border-bottom: 1px solid #E7E5E4 !important;
        margin-bottom: 3rem !important;
        padding: 1rem 0 !important;
        position: sticky;
        top: 6rem;
        background: #FAFAF9;
        z-index: 60;
    }
    .trix-button-group {
        border: none !important;
        background: transparent !important;
    }
    .trix-button {
        border: none !important;
        background: transparent !important;
        color: #57534E !important;
    }
    .trix-button--active {
        background: #F5F5F4 !important;
        color: #1C1917 !important;
    }
    trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
    
    /* Custom Scrollbar for Tags */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #E7E5E4; border-radius: 10px; }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    document.addEventListener("trix-file-accept", function(event) {
        event.preventDefault();
    });
</script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 lg:py-20">
    <form action="{{ isset($post) ? route('post.update', $post->id) : route('post.store') }}" method="POST" enctype="multipart/form-data" class="relative">
        @csrf
        @if(isset($post))
            @method('PATCH')
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24">
            <!-- Writing Area -->
            <div class="lg:col-span-8 order-2 lg:order-1">
                <header class="mb-12">
                    <div class="flex items-center space-x-4 mb-6">
                        <span class="w-12 h-px bg-stone-300"></span>
                        <span class="text-[10px] font-black uppercase tracking-[0.4em] text-stone-400">{{ isset($post) ? 'Revisi Artikel' : 'Ruang Kreatif' }} &bull; Edisi Penulis</span>
                    </div>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}" required 
                        class="w-full bg-transparent border-none p-0 text-5xl md:text-7xl font-black font-serif text-stone-900 placeholder-stone-200 focus:ring-0 leading-[1.1] tracking-tight" 
                        placeholder="Tulis judul yang megah...">
                    @error('title')<p class="mt-2 text-sm text-red-600 font-bold uppercase tracking-widest text-[10px]">{{ $message }}</p>@enderror
                </header>

                <div class="relative min-h-[70vh]">
                    <input id="body" type="hidden" name="body" value="{{ old('body', $post->body ?? '') }}">
                    <trix-editor input="body" placeholder="Biarkan kata-kata Anda mengalir dengan bebas..."></trix-editor>
                    @error('body')<p class="mt-2 text-sm text-red-600 font-bold uppercase tracking-widest text-[10px]">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Settings Sidebar -->
            <div class="lg:col-span-4 order-1 lg:order-2">
                <div class="lg:sticky lg:top-32 space-y-12">
                    <!-- Actions -->
                    <div class="bg-white p-8 border editorial-border shadow-[20px_20px_0px_0px_rgba(0,0,0,0.03)] selection:bg-stone-900">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-stone-900 mb-8 border-b pb-4 editorial-border">Panel Publikasi</h3>
                        <div class="space-y-4">
                            <button type="submit" name="status" value="published" class="w-full bg-stone-900 text-stone-50 font-bold uppercase tracking-[0.2em] text-[11px] py-5 hover:bg-stone-800 transition-all flex items-center justify-center group">
                                {{ (isset($post) && $post->status === 'published') ? 'Perbarui Artikel' : 'Terbitkan Sekarang' }}
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                            <button type="submit" name="status" value="draft" class="w-full border editorial-border text-stone-600 font-bold uppercase tracking-[0.2em] text-[11px] py-5 hover:bg-stone-50 transition-all">
                                {{ (isset($post) && $post->status === 'draft') ? 'Perbarui Draf' : 'Simpan Draft' }}
                            </button>
                        </div>
                    </div>

                    <!-- Meta Data Options -->
                    <div class="space-y-10 px-4 lg:px-0">
                        <!-- Category -->
                        <div class="group border-t editorial-border pt-10">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-stone-400 group-hover:text-stone-900 transition-colors mb-4 italic">Kategori Jurnal</h3>
                            <select name="category_id" required class="w-full bg-transparent border-b border-stone-200 rounded-none py-4 text-stone-900 font-serif text-lg focus:border-stone-900 focus:ring-0 outline-none transition-all appearance-none cursor-pointer">
                                <option value="">— Pilih Topik —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<p class="mt-2 text-[10px] font-bold text-red-600 uppercase tracking-widest">{{ $message }}</p>@enderror
                        </div>

                        <!-- Image -->
                        <div class="border-t editorial-border pt-10">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-stone-400 mb-6 italic">Visual Utama</h3>
                            <div class="relative group">
                                <input type="file" name="image" id="image" class="hidden" onchange="previewImage(event)">
                                <label for="image" class="block w-full aspect-[4/3] bg-stone-50 border border-stone-200 flex flex-col items-center justify-center cursor-pointer hover:border-stone-900 transition-all overflow-hidden group">
                                    <div id="image-placeholder" class="text-center p-8 {{ (isset($post) && $post->image) ? 'hidden' : '' }}">
                                        <div class="w-12 h-12 border border-stone-200 flex items-center justify-center rounded-full mb-4 mx-auto group-hover:border-stone-900 transition-colors">
                                            <svg class="w-5 h-5 text-stone-400 group-hover:text-stone-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-stone-400 group-hover:text-stone-900 transition-colors">Unggah Sampul</p>
                                    </div>
                                    <img id="image-preview" src="{{ (isset($post) && $post->image) ? asset('storage/' . $post->image) : '#' }}" alt="Preview" class="{{ (isset($post) && $post->image) ? '' : 'hidden' }} w-full h-full object-cover">
                                </label>
                            </div>
                            @error('image')<p class="mt-2 text-[10px] font-bold text-red-600 uppercase tracking-widest">{{ $message }}</p>@enderror
                        </div>

                        <!-- Tags -->
                        <div class="border-t editorial-border pt-10">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-stone-400 mb-6 italic">Index Tagar</h3>
                            <div class="flex flex-wrap gap-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                                @forelse($tags as $tag)
                                <label class="cursor-pointer relative">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', isset($post) ? $post->tags->pluck('id')->toArray() : [])) ? 'checked' : '' }} class="opacity-0 absolute peer">
                                    <span class="block px-4 py-2 border border-stone-200 text-[10px] font-bold uppercase tracking-widest text-stone-500 hover:border-stone-900 hover:text-stone-900 peer-checked:bg-stone-900 peer-checked:text-stone-50 peer-checked:border-stone-900 transition-all">
                                        {{ $tag->name }}
                                    </span>
                                </label>
                                @empty
                                <p class="text-[10px] font-bold uppercase tracking-widest text-stone-300">Tidak ada tag tersedia</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        const file = event.target.files[0];
        if (file) {
            reader.onload = function() {
                const output = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');
                output.src = reader.result;
                output.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    // GSAP Reveals
    document.addEventListener("DOMContentLoaded", () => {
        gsap.from("header", { y: 30, opacity: 0, duration: 1, ease: "power4.out" });
        gsap.from("trix-toolbar", { y: -20, opacity: 0, duration: 1, delay: 0.2 });
        gsap.from(".lg\\:col-span-4 > div", { x: 30, opacity: 0, duration: 1, delay: 0.4, ease: "power4.out" });
    });
</script>
@endsection
