<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Emotion>
 */
class EmotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->unique()->sentence(),
            'avatar' => $this->faker->unique()->imageUrl(),
            'deleted_at' => $this->faker->boolean() ? now() : null,
        ];
    }
}
