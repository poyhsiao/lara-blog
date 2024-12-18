<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::factory()
            ->create([
                'content' => 'comment content',
                'replyable' => 1,
                'user_id' => 1,
                'post_id' => 1,
                'parent_id' => null,
                'likes' => 10,
                'dislikes' => 20,
                'deleted_at' => null,
            ]);

        Comment::factory()
            ->create([
                'content'=> Fake()->unique()->sentence(10),
                'replyable' => 0,
                'user_id'=> 1,
                'post_id'=> 1,
                'parent_id'=> 1,
                'likes'=> 11,
                'dislikes'=> 21,
                'deleted_at' => null,
            ]);

        Comment::factory()
            ->count(100)
            ->create();
    }
}
