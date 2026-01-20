<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    public function definition(): array
    {
        return [
            'created_by' => User::where('role', 'admin')->inRandomOrder()->first()->id ?? User::factory()->admin(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'content' => $this->faker->paragraphs(4, true),
            'type' => $this->faker->randomElement(['awareness', 'event', 'workshop', 'webinar']),
            'start_date' => now()->addDays($this->faker->numberBetween(1, 30)),
            'end_date' => now()->addDays($this->faker->numberBetween(31, 60)),
            'max_participants' => $this->faker->randomElement([50, 100, 200, null]),
            'status' => 'active',
            'is_featured' => $this->faker->boolean(30),
        ];
    }

    public function active()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(10),
        ]);
    }

    public function upcoming()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(15),
        ]);
    }
}
