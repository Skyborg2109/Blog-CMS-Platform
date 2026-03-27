@extends('layouts.public')

@section('title', 'Tulisan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 lg:py-20">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <div class="flex items-center space-x-4 mb-4">
                <span class="w-12 h-px bg-stone-300"></span>
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-stone-400">Manajemen Konten</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black font-serif text-stone-900 tracking-tight">Tulisan Saya.</h1>
        </div>
        <a href="{{ route('post.create') }}" class="bg-stone-900 text-stone-50 px-8 py-4 font-bold uppercase tracking-widest text-[11px] hover:bg-stone-800 transition-all shadow-xl">
            Tulis Artikel Baru
        </a>
    </div>

    <!-- Filter/Tabs would go here, but let's keep it simple and premium -->
    <div class="border-t-2 border-stone-900 pt-12">
        @if($posts->count() > 0)
            <div class="space-y-8">
                @foreach($posts as $post)
                    <div class="group relative bg-white border editorial-border p-8 hover:shadow-[30px_30px_0px_0px_rgba(0,0,0,0.02)] transition-all duration-500">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                            <div class="flex-1 space-y-4">
                                <div class="flex items-center space-x-4">
                                    <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $post->status === 'published' ? 'bg-stone-900 text-stone-50' : 'bg-stone-100 text-stone-400' }}">
                                        {{ $post->status === 'published' ? 'Telah Terbit' : 'Draf' }}
                                    </span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400">{{ $post->category->name }}</span>
                                    <span class="text-[10px] uppercase tracking-widest text-stone-300">{{ $post->created_at->format('d M, Y') }}</span>
                                </div>
                                <h2 class="text-2xl md:text-3xl font-bold font-serif text-stone-900 group-hover:text-stone-600 transition-colors leading-tight">
                                    {{ $post->title }}
                                </h2>
                            </div>
                            
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="{{ route('post.show', $post->slug) }}" class="px-6 py-3 border editorial-border text-[10px] font-bold uppercase tracking-widest hover:bg-stone-50 transition-colors">
                                    Lihat
                                </a>
                                <a href="{{ route('post.edit', $post->id) }}" class="px-6 py-3 border editorial-border text-[10px] font-bold uppercase tracking-widest hover:bg-stone-900 hover:text-stone-50 hover:border-stone-900 transition-all">
                                    Edit
                                </a>
                                <form action="{{ route('post.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-600 transition-colors underline underline-offset-8 decoration-red-100 hover:decoration-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-16">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-24 border-2 border-dashed border-stone-100">
                <p class="text-stone-400 font-serif italic text-xl mb-8">Anda belum memiliki tulisan.</p>
                <a href="{{ route('post.create') }}" class="text-stone-900 font-black uppercase tracking-[0.3em] text-xs border-b-2 border-stone-900 pb-2 hover:text-stone-500 hover:border-stone-500 transition-all">
                    Mulai Menulis Pertama Anda
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
