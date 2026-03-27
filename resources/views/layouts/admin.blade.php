<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine JS for Mobile Menu -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Backdrop -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black/50 transition-opacity lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-xl transition-transform duration-300 lg:static lg:translate-x-0">
            <div class="flex items-center justify-center h-20 border-b border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                    Blog CMS
                </a>
            </div>

            <nav class="p-4 space-y-2 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.posts.index') }}" class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all font-medium {{ request()->routeIs('admin.posts.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    Posts
                </a>

                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.categories.index') }}" class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Categories
                </a>

                <a href="{{ route('admin.tags.index') }}" class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all font-medium {{ request()->routeIs('admin.tags.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                    Tags
                </a>
                
                <a href="{{ route('admin.comments.index') }}" class="flex items-center p-3 text-gray-700 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all font-medium {{ request()->routeIs('admin.comments.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    Comments
                </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between p-4 bg-white/70 backdrop-blur-md border-b border-gray-100">
                <!-- Mobile button -->
                <button @click="sidebarOpen = true" class="p-2 mr-4 text-gray-600 rounded-lg lg:hidden hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="flex-1">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition">← View Site</a>
                </div>

                <!-- Profile Dropdown (Simplified) -->
                <div class="flex items-center" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 p-1 bg-gray-50 rounded-full hover:bg-gray-100 transition">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover">
                        <span class="hidden md:block text-sm font-medium mx-2">{{ Auth::user()->name }}</span>
                    </button>
                    <!-- Dropdown Content -->
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-4 top-16 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm" x-data="{ show: true }" x-show="show">
                        <div class="flex justify-between items-center">
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            <button @click="show = false" class="text-green-500 hover:text-green-700">&times;</button>
                        </div>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                        <ul class="list-disc pl-5 text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
