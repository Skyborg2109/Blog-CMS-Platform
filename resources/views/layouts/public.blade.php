<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ELITE. - @yield('title', 'Jurnal & Inspirasi')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,400i,600,700,800,900" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- GSAP & Lenis -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lenis@1.1.20/dist/lenis.min.js"></script>

    <style>
        body { font-family: 'DM Sans', sans-serif; background-color: #FAFAF9; color: #1C1917; overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6, .font-serif { font-family: 'Playfair Display', serif; }
        .trix-content img { max-width: 100%; height: auto; border-radius: 4px; }
        .editorial-border { border-color: #E7E5E4; }

        /* Noise Texture Overlay */
        .noise-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: url("https://grainy-gradients.vercel.app/noise.svg");
            opacity: 0.05; pointer-events: none; z-index: 9999;
        }

        /* Fluid Background Blobs */
        .bg-blob {
            position: fixed; width: 60vw; height: 60vw; border-radius: 50%;
            filter: blur(120px); opacity: 0.4; z-index: -1; pointer-events: none;
            mix-blend-mode: multiply;
        }

        .lenis.lenis-smooth { scroll-behavior: auto !important; }
        .lenis.lenis-smooth [data-lenis-prevent] { overscroll-behavior: contain; }
        .lenis.lenis-stopped { overflow: hidden; }
        .lenis.lenis-scrolling iframe { pointer-events: none; }
    </style>
    @stack('styles')
</head>
<body class="antialiased selection:bg-stone-800 selection:text-stone-50" x-data="{ mobileMenuOpen: false }">
    <div class="noise-overlay"></div>
    <div class="bg-blob bg-indigo-100" style="top: -10%; right: -10%;"></div>
    <div class="bg-blob bg-rose-50" style="bottom: -10%; left: -10%;"></div>

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-[#FAFAF9] border-b editorial-border transition-all duration-300">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-12">
            <div class="flex justify-between items-center h-24">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <span class="text-3xl font-black tracking-tight font-serif text-stone-900 group-hover:text-stone-600 transition-colors">ELITE.</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-10">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-b-2 border-stone-900 text-stone-900 pb-1' : 'text-stone-800 hover:text-stone-500' }} font-medium text-sm tracking-wide uppercase transition-colors">Beranda</a>
                        @if(Auth::check())
                            <!-- Nav Action: Buat Artikel -->
                            <a href="{{ route('post.create') }}" class="flex items-center space-x-2 {{ request()->routeIs('post.create') ? 'text-stone-900 border-b-2 border-stone-900 pb-1' : 'text-stone-500 hover:text-stone-900' }} transition-colors mr-6 border-r editorial-border pr-6">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span class="text-xs font-bold uppercase tracking-widest">Buat Artikel</span>
                            </a>

                            <!-- Profile Dropdown -->
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" 
                                    class="flex items-center space-x-3 text-sm font-semibold tracking-wide uppercase pb-1 transition-colors focus:outline-none"
                                    :class="(open || {{ request()->routeIs('profile.edit', 'post.my-posts', 'admin.*') ? 'true' : 'false' }}) ? 'border-b-2 border-stone-900 text-stone-900' : 'text-stone-500 hover:text-stone-900'">
                                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute right-0 mt-3 w-48 bg-[#FAFAF9] border editorial-border shadow-xl z-50 py-2">
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 text-xs font-bold uppercase tracking-widest text-stone-600 hover:bg-stone-100 hover:text-stone-900 transition-colors">Admin Panel</a>
                                    @endif
                                    <a href="{{ route('post.my-posts') }}" class="block px-6 py-3 text-xs font-bold uppercase tracking-widest text-stone-600 hover:bg-stone-100 hover:text-stone-900 transition-colors">Tulisan Saya</a>
                                    <a href="{{ route('profile.edit') }}" class="block px-6 py-3 text-xs font-bold uppercase tracking-widest text-stone-600 hover:bg-stone-100 hover:text-stone-900 transition-colors">Profil Saya</a>
                                    <div class="border-t editorial-border my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-6 py-3 text-xs font-bold uppercase tracking-widest text-red-600 hover:bg-red-50 transition-colors">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-stone-800 hover:text-stone-500 font-medium text-sm tracking-wide uppercase transition-colors">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-semibold tracking-wide uppercase bg-stone-900 text-stone-50 px-6 py-3 hover:bg-stone-700 transition-colors">Mulai Menulis</a>
                            @endif
                        @endif
                </div>

                <!-- Mobile menu button -->
                <div class="flex md:hidden items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-stone-900 focus:outline-none p-2">
                        <svg x-show="!mobileMenuOpen" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenuOpen" style="display: none;" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" style="display: none;" class="md:hidden bg-[#FAFAF9] absolute w-full border-b editorial-border shadow-xl h-screen overflow-y-auto" x-transition.opacity>
            <div class="px-6 pt-8 pb-12 space-y-6 text-center">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-2xl font-serif {{ request()->routeIs('home') ? 'text-stone-900' : 'text-stone-400' }} hover:text-stone-600 transition-colors">Beranda</a>
                    @if(Auth::check())
                        <div class="border-t border-b editorial-border py-6 space-y-6">
                            <p class="text-xs font-bold uppercase tracking-widest text-stone-400">Panel Penulis</p>
                            <a href="{{ route('post.create') }}" class="flex items-center justify-center space-x-3 px-3 py-4 text-2xl font-serif text-stone-900 bg-stone-100 hover:bg-stone-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span>Tulis Artikel Baru</span>
                            </a>
                            <div class="grid grid-cols-2 gap-4">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-4 text-lg font-serif text-stone-900 border border-stone-200">Admin Panel</a>
                                @endif
                                <a href="{{ route('post.my-posts') }}" class="block px-3 py-4 text-lg font-serif text-stone-900 border border-stone-200">Tulisan Saya</a>
                                <a href="{{ route('profile.edit') }}" class="block px-3 py-4 text-lg font-serif text-stone-900 border border-stone-200">Profil Saya</a>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center space-y-4 mb-8">
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-stone-100 shadow-xl">
                                <span class="text-xl font-serif text-stone-900">{{ Auth::user()->name }}</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full px-3 py-4 text-lg font-bold uppercase tracking-widest text-red-600 border border-red-100 bg-red-50">Keluar</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-2xl font-serif text-stone-900 hover:text-stone-600">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block px-6 py-4 mx-8 mt-8 text-lg font-medium tracking-wide uppercase bg-stone-900 text-stone-50 hover:bg-stone-700 transition-colors">Mulai Menulis</a>
                        @endif
                    @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen pt-24">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-12">
            @if (session('success'))
                <div class="mb-8 bg-stone-900 text-stone-50 p-6 flex justify-between items-center shadow-2xl" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center space-x-4">
                        <svg class="w-6 h-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <p class="text-sm font-bold uppercase tracking-[0.2em]">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-stone-500 hover:text-white transition-colors">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-8 bg-red-900 text-red-50 p-6 shadow-2xl">
                    <div class="flex items-center space-x-4 mb-4">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-bold uppercase tracking-[0.2em]">Terjadi Kesalahan</p>
                    </div>
                    <ul class="list-disc pl-10 text-xs font-bold uppercase tracking-widest space-y-2 opacity-80">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-stone-900 text-stone-400 py-20 mt-24">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-12 flex flex-col items-center text-center">
            <a href="{{ route('home') }}" class="text-4xl font-black tracking-tight font-serif text-stone-50 mb-8">ELITE.</a>
            <div class="flex space-x-8 mb-12">
                <a href="#" class="text-stone-400 hover:text-stone-50 font-medium tracking-wide uppercase text-sm transition-colors">Twitter</a>
                <a href="#" class="text-stone-400 hover:text-stone-50 font-medium tracking-wide uppercase text-sm transition-colors">Instagram</a>
                <a href="#" class="text-stone-400 hover:text-stone-50 font-medium tracking-wide uppercase text-sm transition-colors">Substack</a>
            </div>
            <div class="text-sm font-medium tracking-wider text-stone-600">
                &copy; {{ date('Y') }} ELITE JOURNAL. BUKAN DIBUAT OLEH AI.
            </div>
        </div>
    </footer>

    <script>
        // Smooth Scroll initialization
        const lenis = new Lenis();
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Animate BG Blobs
        gsap.to(".bg-blob", {
            x: "random(-100, 100)",
            y: "random(-100, 100)",
            duration: 15,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut",
            stagger: 2
        });
    </script>
    @stack('scripts')
</body>
</html>
