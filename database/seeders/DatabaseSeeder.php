<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            EmergencyContactSeeder::class,
            AssessmentSeeder::class,
            QuizSeeder::class,
            ForumCategorySeeder::class,
            
            // Optional: Uncomment to generate sample data
            // SampleDataSeeder::class,
        ]);
    }
}