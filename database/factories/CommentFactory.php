<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $komentarIndo = [
            'Artikel yang sangat menarik dan menginspirasi!',
            'Terima kasih atas informasinya, sangat bermanfaat sekali.',
            'Kualitas tulisannya luar biasa, ditunggu artikel selanjutnya.',
            'Saya setuju dengan pendapat di artikel ini.',
            'Wah, baru tahu soal ini. Terima kasih sudah berbagi.',
            'Penjelasannya sangat mudah dipahami, mantap!',
            'Izin bagikan artikel ini ya, sangat bagus soalnya.',
            'Konten yang berkualitas, maju terus blog ini!',
            'Sangat membantu dalam memahami topik yang sedang tren ini.',
            'Keren sekali penyajian datanya, sangat profesional.'
        ];

        return [
            'post_id' => \App\Models\Post::factory(),
            'user_id' => null,
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'body' => $this->faker->randomElement($komentarIndo),
        ];
    }
}
