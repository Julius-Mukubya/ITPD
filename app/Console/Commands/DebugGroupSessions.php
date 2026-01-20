<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CounselingSession;
use App\Models\SessionParticipant;
use App\Models\User;

class DebugGroupSessions extends Command
{
    protected $signature = 'debug:group-sessions {email?}';
    protected $description = 'Debug group sessions and participants';

    public function handle()
    {
        $this->info('=== Group Sessions Debug ===');
        
        // Basic counts
        $this->info('Total counseling sessions: ' . CounselingSession::count());
        $this->info('Group sessions: ' . CounselingSession::where('session_type', 'group')->count());
        $this->info('Session participants: ' . SessionParticipant::count());
        $this->info('');
        
        // Group sessions details
        $groupSessions = CounselingSession::where('session_type', 'group')
            ->with(['participants', 'student'])
            ->get();
            
        foreach ($groupSessions as $session) {
            $this->info("Session ID: {$session->id}");
            $this->info("Status: {$session->status}");
            $this->info("Student: {$session->student->name} ({$session->student->email})");
            $this->info("Participants:");
            
            foreach ($session->participants as $participant) {
                $this->info("  - {$participant->email} ({$participant->status})");
            }
            $this->info('');
        }
        
        // Test specific user if email provided
        if ($email = $this->argument('email')) {
            $this->info("=== Testing for user: {$email} ===");
            
            $user = User::where('email', $email)->first();
            if (!$user) {
                $this->error("User not found!");
                return;
            }
            
            $this->info("User ID: {$user->id}");
            $this->info("User Name: {$user->name}");
            
            // Test the query from the controller
            $sessions = CounselingSession::where(function($query) use ($user) {
                $query->where('student_id', $user->id)
                      ->orWhere(function($subQuery) use ($user) {
                          $subQuery->where('session_type', 'group')
                                   ->whereHas('participants', function($participantQuery) use ($user) {
                                       $participantQuery->where('email', $user->email)
                                                       ->whereIn('status', ['invited', 'joined']);
                                   });
                      });
            })->with(['counselor', 'participants'])->get();
            
            $this->info("Sessions found for this user: " . $sessions->count());
            
            foreach ($sessions as $session) {
                $this->info("  - Session {$session->id}: {$session->session_type} ({$session->status})");
                if ($session->session_type === 'group') {
                    $participant = $session->participants->where('email', $user->email)->first();
                    if ($participant) {
                        $this->info("    Participant status: {$participant->status}");
                    }
                }
            }
        }
        
        return 0;
    }
}
