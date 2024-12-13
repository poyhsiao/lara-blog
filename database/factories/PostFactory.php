<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'title' => $this->generateTitle(),
            'slug'=> $this->generateSlug(),
            'content' => $this->faker->paragraph(),
            'publish_status' => $this->faker->randomElement([0, 1, 2]),
            'author' => 1,
            'deleted_at' => fake()->boolean() ? now() : null,
        ];
    }

    private function generateTitle(): string
    {
        do {
            $title = fake()->unique()->sentence;
        } while (Post::where('title', $title)->exists());

        return $title;
    }

    private function generateSlug(): string
    {
        do {
            $slug = fake()->unique()->slug;
        } while (Post::where('slug', $slug)->exists());

        return $slug;
    }
}
