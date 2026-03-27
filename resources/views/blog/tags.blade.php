@extends('layouts.public')

@section('title', 'Index Tag - Arsitektur Narasi')

@section('content')
<div class="relative py-24 bg-stone-900 border-b editorial-border overflow-hidden">
    <div class="max-w-screen-2xl mx-auto px-6 md:px-12 relative z-10">
        <span class="inline-block text-xs font-bold tracking-[0.3em] uppercase text-stone-400 mb-8 border-b-2 border-stone-500 pb-2">
            Eksplorasi Topik
        </span>
        <h1 class="text-6xl md:text-8xl font-black font-serif text-white leading-tight tracking-tighter mb-6">
            Index <span class="text-stone-400 italic">Tag.</span>
        </h1>
        <p class="text-xl text-stone-300 font-medium max-w-2xl">
            Telusuri seluruh koleksi pemikiran kami melalui klasifikasi kata kunci yang dikurasi secara mendalam.
        </p>
    </div>
    <div class="absolute right-0 top-0 w-1/3 h-full opacity-10 pointer-events-none">
        <span class="text-[20rem] font-serif font-black text-white leading-none select-none">TAGS</span>
    </div>
</div>

<div class="max-w-screen-2xl mx-auto px-6 md:px-12 py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($tags as $tag)
        <a href="{{ route('home', ['tag' => $tag->slug]) }}" class="group relative p-8 border editorial-border hover:border-stone-900 transition-all duration-500 bg-white">
            <div class="flex flex-col h-full">
                <span class="text-xs font-bold uppercase tracking-widest text-stone-400 mb-2 group-hover:text-stone-900 transition-colors">
                    #{{ $tag->slug }}
                </span>
                <h3 class="text-2xl font-black font-serif text-stone-900 mb-4">{{ $tag->name }}</h3>
                <div class="mt-auto flex items-center justify-between">
                    <span class="text-xs font-bold text-stone-500 uppercase tracking-tight">{{ $tag->posts_count }} Artikel</span>
                    <div class="w-8 h-px bg-stone-200 group-hover:w-12 group-hover:bg-stone-900 transition-all duration-500"></div>
                </div>
            </div>
            <!-- Decorative corner hover effect -->
            <div class="absolute top-0 right-0 w-0 h-0 border-t-2 border-r-2 border-stone-900 opacity-0 group-hover:opacity-100 transition-all duration-500 group-hover:w-4 group-hover:h-4"></div>
        </a>
        @endforeach
    </div>
    
    @if($tags->isEmpty())
    <div class="text-center py-24 border editorial-border bg-stone-50">
        <span class="font-serif text-4xl text-stone-300 block mb-4">ELITE.</span>
        <h3 class="text-xl font-bold text-stone-900 mb-2 uppercase tracking-wide">Index Kosong</h3>
        <p class="text-stone-500">Belum ada tag yang terdaftar dalam sistem kami.</p>
    </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.from("h1", { y: 40, opacity: 0, duration: 1, ease: "power4.out" });
        gsap.from(".grid a", {
            y: 30,
            opacity: 0,
            stagger: 0.1,
            duration: 0.8,
            ease: "power3.out"
        });
    });
</script>
@endsection
