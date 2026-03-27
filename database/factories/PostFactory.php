<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judulIndo = [
            'Strategi Bisnis Startup yang Berkelanjutan',
            'Masa Depan Teknologi AI di Indonesia',
            'Panduan Gaya Hidup Minimalis untuk Milenial',
            'Pentingnya Kesehatan Mental di Tempat Kerja',
            'Tren Pendidikan Digital Modern',
            'Cara Membangun Kebiasaan Membaca',
            'Eksplorasi Keindahan Alam Nusantara',
            'Tips Mengelola Keuangan Pribadi',
            'Inovasi Kuliner Lokal Berstandar Global',
            'Memahami Dasar Keamanan Siber Personal',
            'Seni Fotografi Menggunakan Smartphone',
            'Membangun Portofolio Digital yang Menarik',
            'Olahraga Rutin untuk Pekerja Kantoran',
            'Evolusi Media Sosial di Masa Depan',
            'Pemanfaatan Energi Terbarukan di Rumah'
        ];

        $kontenIndo = [
            'Dalam era digital yang berkembang pesat saat ini, banyak hal telah berubah secara signifikan. Masyarakat kini lebih cenderung mencari informasi melalui platform daring yang menyediakan konten berkualitas dan mendalam.',
            'Penting untuk dipahami bahwa keberlanjutan sebuah bisnis tidak hanya bergantung pada modal, tetapi juga pada inovasi dan adaptasi terhadap kebutuhan pasar yang terus berubah setiap waktu.',
            'Pendidikan jasmani dan rohani menjadi kunci utama dalam menjaga produktivitas di tengah kesibukan pekerjaan yang terkadang terasa sangat melelahkan bagi banyak individu.',
            'Kreativitas adalah aset yang tak ternilai. Dengan terus mengasah kemampuan dan membuka diri terhadap perspektif baru, kita dapat menciptakan solusi unik untuk masalah yang kompleks.',
            'Kerja keras yang dibarengi dengan strategi yang tepat akan membuahkan hasil yang maksimal. Jangan pernah takut untuk mencoba hal-hal baru yang dapat meningkatkan kualitas hidup kita.'
        ];

        $title = fake()->randomElement($judulIndo);
        return [
            'user_id' => \App\Models\User::factory(),
            'category_id' => \App\Models\Category::factory(),
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title . '-' . fake()->unique()->numerify('####')),
            'image' => null,
            'body' => '<p>' . implode('</p><p>', fake()->randomElements($kontenIndo, rand(3, 5))) . '</p>',
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
