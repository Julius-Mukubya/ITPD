<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumCategory;

class ForumCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'General Discussion',
                'slug' => 'general-discussion',
                'description' => 'General topics and casual conversations',
                'icon' => 'forum',
                'color' => 'blue',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Mental Health',
                'slug' => 'mental-health',
                'description' => 'Share experiences and support related to mental health',
                'icon' => 'psychology',
                'color' => 'purple',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Stress & Anxiety',
                'slug' => 'stress-anxiety',
                'description' => 'Discuss stress management and anxiety coping strategies',
                'icon' => 'sentiment_worried',
                'color' => 'orange',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Academic Support',
                'slug' => 'academic-support',
                'description' => 'Academic challenges, study tips, and peer support',
                'icon' => 'school',
                'color' => 'green',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Substance Use',
                'slug' => 'substance-use',
                'description' => 'Support and resources for substance-related concerns',
                'icon' => 'local_pharmacy',
                'color' => 'red',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Relationships',
                'slug' => 'relationships',
                'description' => 'Discuss relationships, friendships, and social connections',
                'icon' => 'favorite',
                'color' => 'pink',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Self-Care',
                'slug' => 'self-care',
                'description' => 'Share self-care tips and wellness practices',
                'icon' => 'self_improvement',
                'color' => 'teal',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Success Stories',
                'slug' => 'success-stories',
                'description' => 'Share your journey and inspire others',
                'icon' => 'celebration',
                'color' => 'yellow',
                'is_active' => true,
                'order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            ForumCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
