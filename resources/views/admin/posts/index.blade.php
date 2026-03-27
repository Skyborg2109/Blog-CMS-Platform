@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Posts</h1>
    <a href="{{ route('admin.posts.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm hover:shadow-md hover:bg-indigo-700 transition flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Create Post
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">Title</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">Category & Author</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">Status</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">Date</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($posts as $post)
                <tr class="hover:bg-gray-50/50 transition duration-150">
                    <td class="py-4 px-6">
                        <div class="flex items-center space-x-3">
                            @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200" alt="Cover">
                            @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $post->title }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-sm">
                        <span class="block text-gray-900 font-medium">{{ $post->category->name ?? 'Uncategorized' }}</span>
                        <span class="block text-gray-500 text-xs">{{ $post->user->name }}</span>
                    </td>
                    <td class="py-4 px-6">
                        @if($post->status === 'published')
                        <span class="px-2.5 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full border border-green-200">Published</span>
                        @else
                        <span class="px-2.5 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full border border-yellow-200">Draft</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                        {{ $post->created_at->format('M d, Y') }}
                    </td>
                    <td class="py-4 px-6 text-sm text-right flex justify-end space-x-3 items-center">
                        <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="text-gray-500 hover:text-indigo-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-900 font-medium transition">Edit</a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            <span class="text-base font-medium">No posts found</span>
                            <span class="text-sm mt-1">Start writing your first content!</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50/30">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection
