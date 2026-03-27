@extends('layouts.public')

@section('title', 'Jurnal & Inspirasi')

@section('content')
<!-- Editorial Hero Section -->
<div class="relative min-h-[80vh] flex items-center overflow-hidden border-b editorial-border bg-stone-900">
    <!-- Background Image with Parallax effect via GSAP later -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=2000" class="w-full h-full object-cover opacity-30 grayscale" alt="Hero Background">
        <div class="absolute inset-0 bg-gradient-to-r from-stone-900 via-stone-900/80 to-transparent"></div>
    </div>

    <div class="max-w-screen-2xl mx-auto px-6 md:px-12 py-24 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-8">
                <span class="inline-block text-xs font-bold tracking-[0.3em] uppercase text-stone-400 mb-8 border-b-2 border-stone-500 pb-2">
                    Edisi Khusus Artikel
                </span>
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-black font-serif text-white leading-[0.95] tracking-tighter mb-10">
                    Narasi <br>
                    <span class="text-stone-400 italic">Masa Depan.</span>
                </h1>
                <p class="text-xl md:text-2xl text-stone-300 font-medium leading-relaxed max-w-2xl mb-12">
                    Eksplorasi mendalam mengenai teknologi, budaya, dan transformasi sosial di jantung nusantara.
                </p>
                <form action="{{ route('home') }}" method="GET" class="flex max-w-xl border-b-2 border-stone-500 group focus-within:border-white transition-colors">
                    <input type="text" name="search" placeholder="Cari arsip berita..." class="w-full bg-transparent border-none py-6 text-white placeholder-stone-500 focus:outline-none focus:ring-0 text-xl font-serif">
                    <button type="submit" class="px-8 text-stone-400 group-hover:text-white font-bold tracking-widest uppercase text-sm transition-colors">Telusuri</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Decorative vertical line -->
    <div class="absolute right-12 bottom-0 w-px h-32 bg-stone-700 hidden lg:block"></div>
</div>

