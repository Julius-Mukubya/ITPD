<?php

namespace Database\Factories;

use App\Models\{Category, User, QuizQuestion, QuizOption};
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'created_by' => User::where('role', 'admin')->inRandomOrder()->first()->id ?? User::factory()->admin(),
            'title' => $this->faker->sentence() . ' Quiz',
            'description' => $this->faker->paragraph(),
            'duration_minutes' => $this->faker->randomElement([10, 15, 20, 30]),
            'passing_score' => $this->faker->randomElement([60, 70, 80]),
            'difficulty' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'is_active' => true,
            'show_correct_answers' => true,
        ];
    }

    public function withQuestions(int $count = 5)
    {
        return $this->afterCreating(function ($quiz) use ($count) {
            for ($i = 1; $i <= $count; $i++) {
                $question = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $this->faker->sentence() . '?',
                    'type' => 'multiple_choice',
                    'explanation' => $this->faker->sentence(),
                    'points' => 1,
                    'order' => $i,
                ]);

                // Create 4 options per question
                for ($j = 0; $j < 4; $j++) {
                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $this->faker->sentence(3),
                        'is_correct' => $j === 0, // First option is correct
                        'order' => $j,
                    ]);
                }
            }
        });
    }
}
