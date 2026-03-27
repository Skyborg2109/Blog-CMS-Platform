<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\BlogController;

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/post/{slug}', [BlogController::class, 'show'])->name('post.show');
Route::get('/tags', [BlogController::class, 'tags'])->name('tags.index');
Route::post('/post/{post}/comment', [BlogController::class, 'storeComment'])->name('post.comment.store');

Route::middleware(['auth', 'verified', 'role:admin,author'])->group(function () {
    Route::get('/write', [BlogController::class, 'create'])->name('post.create');
    Route::post('/write', [BlogController::class, 'store'])->name('post.store');
    Route::get('/my-posts', [BlogController::class, 'myPosts'])->name('post.my-posts');
    Route::get('/post/{post}/edit', [BlogController::class, 'edit'])->name('post.edit');
    Route::patch('/post/{post}', [BlogController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [BlogController::class, 'destroy'])->name('post.destroy');
});

Route::get('/dashboard', function () {
    if (\Illuminate\Support\Facades\Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', PostController::class);
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('tags', TagController::class)->except('show');
    Route::resource('comments', CommentController::class)->only(['index', 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
