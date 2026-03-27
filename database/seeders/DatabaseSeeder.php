<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $author = User::factory()->create([
            'name' => 'Penulis Artikel',
            'email' => 'author@example.com',
            'role' => 'author',
        ]);

        $kategoriList = ['Teknologi', 'Gaya Hidup', 'Bisnis', 'Kesehatan', 'Pendidikan'];
        $categories = collect();
        foreach ($kategoriList as $kategori) {
            $categories->push(Category::create([
                'name' => $kategori,
                'slug' => Str::slug($kategori),
            ]));
        }

        $tagList = ['Tutorial', 'Tips & Trik', 'Berita Terkini', 'Startup', 'Pemrograman', 'Inspirasi'];
        $tags = collect();
        foreach ($tagList as $tag) {
            $tags->push(Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]));
        }

        Post::factory(20)->create([
            'user_id' => $author->id,
            'category_id' => fn () => $categories->random()->id,
        ])->each(function ($post) use ($tags) {
            $post->tags()->attach($tags->random(rand(2, 4))->pluck('id')->toArray());
            Comment::factory(rand(1, 4))->create(['post_id' => $post->id]);
        });
    }
}
