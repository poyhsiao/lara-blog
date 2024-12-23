<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->generateName(),
            'slug'=> $this->generateSlug(),
            'description'=> $this->faker->sentence(),
            'parent' => $this->faker->boolean() ? 1 : 0,
            'deleted_at' => $this->faker->boolean() ? now() : null,
        ];
    }

    /**
     * Generates a unique name for a category by looping until a unique name
     * is found.
     *
     * @return string
     */
    private function generateName(): string
    {
        do {
            $name = fake()->unique()->sentence();
        } while (Category::where('name', $name)->exists());

        return $name;
    }

    /**
     * Generates a unique slug for a category by looping until a unique slug
     * is found.
     *
     * @return string
     */
    private function generateSlug(): string
    {
        do {
            $slug = fake()->unique()->slug();
        } while (Category::where('slug', $slug)->exists());

        return $slug;
    }
}
