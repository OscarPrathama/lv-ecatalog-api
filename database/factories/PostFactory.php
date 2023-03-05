<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        $paragraphs = '';
        for ($i=0; $i <= 10 ; $i++) {
            $paragraphs .= '<p>'.$this->faker->paragraph(12).'</p>';
        }

        $post_author = [1, 2, 3];
        $status = ['publish', 'draft'];

        return [
            // 'post_author' => User::all()->random()->id,
            'post_author' => $post_author[rand(0, 2)],
            'post_title' => $title,
            'post_slug' => Str::slug($title),
            'post_type' => $this->faker->randomElement(['post']),
            'excerpt' => Str::substr($paragraphs, 0, 99),
            'post_content' => $paragraphs,
            'post_status' => $status[rand(0, 1)],
            'comment_count' => 0,
            'created_at' => $this->faker->dateTimeBetween('-7 year', '-10 days'),
        ];
    }
}
