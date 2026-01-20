<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Alcohol Awareness', 
                'description' => 'Information about alcohol abuse, effects, and prevention', 
                'icon' => '🍺', 
                'color' => '#EF4444', 
                'order' => 1,
                'image' => 'https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=800&h=600&fit=crop&q=80'
            ],
            [
                'name' => 'Drug Prevention', 
                'description' => 'Educational content on drug abuse and prevention strategies', 
                'icon' => '💊', 
                'color' => '#F59E0B', 
                'order' => 2,
                'image' => 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=800&h=600&fit=crop&q=80'
            ],
            [
                'name' => 'Mental Health', 
                'description' => 'Mental health awareness and support resources', 
                'icon' => '🧠', 
                'color' => '#8B5CF6', 
                'order' => 3,
                'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&h=600&fit=crop&q=80'
            ],
            [
                'name' => 'Healthy Living', 
                'description' => 'Tips for maintaining a healthy lifestyle', 
                'icon' => '🌱', 
                'color' => '#10B981', 
                'order' => 4,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&q=80'
            ],
            [
                'name' => 'Peer Pressure', 
                'description' => 'Dealing with peer pressure and making good decisions', 
                'icon' => '👥', 
                'color' => '#3B82F6', 
                'order' => 5,
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop&q=80'
            ],
            [
                'name' => 'Recovery & Support', 
                'description' => 'Resources for recovery and ongoing support', 
                'icon' => '💚', 
                'color' => '#22C55E', 
                'order' => 6,
                'image' => 'https://images.unsplash.com/photo-1502086223501-7ea6ecd79368?w=800&h=600&fit=crop&q=80'
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($category['name'])],
                $category
            );
        }
    }
}