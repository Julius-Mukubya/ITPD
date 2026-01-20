<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{CounselingSession, User};

class CreateTestSession extends Command
{
    protected $signature = 'create:test-session {--counselor-id=2} {--student-id=1}';
    protected $description = 'Create a test counseling session for video call testing';

    public function handle()
    {
        $counselorId = $this->option('counselor-id');
        $studentId = $this->option('student-id');
        
        // Check if users exist
        $counselor = User::find($counselorId);
        $student = User::find($studentId);
        
        if (!$counselor) {
            $this->error("Counselor with ID {$counselorId} not found");
            return 1;
        }
        
        if (!$student) {
            $this->error("Student with ID {$studentId} not found");
            return 1;
        }
        
        // Create test session
        $session = CounselingSession::create([
            'student_id' => $studentId,
            'counselor_id' => $counselorId,
            'subject' => 'Test Video Call Session',
            'description' => 'This is a test session for video call functionality.',
            'status' => 'active',
            'priority' => 'medium',
            'session_type' => 'individual',
            'preferred_method' => 'jitsi',
            'started_at' => now(),
        ]);
        
        $this->info("Test session created successfully!");
        $this->info("Session ID: {$session->id}");
        $this->info("Counselor: {$counselor->name} (ID: {$counselor->id})");
        $this->info("Student: {$student->name} (ID: {$student->id})");
        $this->info("Status: {$session->status}");
        $this->info("");
        $this->info("You can now test the video call by:");
        $this->info("1. Logging in as the counselor (ID: {$counselor->id})");
        $this->info("2. Going to /counselor/sessions/{$session->id}");
        $this->info("3. The video call should appear automatically");
        
        return 0;
    }
}