<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id ?? User::factory(),
            'type' => $this->faker->randomElement(['suggestion', 'complaint', 'compliment', 'bug_report']),
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'rating' => $this->faker->optional()->numberBetween(1, 5),
            'is_anonymous' => $this->faker->boolean(30),
            'status' => $this->faker->randomElement(['pending', 'reviewed', 'resolved']),
        ];
    }
}
