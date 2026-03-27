@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
        @if(auth()->user()->role === 'admin')
            System Dashboard
        @else
            Author Dashboard
        @endif
    </h1>
    <p class="mt-2 text-sm text-gray-500">Welcome back, {{ Auth::user()->name }}! 
        @if(auth()->user()->role === 'admin')
            Here's what's happening with the system today.
        @else
            Here's what's happening with your articles today.
        @endif
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Posts Stat -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full group-hover:bg-indigo-100 transition-colors"></div>
        <div class="relative z-10 flex items-center justify-between">
            <h3 class="text-gray-500 font-medium text-sm tracking-wide uppercase">
                @if(auth()->user()->role === 'admin')
                    Total Posts
                @else
                    Your Posts
                @endif
            </h3>
            <span class="p-2 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </span>
        </div>
        <div class="relative z-10 mt-4">
            <span class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ $stats['posts'] }}</span>
        </div>
        <div class="relative z-10 mt-4 text-sm text-indigo-600 font-medium hover:text-indigo-800 transition">
            <a href="{{ route('admin.posts.index') }}" class="flex items-center">
                @if(auth()->user()->role === 'admin')
                    Manage All Posts
                @else
                    Manage Your Posts
                @endif
                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
    <!-- Categories Stat -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full group-hover:bg-purple-100 transition-colors"></div>
        <div class="relative z-10 flex items-center justify-between">
            <h3 class="text-gray-500 font-medium text-sm tracking-wide uppercase">Categories</h3>
            <span class="p-2 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            </span>
        </div>
        <div class="relative z-10 mt-4">
            <span class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ $stats['categories'] }}</span>
        </div>
        <div class="relative z-10 mt-4 text-sm text-purple-600 font-medium hover:text-purple-800 transition">
            <a href="{{ route('admin.categories.index') }}" class="flex items-center">Manage Categories <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
        </div>
    </div>
    @endif

    @if(auth()->user()->role === 'admin')
    <!-- Tags Stat -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-pink-50 rounded-full group-hover:bg-pink-100 transition-colors"></div>
        <div class="relative z-10 flex items-center justify-between">
            <h3 class="text-gray-500 font-medium text-sm tracking-wide uppercase">Tags</h3>
            <span class="p-2 bg-pink-50 text-pink-600 rounded-lg group-hover:bg-pink-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
            </span>
        </div>
        <div class="relative z-10 mt-4">
            <span class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ $stats['tags'] }}</span>
        </div>
        <div class="relative z-10 mt-4 text-sm text-pink-600 font-medium hover:text-pink-800 transition">
            <a href="{{ route('admin.tags.index') }}" class="flex items-center">Manage Tags <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
        </div>
    </div>
    @endif

    @if(auth()->user()->role === 'admin')
    <!-- Comments Stat -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:bg-blue-100 transition-colors"></div>
        <div class="relative z-10 flex items-center justify-between">
            <h3 class="text-gray-500 font-medium text-sm tracking-wide uppercase">Comments</h3>
            <span class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            </span>
        </div>
        <div class="relative z-10 mt-4">
            <span class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ $stats['comments'] }}</span>
        </div>
        <div class="relative z-10 mt-4 text-sm text-blue-600 font-medium hover:text-blue-800 transition">
            <a href="{{ route('admin.comments.index') }}" class="flex items-center">View Comments <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
        </div>
    </div>
    @endif

</div>

<!-- Recent Quick Actions -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-bold text-gray-900 mb-4 tracking-tight">Quick Actions</h2>
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('admin.posts.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 shadow-sm hover:shadow-md transition-all flex items-center text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create New Post
        </a>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.categories.create') }}" class="px-5 py-2.5 bg-white text-gray-700 font-medium rounded-xl border border-gray-200 hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-all flex items-center text-sm">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Category
        </a>
        @endif
    </div>
</div>
@endsection
