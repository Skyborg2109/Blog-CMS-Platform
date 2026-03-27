<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $stats = [
                'posts' => \App\Models\Post::count(),
                'categories' => \App\Models\Category::count(),
                'tags' => \App\Models\Tag::count(),
                'comments' => \App\Models\Comment::count(),
            ];
        } else {
            // Stats for Author
            $stats = [
                'posts' => \App\Models\Post::where('user_id', $user->id)->count(),
                // Others are zeroed or hidden from UI
                'categories' => 0,
                'tags' => 0,
                'comments' => 0,
            ];
        }

        return view('admin.dashboard', compact('stats'));
    }
}
