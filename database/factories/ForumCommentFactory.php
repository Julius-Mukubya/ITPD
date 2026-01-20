<?php

namespace Database\Factories;

use App\Models\{ForumPost, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumCommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'post_id' => ForumPost::inRandomOrder()->first()->id ?? ForumPost::factory(),
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id ?? User::factory(),
            'comment' => $this->faker->paragraph(),
            'is_anonymous' => $this->faker->boolean(20),
            'upvotes' => $this->faker->numberBetween(0, 20),
        ];
    }
}
