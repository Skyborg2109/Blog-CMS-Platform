@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Comments Management</h1>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">Author</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">Comment</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">On Post</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">Date</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($comments as $comment)
                <tr class="hover:bg-gray-50/50 transition duration-150">
                    <td class="py-4 px-6">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900">{{ $comment->user ? $comment->user->name : $comment->name }}</span>
                            <span class="text-xs text-gray-500">{{ $comment->user ? $comment->user->email : $comment->email }}</span>
                            @if($comment->user)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 mt-1 w-max">Registered User</span>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-600 max-w-xs">
                        <p class="line-clamp-2">{{ $comment->body }}</p>
                    </td>
                    <td class="py-4 px-6 text-sm">
                        <a href="{{ route('post.show', $comment->post->slug) }}#comment-{{ $comment->id }}" target="_blank" class="text-indigo-600 hover:underline line-clamp-1 max-w-[200px]" title="{{ $comment->post->title }}">
                            {{ $comment->post->title }}
                        </a>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                        {{ $comment->created_at->diffForHumans() }}
                    </td>
                    <td class="py-4 px-6 text-sm text-right">
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition flex items-center justify-end w-full">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            <span class="text-base font-medium">No comments yet</span>
                            <span class="text-sm mt-1">When visitors leave comments, they will appear here.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($comments->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50/30">
        {{ $comments->links() }}
    </div>
    @endif
</div>
@endsection
