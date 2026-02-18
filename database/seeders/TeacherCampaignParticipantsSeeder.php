<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Campaign, CampaignParticipant};

class TeacherCampaignParticipantsSeeder extends Seeder
{
    public function run()
    {
        // Find teacher
        $teacher = User::where('email', 'teacher@email.com')->first();
        
        if (!$teacher) {
            $this->command->error('Teacher not found. Please create teacher@email.com first.');
            return;
        }
        
        // Get or create a campaign for the teacher
        $campaign = Campaign::where('created_by', $teacher->id)->first();
        
        if (!$campaign) {
            $campaign = Campaign::create([
                'title' => 'Mental Health Awareness Campaign',
                'description' => 'A comprehensive campaign to promote mental health awareness among students',
                'created_by' => $teacher->id,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'target_audience' => 'All Students',
                'is_active' => true,
            ]);
            $this->command->info("Created campaign: {$campaign->title}");
        }
        
        // Get all regular users (students)
        $students = User::where('role', 'user')->get();
        
        if ($students->isEmpty()) {
            $this->command->warn('No students found in the database.');
            return;
        }
        
        $this->command->info("Found {$students->count()} students");
        
        // Add students as participants
        $added = 0;
        foreach ($students as $student) {
            $exists = CampaignParticipant::where('campaign_id', $campaign->id)
                ->where('user_id', $student->id)
                ->exists();
            
            if (!$exists) {
                CampaignParticipant::create([
                    'campaign_id' => $campaign->id,
                    'user_id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                ]);
                $added++;
            }
        }
        
        $this->command->info("Added {$added} students to campaign: {$campaign->title}");
        $this->command->info("Total participants: " . CampaignParticipant::where('campaign_id', $campaign->id)->count());
    }
}
