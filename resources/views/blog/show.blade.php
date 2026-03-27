@extends('layouts.public')

@section('title', $post->title)

@section('content')
<style>
    .article-body img { max-width: 100%; height: auto; border-radius: 2px; }
    .article-body p { margin-top: 1.5em; margin-bottom: 1.5em; }
    .article-body p:first-child { margin-top: 0; }
    .article-body h1, .article-body h2, .article-body h3 {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
        margin-top: 2em;
        margin-bottom: 0.75em;
        color: #1c1917;
        line-height: 1.2;
    }
    .article-body h2 { font-size: 1.75rem; }
    .article-body h3 { font-size: 1.35rem; }
    .article-body ul, .article-body ol { padding-left: 1.5rem; margin: 1.5em 0; }
    .article-body li { margin: 0.5em 0; }
    .article-body blockquote {
        border-left: 3px solid #1c1917;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #57534e;
    }
    .article-body strong { font-weight: 800; color: #1c1917; }
    .article-body a { color: #1c1917; text-decoration: underline; text-underline-offset: 3px; }
    .article-body a:hover { opacity: 0.6; }
    .article-body pre, .article-body code {
        background: #f5f5f4;
        padding: 0.2em 0.4em;
        border-radius: 2px;
        font-size: 0.9em;
        word-break: break-all;
        overflow-wrap: anywhere;
        white-space: pre-wrap;
    }
</style>

<div class="max-w-screen-2xl mx-auto px-6 md:px-12 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-12 gap-16 min-w-0">
    <!-- Main Article Content -->
    <article class="lg:col-span-8 min-w-0 overflow-hidden">
        
        <!-- Post Header -->
        <header class="mb-12">
            <div class="flex items-center flex-wrap gap-4 text-xs font-bold uppercase tracking-[0.3em] text-stone-500 mb-8">
                <a href="{{ route('home', ['category' => $post->category->slug]) }}" class="text-stone-900 border-b-2 border-stone-900 pb-1 hover:text-stone-500 hover:border-stone-500 transition-colors">
                    {{ $post->category->name }}
                </a>
                <span>&mdash;</span>
                @if($post->status === 'draft')
                    <span class="bg-amber-50 text-amber-600 border border-amber-200 px-3 py-0.5 text-[9px] italic tracking-widest">PRATINJAU DRAF</span>
                    <time datetime="{{ $post->created_at }}">{{ $post->created_at->format('d M Y') }}</time>
                @else
                    <time datetime="{{ $post->published_at }}">{{ $post->published_at->format('d M Y') }}</time>
                @endif
            </div>
            
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black font-serif text-stone-900 leading-[1.05] tracking-tight mb-10 break-words">
                {{ $post->title }}
            </h1>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 border-y-2 border-stone-900 py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-8 h-px bg-stone-900"></div>
                    <div class="flex flex-col">
                        <span class="text-stone-400 text-[9px] mb-1 font-black tracking-[0.25em] uppercase">Pena Oleh</span>
                        <span class="text-lg md:text-xl font-serif lowercase italic text-stone-900">{{ $post->user->name }}</span>
                    </div>
                </div>
                
                @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('home', ['tag' => $tag->slug]) }}" class="px-3 py-1 border border-stone-200 text-stone-400 text-[10px] font-bold uppercase tracking-widest hover:border-stone-900 hover:text-stone-900 transition-colors">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </header>

        <!-- Cover Image -->
        @if($post->image)
        <figure class="mb-10">
            <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-auto object-cover" alt="{{ $post->title }}">
            <figcaption class="text-[9px] text-stone-400 mt-3 font-medium uppercase tracking-widest italic text-right">
                Dokumentasi Edisi: {{ $post->title }}
            </figcaption>
        </figure>
        @endif

        <!-- Article Content -->
        <div class="border-t-2 border-stone-900 pt-10 mb-20">
            <div class="article-body text-stone-800 leading-relaxed text-lg font-serif" style="overflow-wrap: anywhere; word-break: break-word;">
                {!! $post->body !!}
            </div>
        </div>

        <!-- Comments Section -->
        <section class="pt-16 border-t-4 border-stone-900" id="comments">
            <div class="flex items-center justify-between mb-12">
                <h2 class="text-3xl font-black font-serif text-stone-900 tracking-tight">Komentar</h2>
                <span class="text-xl font-serif text-stone-400">({{ $post->comments->count() }})</span>
            </div>
            
            <!-- Comment Form -->
            <div class="bg-stone-50 p-8 md:p-12 mb-16 border border-stone-200">
                <h3 class="text-lg font-bold font-serif text-stone-900 mb-8 border-b-2 border-stone-900 inline-block pb-2">Tinggalkan Jejak</h3>
                
                <form action="{{ route('post.comment.store', $post) }}" method="POST">
                    @csrf
                    
                    @if(!Auth::check())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-xs font-bold uppercase tracking-widest text-stone-900 mb-3">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required class="w-full px-4 py-3 border-b border-stone-300 focus:outline-none focus:border-stone-900 bg-transparent transition-all">
                            @error('name')<p class="mt-2 text-xs text-red-600 uppercase tracking-widest">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-widest text-stone-900 mb-3">Surel</label>
                            <input type="email" name="email" id="email" required class="w-full px-4 py-3 border-b border-stone-300 focus:outline-none focus:border-stone-900 bg-transparent transition-all">
                            @error('email')<p class="mt-2 text-xs text-red-600 uppercase tracking-widest">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    @else
                    <div class="mb-6 pb-6 border-b border-stone-200">
                        <p class="text-sm font-medium text-stone-900">Menulis sebagai <span class="font-black italic underline">{{ Auth::user()->name }}</span>.</p>
                    </div>
                    @endif
                    
                    <div class="mb-6">
                        <label for="comment_body" class="block text-xs font-bold uppercase tracking-widest text-stone-900 mb-3">Pemikiran Anda</label>
                        <textarea name="body" id="comment_body" rows="5" required class="w-full px-4 py-3 border border-stone-200 focus:outline-none focus:border-stone-900 bg-transparent transition-all resize-y"></textarea>
                        @error('body')<p class="mt-2 text-xs text-red-600 uppercase tracking-widest">{{ $message }}</p>@enderror
                    </div>
                    
                    <button type="submit" class="bg-stone-900 text-stone-50 px-8 py-4 font-bold uppercase tracking-widest text-xs hover:bg-stone-700 transition-colors w-full md:w-auto">
                        Kirim Komentar
                    </button>
                </form>
            </div>

            <!-- Comments List -->
            <div class="space-y-10">
                @forelse($post->comments as $comment)
                <div class="pt-8 border-t editorial-border" id="comment-{{ $comment->id }}">
                    <div class="flex items-start justify-between mb-4 gap-4">
                        <div class="flex items-center space-x-3 text-sm font-bold uppercase tracking-wide text-stone-900">
                            <h4>{{ $comment->user ? $comment->user->name : $comment->name }}</h4>
                            @if($comment->user && $comment->user->role === 'admin')
                                <span class="bg-stone-900 text-stone-50 text-[9px] font-bold tracking-[0.2em] px-2 py-1">REDAKSI</span>
                            @elseif($comment->user && $comment->user->role === 'author')
                                <span class="border border-stone-900 text-stone-900 text-[9px] font-bold tracking-[0.2em] px-2 py-1">PENULIS</span>
                            @endif
                        </div>
                        <time class="text-xs font-medium text-stone-400 uppercase tracking-widest whitespace-nowrap">{{ $comment->created_at->format('d M Y') }}</time>
                    </div>
                    <p class="text-stone-700 font-serif leading-relaxed text-lg italic">"{{ $comment->body }}"</p>
                </div>
                @empty
                <div class="text-center py-12">
                    <span class="font-serif text-3xl text-stone-200 block mb-3">ELITE.</span>
                    <p class="text-stone-400 font-serif italic">Belum ada diskusi untuk edisi ini.</p>
                </div>
                @endforelse
            </div>
        </section>
    </article>

    <!-- Sidebar -->
    <aside class="lg:col-span-4 space-y-12">
        <div>
            <h3 class="text-[11px] font-black tracking-[0.3em] uppercase text-stone-900 mb-6 border-b-2 border-stone-900 pb-4">Topik Eksklusif</h3>
            <ul class="space-y-4">
                @foreach($categories as $cat)
                <li>
                    <a href="{{ route('home', ['category' => $cat->slug]) }}" class="group flex items-center justify-between text-stone-500 hover:text-stone-900 transition-colors">
                        <span class="text-lg font-serif italic {{ $post->category_id === $cat->id ? 'font-black text-stone-900 not-italic' : '' }}">{{ $cat->name }}</span>
                        <span class="text-[10px] font-black {{ $post->category_id === $cat->id ? 'text-stone-900' : 'text-stone-300 group-hover:text-stone-900' }} transition-colors">[{{ $cat->posts()->where('status', 'published')->count() }}]</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-stone-50 p-8 border editorial-border">
            <h3 class="text-[11px] font-black tracking-[0.3em] uppercase text-stone-900 mb-6">Tag Terkait</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                <a href="{{ route('home', ['tag' => $tag->slug]) }}" class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest border border-stone-200 text-stone-500 hover:border-stone-900 hover:text-stone-900 transition-colors">
                    {{ $tag->name }}
                </a>
                @endforeach
            </div>
        </div>
    </aside>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const tl = gsap.timeline({ defaults: { ease: "power3.out", duration: 1 }});

        tl.from("header .text-stone-500", { y: -20, opacity: 0, duration: 0.8 })
          .from("h1", { y: 30, opacity: 0, delay: -0.6 })
          .from(".border-y-2", { scaleX: 0, transformOrigin: "center", opacity: 0, duration: 1.2 }, "-=0.6")
          .from(".border-y-2 *", { y: 15, opacity: 0, stagger: 0.1 }, "-=0.8")
          .from("article > div img", { scale: 1.1, opacity: 0, duration: 1.5, ease: "expo.out" }, "-=1")
          .from(".custom-content", { y: 40, opacity: 0, duration: 1.2 }, "-=0.8");

        // Reveal comments on scroll
        gsap.from("#comments > div", {
            scrollTrigger: {
                trigger: "#comments",
                start: "top 80%"
            },
            y: 40,
            opacity: 0,
            duration: 1,
            stagger: 0.1
        });
    });
</script>
@endsection
