<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()
            ->create([
                'name' => Fake()->unique()->sentence(3),
                'slug'=> Str::slug(Fake()->unique()->slug),
                'description' => Fake()->unique()->sentence(3),
                'parent' => null,
                'deleted_at' =>Fake()->boolean() ? now() : null,
            ]);

        Category::factory()
            ->count(50)
            ->create();
    }
}
