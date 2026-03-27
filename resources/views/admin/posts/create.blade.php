@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-editor { min-height: 300px; }
    trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    document.addEventListener("trix-file-accept", function(event) {
        event.preventDefault();
    });
</script>
@endpush

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.posts.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 font-medium flex items-center transition mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Posts
    </a>
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Create Post</h1>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl mx-auto">
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required 
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all text-sm outline-none" 
                        placeholder="Post title here...">
                    @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Trix Editor for Body -->
                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <input id="body" type="hidden" name="body" value="{{ old('body') }}">
                    <trix-editor input="body" class="bg-white w-full px-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 prose max-w-none text-sm"></trix-editor>
                    @error('body')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-6">
                <!-- Status -->
                <div class="bg-gray-50/50 p-5 rounded-xl border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4 tracking-tight">Publish Status</h3>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all text-sm outline-none bg-white">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <!-- Image Upload -->
                <div class="bg-gray-50/50 p-5 rounded-xl border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4 tracking-tight">Cover Image</h3>
                    <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all bg-white border border-gray-200 rounded-xl">
                    @error('image')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Category -->
                <div class="bg-gray-50/50 p-5 rounded-xl border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4 tracking-tight">Category</h3>
                    <select name="category_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-50 focus:border-indigo-400 transition-all text-sm outline-none bg-white">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Tags -->
                <div class="bg-gray-50/50 p-5 rounded-xl border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4 tracking-tight">Tags</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto w-full pr-2">
                        @foreach($tags as $tag)
                        <label class="flex items-center space-x-3 p-2 hover:bg-white rounded-lg transition-colors cursor-pointer border border-transparent hover:border-gray-100">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2">
                            <span class="text-sm font-medium text-gray-700">{{ $tag->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl hover:bg-indigo-700 hover:shadow-lg transition-all font-medium text-sm text-center">
                Save Post
            </button>
        </div>
    </form>
</div>
@endsection
