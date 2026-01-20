<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CounselingSessionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => User::where('role', 'user')->inRandomOrder()->first()->id ?? User::factory(),
            'counselor_id' => User::where('role', 'counselor')->inRandomOrder()->first()->id ?? User::factory()->counselor(),
            'subject' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'active', 'completed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'is_anonymous' => $this->faker->boolean(50),
            'scheduled_at' => $this->faker->optional()->dateTimeBetween('now', '+1 week'),
        ];
    }
}
