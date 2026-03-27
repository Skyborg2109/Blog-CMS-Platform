<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])
                    ->where('status', 'published')
                    ->latest('published_at');

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        $posts = $query->paginate(9);
        $categories = Category::all();
        $tags = Tag::all();

        return view('blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show($slug)
    {
        $query = Post::with(['user', 'category', 'tags', 'comments.user'])
                    ->where('slug', $slug);

        $post = $query->firstOrFail();

        // If it's a draft, only the author or an admin can see it
        if ($post->status === 'draft') {
            if (!Auth::check() || (Auth::user()->role !== 'admin' && $post->user_id !== Auth::id())) {
                abort(404);
            }
        }
        
        $categories = Category::all();
        $tags = Tag::all();
                    
        return view('blog.show', compact('post', 'categories', 'tags'));
    }

    public function tags()
    {
        $tags = Tag::withCount(['posts' => function ($query) {
            $query->where('status', 'published');
        }])->orderBy('name')->get();
        
        $categories = Category::all();
        
        return view('blog.tags', compact('tags', 'categories'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $rules = [
            'body' => 'required',
        ];

        if (!Auth::check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        $validated = $request->validate($rules);
        $validated['post_id'] = $post->id;
        
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }

        Comment::create($validated);

        return back()->with('success', 'Comment posted successfully.');
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('blog.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['user_id'] = Auth::id();
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($validated);
        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('post.my-posts')->with('success', 'Post created successfully.');
    }

    public function myPosts()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->paginate(10);
        return view('blog.my-posts', compact('posts'));
    }

    public function edit(Post $post)
    {
        if (Auth::user()->role !== 'admin' && $post->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('blog.create', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        if (Auth::user()->role !== 'admin' && $post->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        if ($validated['title'] !== $post->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        }

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && $post->status === 'draft') {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $post->update($validated);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync([]);
        }

        return redirect()->route('post.my-posts')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if (Auth::user()->role !== 'admin' && $post->user_id !== Auth::id()) {
            abort(403);
        }
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('post.my-posts')->with('success', 'Post deleted successfully.');
    }
}
