<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password123'),
            'registration_number' => '23/U/' . $this->faker->unique()->numberBetween(10000, 99999) . '/EVE',
            'phone' => '+2567' . $this->faker->numberBetween(00000000, 99999999),
            'role' => 'user',
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function user()
    {
        return $this->state(fn (array $attributes) => ['role' => 'user']);
    }

    public function counselor()
    {
        return $this->state(fn (array $attributes) => ['role' => 'counselor']);
    }

    public function admin()
    {
        return $this->state(fn (array $attributes) => ['role' => 'admin']);
    }
}
