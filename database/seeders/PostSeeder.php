<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->create([
                'title' => 'hello world',
                'publish_status' => 2,
                'user_id' => 1,
                'deleted_at' => null,
            ]);

        Post::factory()
        ->count(50)
        ->create();
    }
}
