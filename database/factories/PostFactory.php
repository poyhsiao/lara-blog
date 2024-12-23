<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
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
            'content' => $this->faker->paragraph(),
            'publish_status' => $this->faker->randomElement([0, 1, 2]),
            'user_id' => $this->generateAuthor(),
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

    private function generateAuthor(): int
    {
        return User::canLogin()->get('id')->random()->id;
    }
}
