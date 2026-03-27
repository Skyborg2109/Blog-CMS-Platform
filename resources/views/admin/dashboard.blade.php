@extends('layouts.admin')

@section('content')
<div class="mb-12">
    <span class="inline-block text-[10px] font-black tracking-[0.4em] uppercase text-stone-400 mb-4 border-b border-stone-200 pb-2">
        Editorial Overview
    </span>
    <h1 class="text-5xl md:text-6xl font-black text-stone-900 tracking-tighter leading-none mb-4">
        @if(auth()->user()->role === 'admin')
            System <span class="text-stone-400 italic font-serif font-normal">Intelligence.</span>
        @else
            Author <span class="text-stone-400 italic font-serif font-normal">Workspace.</span>
        @endif
    </h1>
    <p class="text-stone-500 font-medium max-w-2xl">
        Selamat datang kembali, <span class="text-stone-900 font-bold border-b border-stone-900 pb-0.5">{{ Auth::user()->name }}</span>. 
        @if(auth()->user()->role === 'admin')
            Berikut adalah ringkasan performa ekosistem konten hari ini.
        @else
            Berikut adalah ringkasan progres publikasi narasi Anda hari ini.
        @endif
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-16">
    
    <!-- Posts Stat -->
    <div class="stat-card bg-white p-8 rounded-3xl border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 group relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-stone-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-8">
                <span class="text-[10px] font-black tracking-[0.2em] uppercase text-stone-400">
                    @if(auth()->user()->role === 'admin') Total Posts @else Your Posts @endif
                </span>
                <div class="p-3 bg-stone-900 text-white rounded-2xl shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
            </div>
            <div class="flex items-baseline space-x-2">
                <h3 class="text-5xl font-black font-serif text-stone-900 leading-none">{{ $stats['posts'] }}</h3>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="mt-8 flex items-center text-[10px] font-black tracking-widest uppercase text-stone-400 group-hover:text-stone-900 transition-colors">
                Explore Archives <svg class="ml-2 w-3 h-3 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
    <!-- Categories Stat -->
    <div class="stat-card bg-white p-8 rounded-3xl border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 group relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-stone-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-8">
                <span class="text-[10px] font-black tracking-[0.2em] uppercase text-stone-400">Categories</span>
                <div class="p-3 bg-stone-100 text-stone-900 rounded-2xl shadow-sm border border-stone-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
            </div>
            <div class="flex items-baseline space-x-2">
                <h3 class="text-5xl font-black font-serif text-stone-900 leading-none">{{ $stats['categories'] }}</h3>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="mt-8 flex items-center text-[10px] font-black tracking-widest uppercase text-stone-400 group-hover:text-stone-900 transition-colors">
                Manage Topics <svg class="ml-2 w-3 h-3 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
    @endif

    @if(auth()->user()->role === 'admin')
    <!-- Tags Stat -->
    <div class="stat-card bg-white p-8 rounded-3xl border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 group relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-stone-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-8">
                <span class="text-[10px] font-black tracking-[0.2em] uppercase text-stone-400">Global Tags</span>
                <div class="p-3 bg-stone-100 text-stone-900 rounded-2xl shadow-sm border border-stone-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                </div>
            </div>
            <div class="flex items-baseline space-x-2">
                <h3 class="text-5xl font-black font-serif text-stone-900 leading-none">{{ $stats['tags'] }}</h3>
            </div>
            <a href="{{ route('admin.tags.index') }}" class="mt-8 flex items-center text-[10px] font-black tracking-widest uppercase text-stone-400 group-hover:text-stone-900 transition-colors">
                Taxonomy Index <svg class="ml-2 w-3 h-3 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
    @endif

    @if(auth()->user()->role === 'admin')
    <!-- Comments Stat -->
    <div class="stat-card bg-white p-8 rounded-3xl border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 group relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-stone-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-8">
                <span class="text-[10px] font-black tracking-[0.2em] uppercase text-stone-400">Reader Feedback</span>
                <div class="p-3 bg-stone-100 text-stone-900 rounded-2xl shadow-sm border border-stone-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
            </div>
            <div class="flex items-baseline space-x-2">
                <h3 class="text-5xl font-black font-serif text-stone-900 leading-none">{{ $stats['comments'] }}</h3>
            </div>
            <a href="{{ route('admin.comments.index') }}" class="mt-8 flex items-center text-[10px] font-black tracking-widest uppercase text-stone-400 group-hover:text-stone-900 transition-colors">
                Moderate Talk <svg class="ml-2 w-3 h-3 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
    @endif

</div>

<!-- Quick Actions Section -->
<div class="bg-stone-900 rounded-[2.5rem] p-12 text-white shadow-2xl relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-stone-800 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50"></div>
    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-12">
        <div>
            <h2 class="text-3xl font-black font-serif mb-4 tracking-tighter italic">Luncurkan Narasi Baru?</h2>
            <p class="text-stone-400 max-w-md font-medium">Buat konten eksklusif Anda sekarang dan bagikan pemikiran terbaik Anda kepada pembaca setia ELITE.</p>
        </div>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.posts.create') }}" class="px-8 py-5 bg-white text-stone-900 font-black uppercase tracking-[0.2em] text-[10px] rounded-2xl hover:bg-stone-200 transition-all flex items-center shadow-xl">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Write New Article
            </a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.categories.create') }}" class="px-8 py-5 bg-stone-800 text-stone-400 border border-stone-700 font-black uppercase tracking-[0.2em] text-[10px] rounded-2xl hover:bg-stone-700 hover:text-white transition-all flex items-center shadow-lg">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Define Topic
            </a>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.from(".stat-card", {
            y: 30,
            opacity: 0,
            duration: 1,
            stagger: 0.1,
            ease: "power3.out",
            delay: 0.8
        });
        gsap.from(".bg-stone-900", {
            scale: 0.95,
            opacity: 0,
            duration: 1.2,
            ease: "back.out(1.2)",
            delay: 1.2
        });
    });
</script>
@endsection
