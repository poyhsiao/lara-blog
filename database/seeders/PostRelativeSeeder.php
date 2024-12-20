<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostRelativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->count(50)
            ->create()
            ->each(function (Post $post) {
                $post->tags()->sync(Tag::available()->pluck('id')->random(3)->toArray());
                $post->categories()->sync(Category::available()->pluck('id')->random(3)->toArray());
                Comment::whereIn('id', Comment::available()->pluck('id')->random(3)->toArray())
                ->update(['post_id' => $post->id]);
            });
    }
}