<div class="max-w-screen-2xl mx-auto px-6 md:px-12 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-12 gap-16">
    <!-- Main Content -->
    <div class="lg:col-span-8">
        <div class="flex items-end justify-between mb-12 border-b-4 border-stone-900 pb-6">
            <h2 class="text-3xl font-black font-serif tracking-tight text-stone-900 uppercase">Artikel Pilihan</h2>
            @if(request('category') || request('tag'))
                <a href="{{ route('home') }}" class="text-sm text-stone-500 font-bold uppercase tracking-wider hover:text-stone-900 transition-colors">Hapus Filter &times;</a>
            @endif
        </div>

        <div class="space-y-16">
            @forelse($posts as $post)
            <article class="group grid grid-cols-1 md:grid-cols-5 gap-8 items-start">
                <div class="md:col-span-3 order-2 md:order-1 flex flex-col justify-center">
                    <div class="flex items-center space-x-3 text-xs font-bold uppercase tracking-widest text-stone-500 mb-4">
                        <a href="{{ route('home', ['category' => $post->category->slug]) }}" class="text-stone-900 hover:text-stone-500 transition-colors border-b border-stone-900 pb-0.5">
                            {{ $post->category->name }}
                        </a>
                        <span>&mdash;</span>
                        <time datetime="{{ $post->published_at }}">{{ $post->published_at->format('d M Y') }}</time>
                    </div>
                    
                    <a href="{{ route('post.show', $post->slug) }}" class="block mb-4">
                        <h3 class="text-3xl font-black font-serif text-stone-900 leading-snug group-hover:text-stone-600 transition-colors">{{ $post->title }}</h3>
                    </a>
                    
                    <div class="prose prose-stone text-stone-600 line-clamp-3 mb-6">
                        {!! strip_tags($post->body) !!}
                    </div>
                    
                    <div class="flex items-center justify-between pt-4 border-t editorial-border mt-auto">
                        <span class="text-sm font-bold tracking-wide uppercase text-stone-900">Oleh {{ $post->user->name }}</span>
                        <a href="{{ route('post.show', $post->slug) }}" class="text-sm font-bold tracking-wide uppercase text-stone-400 group-hover:text-stone-900 transition-colors flex items-center">
                            Baca <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
                
                <div class="md:col-span-2 order-1 md:order-2">
                    <a href="{{ route('post.show', $post->slug) }}" class="block overflow-hidden relative aspect-w-4 aspect-h-3 bg-stone-100">
                        @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="{{ $post->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="font-serif text-stone-300 text-4xl font-black">ELITE.</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 border border-stone-900/10 pointer-events-none group-hover:border-stone-900/30 transition-colors duration-700"></div>
                    </a>
                </div>
            </article>
            @empty
            <div class="text-center py-24 border editorial-border bg-white">
                <span class="font-serif text-4xl text-stone-300 block mb-4">ELITE.</span>
                <h3 class="text-xl font-bold text-stone-900 mb-2 uppercase tracking-wide">Tidak ada Artikel</h3>
                <p class="text-stone-500">Kriteria pencarian Anda tidak ditemukan dalam arsip kami.</p>
                @if(request('category') || request('tag'))
                    <a href="{{ route('home') }}" class="mt-8 inline-block border-b-2 border-stone-900 pb-1 font-bold text-stone-900 uppercase tracking-widest text-sm hover:text-stone-500 hover:border-stone-500 transition-colors">Lihat Semua Edisi</a>
                @endif
            </div>
            @endforelse
        </div>

        @if($posts->hasPages())
        <div class="mt-20 border-t editorial-border pt-8 flex justify-between items-center text-sm font-bold tracking-widest uppercase">
            {{ $posts->links() }}
        </div>
        @endif
    </div>

    <!-- Sidebar Menu Minimalist -->
    <aside class="lg:col-span-4 space-y-16">
        <!-- Categories -->
        <div>
            <h3 class="text-sm font-bold tracking-[0.2em] uppercase text-stone-900 mb-6 border-b-2 border-stone-900 pb-4">Topik Eksklusif</h3>
            <ul class="space-y-4">
                @foreach($categories as $cat)
                <li>
                    <a href="{{ route('home', ['category' => $cat->slug]) }}" class="group flex items-center justify-between text-stone-600 hover:text-stone-900 transition-colors">
                        <span class="text-lg font-serif {{ request('category') === $cat->slug ? 'font-black text-stone-900' : '' }}">{{ $cat->name }}</span>
                        <span class="text-xs font-bold {{ request('category') === $cat->slug ? 'text-stone-900' : 'text-stone-400 group-hover:text-stone-900' }} transition-colors">({{ $cat->posts()->where('status', 'published')->count() }})</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div>
            <div class="flex items-center justify-between mb-6 border-b-2 border-stone-900 pb-4">
                <h3 class="text-sm font-bold tracking-[0.2em] uppercase text-stone-900">Index Tag</h3>
                <a href="{{ route('tags.index') }}" class="text-[10px] font-black uppercase tracking-widest text-stone-400 hover:text-stone-900 transition-colors">Lihat Semua &rarr;</a>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                <a href="{{ route('home', ['tag' => $tag->slug]) }}" class="px-3 py-1 text-xs font-bold uppercase tracking-widest border {{ request('tag') === $tag->slug ? 'border-stone-900 bg-stone-900 text-stone-50' : 'editorial-border text-stone-500 hover:border-stone-900 hover:text-stone-900' }} transition-colors">
                    {{ $tag->name }}
                </a>
                @endforeach
            </div>
        </div>
        
        <!-- Newsletter -->
        <div class="bg-stone-900 text-stone-50 p-10 border border-stone-900">
            <h3 class="text-2xl font-black font-serif mb-4 leading-tight">Buletin Mingguan.</h3>
            <p class="text-stone-400 text-sm mb-8 leading-relaxed">Dapatkan kurasi artikel terbaik langsung ke kotak masuk Anda. Tanpa spam, hanya artikel berkualitas.</p>
            <form class="space-y-4">
                <input type="email" placeholder="Alamat Surel" class="w-full bg-transparent border-b border-stone-700 py-3 text-stone-50 placeholder-stone-600 focus:outline-none focus:border-stone-50 text-sm transition-colors">
                <button type="button" class="w-full bg-stone-50 text-stone-900 font-bold uppercase tracking-widest text-xs py-4 hover:bg-stone-300 transition-colors mt-4">Berlangganan</button>
            </form>
        </div>
    </aside>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Hero Intro Animation
        const heroTl = gsap.timeline({ defaults: { ease: "power4.out", duration: 1.2 }});
        
        heroTl.from(".editorial-border span", { y: 20, opacity: 0, duration: 0.8 }, 0.2)
              .from("h1", { y: 40, opacity: 0, skewY: 2, stagger: 0.1 }, "-=0.6")
              .from(".lg\\:col-span-7 p", { y: 20, opacity: 0 }, "-=0.8")
              .from("form", { x: -20, opacity: 0 }, "-=0.8")
              .from(".lg\\:col-span-5", { clipPath: "inset(0 0 100% 0)", opacity: 0, duration: 1.5 }, "-=1");

        // Scroll Reveal for Articles
        gsap.utils.toArray("article").forEach((article, i) => {
            gsap.from(article, {
                scrollTrigger: {
                    trigger: article,
                    start: "top 90%",
                    toggleActions: "play none none none"
                },
                y: 50,
                opacity: 0,
                duration: 1,
                ease: "power3.out",
                delay: i % 2 * 0.1 // Slight stagger for grid items
            });
        });

        // Sidebar Widgets reveal
        gsap.from("aside > div", {
            scrollTrigger: {
                trigger: "aside",
                start: "top 85%"
            },
            y: 30,
            opacity: 0,
            stagger: 0.2,
            duration: 1,
            ease: "back.out(1.7)"
        });
    });
</script>
@endsection
