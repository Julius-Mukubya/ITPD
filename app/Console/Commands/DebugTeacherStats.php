<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Campaign, CampaignParticipant, ContentView, AssessmentAttempt, User};

class DebugTeacherStats extends Command
{
    protected $signature = 'debug:teacher-stats {email}';
    protected $description = 'Debug teacher dashboard stats';

    public function handle()
    {
        $email = $this->argument('email');
        $teacher = User::where('email', $email)->first();
        
        if (!$teacher) {
            $this->error("Teacher not found with email: {$email}");
            return;
        }
        
        $this->info("=== Teacher: {$teacher->name} (ID: {$teacher->id}) ===");
        $this->info("Role: {$teacher->role}");
        $this->newLine();
        
        // Get campaigns
        $campaigns = Campaign::where('created_by', $teacher->id)->get();
        $this->info("Total Campaigns: " . $campaigns->count());
        
        foreach ($campaigns as $campaign) {
            $this->info("  - {$campaign->title} (ID: {$campaign->id})");
        }
        $this->newLine();
        
        // Get campaign IDs
        $campaignIds = $campaigns->pluck('id');
        
        // Get participants
        $allParticipants = CampaignParticipant::whereIn('campaign_id', $campaignIds)->get();
        $this->info("Total Participants: " . $allParticipants->count());
        
        $participantsWithUserId = $allParticipants->whereNotNull('user_id');
        $this->info("Participants with user_id: " . $participantsWithUserId->count());
        
        foreach ($participantsWithUserId as $participant) {
            $user = User::find($participant->user_id);
            $this->info("  - User ID: {$participant->user_id}, Name: " . ($user ? $user->name : 'N/A'));
        }
        $this->newLine();
        
        // Get user IDs
        $userIds = $participantsWithUserId->pluck('user_id');
        $this->info("User IDs for queries: " . $userIds->implode(', '));
        $this->newLine();
        
        // Check content views
        $totalContentViews = ContentView::count();
        $this->info("Total Content Views in DB: {$totalContentViews}");
        
        if ($userIds->isNotEmpty()) {
            $teacherContentViews = ContentView::whereIn('user_id', $userIds)->count();
            $this->info("Content Views for teacher's students: {$teacherContentViews}");
            
            // Show some sample content views
            $sampleViews = ContentView::whereIn('user_id', $userIds)->take(5)->get();
            foreach ($sampleViews as $view) {
                $this->info("  - User {$view->user_id} viewed content {$view->content_id} at {$view->viewed_at}");
            }
        } else {
            $this->warn("No user IDs to query content views");
        }
        $this->newLine();
        
        // Check assessment attempts
        $totalAttempts = AssessmentAttempt::count();
        $this->info("Total Assessment Attempts in DB: {$totalAttempts}");
        
        if ($userIds->isNotEmpty()) {
            $teacherAttempts = AssessmentAttempt::whereIn('user_id', $userIds)->count();
            $this->info("Assessment Attempts for teacher's students: {$teacherAttempts}");
        } else {
            $this->warn("No user IDs to query assessment attempts");
        }
        
        return 0;
    }
}
