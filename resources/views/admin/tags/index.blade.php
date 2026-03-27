@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Tags</h1>
    <a href="{{ route('admin.tags.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm hover:shadow-md hover:bg-indigo-700 transition flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Tag
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">ID</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">Name</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500">Slug</th>
                    <th class="py-4 px-6 text-xs uppercase tracking-wider font-semibold text-gray-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tags as $tag)
                <tr class="hover:bg-gray-50/50 transition duration-150">
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $tag->id }}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ $tag->name }}</td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $tag->slug }}</td>
                    <td class="py-4 px-6 text-sm text-right flex justify-end space-x-3 items-center">
                        <a href="{{ route('admin.tags.edit', $tag) }}" class="text-indigo-600 hover:text-indigo-900 font-medium transition">Edit</a>
                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tag?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                            <span class="text-base font-medium">No tags found</span>
                            <span class="text-sm mt-1">Get started by creating a new tag.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tags->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50/30">
        {{ $tags->links() }}
    </div>
    @endif
</div>
@endsection
