@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.tags.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 font-medium flex items-center transition mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Tags
    </a>
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Create Tag</h1>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
    <form action="{{ route('admin.tags.store') }}" method="POST" class="p-6 md:p-8">
        @csrf
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tag Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all text-sm outline-none" 
                placeholder="e.g. Laravel, React, Design">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl hover:bg-indigo-700 hover:shadow-md transition-all font-medium text-sm text-center">
                Save Tag
            </button>
        </div>
    </form>
</div>
@endsection
