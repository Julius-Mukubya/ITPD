<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->words(2, true);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'icon' => $this->faker->randomElement(['📚', '🎯', '💡', '🌟', '🔬', '🎨']),
            'color' => $this->faker->hexColor(),
            'order' => $this->faker->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
