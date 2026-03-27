<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Editorial</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,700,900" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine JS & GSAP -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F5F5F4; color: #1C1917; }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
        .sidebar-link-active { background-color: #1C1917 !important; color: #FAFAF9 !important; shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
    @stack('styles')
</head>
<body class="antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Backdrop -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-stone-900/40 backdrop-blur-sm transition-opacity lg:hidden" @click="sidebarOpen = false" x-transition.opacity></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-stone-200 transition-transform duration-500 ease-in-out lg:static lg:translate-x-0">
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between h-24 px-8 border-b border-stone-100">
                    <a href="{{ route('admin.dashboard') }}" class="text-3xl font-black font-serif tracking-tighter text-stone-900">
                        ELITE<span class="text-stone-400">.</span>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden p-2 text-stone-400 hover:text-stone-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Navigation Area -->
                <div class="flex-1 overflow-y-auto py-8 px-4 space-y-1">
                    <p class="px-4 text-[10px] font-black uppercase tracking-[0.3em] text-stone-400 mb-4">Main Menu</p>
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : 'text-stone-500 hover:bg-stone-50 hover:text-stone-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-stone-400' : 'text-stone-300 group-hover:text-stone-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="text-sm font-bold tracking-tight">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.posts.*') ? 'sidebar-link-active' : 'text-stone-500 hover:bg-stone-50 hover:text-stone-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.posts.*') ? 'text-stone-400' : 'text-stone-300 group-hover:text-stone-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        <span class="text-sm font-bold tracking-tight">Post Management</span>
                    </a>

                    @if(Auth::user()->role === 'admin')
                    <div class="pt-6 pb-2">
                        <p class="px-4 text-[10px] font-black uppercase tracking-[0.3em] text-stone-400 mb-4">Administration</p>
                    </div>

                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.categories.*') ? 'sidebar-link-active' : 'text-stone-500 hover:bg-stone-50 hover:text-stone-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.categories.*') ? 'text-stone-400' : 'text-stone-300 group-hover:text-stone-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <span class="text-sm font-bold tracking-tight">Categories</span>
                    </a>

                    <a href="{{ route('admin.tags.index') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.tags.*') ? 'sidebar-link-active' : 'text-stone-500 hover:bg-stone-50 hover:text-stone-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.tags.*') ? 'text-stone-400' : 'text-stone-300 group-hover:text-stone-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        <span class="text-sm font-bold tracking-tight">Quick Tags</span>
                    </a>
                    
                    <a href="{{ route('admin.comments.index') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.comments.*') ? 'sidebar-link-active' : 'text-stone-500 hover:bg-stone-50 hover:text-stone-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.comments.*') ? 'text-stone-400' : 'text-stone-300 group-hover:text-stone-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        <span class="text-sm font-bold tracking-tight">Editorial Comments</span>
                    </a>
                    @endif
                </div>

                <!-- Sidebar Footer -->
                <div class="p-8 border-t border-stone-100 bg-stone-50/50">
                    <a href="{{ route('home') }}" class="flex items-center justify-center p-4 bg-white border border-stone-200 rounded-xl text-stone-900 font-bold text-xs uppercase tracking-widest hover:bg-stone-900 hover:text-white transition-all duration-500 shadow-sm">
                        View Public Site
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between h-24 px-8 bg-white/70 backdrop-blur-md border-b border-stone-100 z-10">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="p-2 mr-6 text-stone-400 rounded-xl lg:hidden hover:bg-stone-50 hover:text-stone-900 transition-all">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="hidden lg:block">
                        <span class="text-xs font-black uppercase tracking-[0.2em] text-stone-400">Editorial CMS v2.0</span>
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-3 p-1 rounded-full hover:bg-stone-50 transition-all group">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover shadow-sm group-hover:shadow-md transition-all border-2 border-white">
                            <div class="hidden md:block text-left mr-2">
                                <p class="text-sm font-bold text-stone-900 leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-stone-400 mt-1">{{ Auth::user()->role }}</p>
                            </div>
                            <svg class="w-4 h-4 text-stone-400 transition-transform duration-300" :class="{'rotate-180': dropdownOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Dropdown Content -->
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute right-0 mt-4 w-56 bg-white rounded-2xl shadow-2xl border border-stone-100 py-3 z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-6 py-3 text-xs font-bold uppercase tracking-widest text-stone-600 hover:bg-stone-50 hover:text-stone-900 transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Account Profile
                            </a>
                            <div class="border-t border-stone-50 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-6 py-3 text-xs font-bold uppercase tracking-widest text-red-500 hover:bg-red-50 transition-colors text-left">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-stone-50 p-8 lg:p-12">
                <div class="max-w-7xl mx-auto">
                    @if (session('success'))
                        <div class="mb-10 bg-stone-900 text-stone-50 p-6 flex justify-between items-center shadow-xl rounded-xl" x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex items-center space-x-4">
                                <svg class="w-6 h-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="text-xs font-black uppercase tracking-[0.2em]">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="text-stone-600 hover:text-white transition-colors">&times;</button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            gsap.from("aside", { x: -100, opacity: 0, duration: 1, ease: "power4.out" });
            gsap.from("header", { y: -50, opacity: 0, duration: 1, ease: "power4.out", delay: 0.2 });
            gsap.from("main", { opacity: 0, duration: 1.5, ease: "power2.out", delay: 0.5 });
        });
    </script>
    @stack('scripts')
</body>
</html>
