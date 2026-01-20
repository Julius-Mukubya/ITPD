<?php

namespace Database\Factories;

use App\Models\{Category, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationalContentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'created_by' => User::where('role', 'admin')->inRandomOrder()->first()->id ?? User::factory()->admin(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'content' => $this->faker->paragraphs(5, true),
            'type' => $this->faker->randomElement(['article', 'video', 'infographic', 'document']),
            'reading_time' => $this->faker->numberBetween(3, 15),
            'views' => $this->faker->numberBetween(0, 500),
            'is_published' => true,
            'is_featured' => false,
            'published_at' => now(),
        ];
    }

    public function published()
    {
        return $this->state(fn (array $attributes) => ['is_published' => true, 'published_at' => now()]);
    }

    public function draft()
    {
        return $this->state(fn (array $attributes) => ['is_published' => false, 'published_at' => null]);
    }

    public function featured()
    {
        return $this->state(fn (array $attributes) => ['is_featured' => true]);
    }
}
