<?php

namespace Database\Factories;

use App\Models\{ForumCategory, User, ForumComment};
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => ForumCategory::inRandomOrder()->first()->id ?? ForumCategory::factory(),
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'is_anonymous' => $this->faker->boolean(20),
            'is_pinned' => false,
            'is_locked' => false,
            'views' => $this->faker->numberBetween(0, 200),
            'upvotes' => $this->faker->numberBetween(0, 50),
        ];
    }

    public function withComments(int $count = 3)
    {
        return $this->afterCreating(function ($post) use ($count) {
            ForumComment::factory()->count($count)->create(['post_id' => $post->id]);
        });
    }
}
