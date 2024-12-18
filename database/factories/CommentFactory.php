<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph,
            'replyable' => $this->faker->randomElement([0, 1]),
            'user_id' => $this->generateUserId(),
            'post_id' => $this->generatePostId(),
            'parent_id' => $this->generateParentId(),
            'likes' => $this->faker->randomNumber(2),
            'dislikes' => $this->faker->randomNumber(2),
            'deleted_at' => fake()->boolean() ? now() : null,
        ];
    }

    /**
     * Generates a random user id.
     *
     * @return int The id of a user who can log in.
     */
    private function generateUserId(): int
    {
        return User::canLogin()->get('id')->random()->id;
    }

    /**
     * Generates a random post id.
     *
     * @return int The id of an available post.
     */
    private function generatePostId(): int
    {
        return Post::available()->get('id')->random()->id;
    }

    /**
     * Generates a random parent comment id.
     *
     * If there are existing comments, generates a random parent comment id.
     * The parent comment is chosen from the available comments that are replyable.
     * If the boolean faker returns false, null is returned.
     * If there are no existing comments, null is returned.
     *
     * @return int|null The id of a parent comment or null if none is generated.
     */
    private function generateParentId(): ?int
    {
        $availableComments = Comment::available();

        try {
            if ($availableComments->count() > 0) {
                return $this->faker->boolean()
                    ? $availableComments->replyable()->get('id')->random()->id
                    : null;
            }
        } catch (\Exception $e) {
            return null;
        }
        return null;
    }
}
