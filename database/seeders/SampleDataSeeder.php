<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{ForumPost, Campaign, Feedback, CounselingSession};

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Generate sample forum posts with comments
        ForumPost::factory()->count(30)->withComments(5)->create();
        
        // Generate sample campaigns
        Campaign::factory()->count(5)->active()->create();
        Campaign::factory()->count(3)->upcoming()->create();
        

        
        // Generate sample feedback
        Feedback::factory()->count(20)->create();
        
        // Generate sample counseling sessions
        CounselingSession::factory()->count(25)->create();
    }
}