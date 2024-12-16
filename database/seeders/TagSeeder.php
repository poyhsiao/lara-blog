<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Testing\Fakes\Fake;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()
            ->create([
                'name' => Fake()->unique()->sentence(3),
                'description' => Fake()->unique()->sentence(3),
                'deleted_at' =>Fake()->boolean() ? now() : null,
            ]);

        Tag::factory()
            ->count(50)
            ->create();
    }
}
