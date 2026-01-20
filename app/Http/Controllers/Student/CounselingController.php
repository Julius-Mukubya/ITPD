<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingSession;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get all sessions where user is involved (either as primary student or participant)
        $sessions = CounselingSession::where(function($query) use ($user) {
            // Sessions where user is the primary student
            $query->where('student_id', $user->id)
                  // OR group sessions where user is a participant
                  ->orWhere(function($subQuery) use ($user) {
                      $subQuery->where('session_type', 'group')
                               ->whereHas('participants', function($participantQuery) use ($user) {
                                   $participantQuery->where('email', $user->email)
                                                   ->whereIn('status', ['invited', 'joined']);
                               });
                  });
        })
        ->with(['counselor', 'participants'])
        ->latest()
        ->get();

        // Debug: Check what we found
        \Log::info('User: ' . $user->email);
        \Log::info('Total sessions found: ' . $sessions->count());
        foreach ($sessions as $session) {
            \Log::info('Session ' . $session->id . ': type=' . $session->session_type . ', student_id=' . $session->student_id . ', participants=' . $session->participants->count());
            if ($session->session_type === 'group') {
                foreach ($session->participants as $participant) {
                    \Log::info('  Participant: ' . $participant->email . ' (status: ' . $participant->status . ')');
                }
            }
        }

        $pendingSessions = $sessions->where('status', 'pending')->count();
        $activeSessions = $sessions->where('status', 'active')->count();
        $completedSessions = $sessions->where('status', 'completed')->count();

        return view('student.counseling.index', compact(
            'sessions',
            'pendingSessions',
            'activeSessions',
            'completedSessions'
        ));
    }

    public function create()
    {
        $counselors = \App\Models\User::where('role', 'counselor')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('student.counseling.create', compact('counselors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_type' => 'required|in:individual,group',
            'counselor_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'preferred_method' => 'nullable|in:zoom,google_meet,whatsapp,physical,phone_call',
            'reason' => 'required|string|min:10',
            'preferred_datetime' => 'nullable|date',
            'anonymous' => 'nullable|boolean',
            'follow_up' => 'nullable|boolean',
            'resources' => 'nullable|boolean',
        ]);

        $session = CounselingSession::create([
            'student_id' => auth()->id(),
            'counselor_id' => $validated['counselor_id'] ?? null,
            'preferred_counselor_id' => $validated['counselor_id'] ?? null, // Track who was specifically requested
            'subject' => ucfirst($validated['session_type']) . ' Counseling Session',
            'description' => $validated['reason'],
            'priority' => $validated['priority'],
            'preferred_method' => $validated['preferred_method'] ?? null,
            'scheduled_at' => $validated['preferred_datetime'] ?? null,
            'is_anonymous' => $request->has('anonymous'),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('student.counseling.index')
            ->with('success', 'Your counseling request has been submitted successfully. A counselor will contact you soon.');
    }

    public function show(CounselingSession $counseling)
    {
        $user = auth()->user();
        
        // Check if user has access to this session
        $hasAccess = false;
        $userParticipant = null;
        
        // Primary student access
        if ($counseling->student_id === $user->id) {
            $hasAccess = true;
        }
        
        // Group session participant access
        if ($counseling->session_type === 'group') {
            $userParticipant = $counseling->participants()
                ->where('email', $user->email)
                ->first();
            
            if ($userParticipant && in_array($userParticipant->status, ['invited', 'joined'])) {
                $hasAccess = true;
            }
        }
        
        if (!$hasAccess) {
            abort(403, 'Unauthorized access to this counseling session.');
        }

        $counseling->load('messages.sender', 'counselor', 'participants');
        
        $session = $counseling;

        return view('student.counseling.show', compact('session', 'userParticipant'));
    }

    public function sendMessage(Request $request, CounselingSession $counseling)
    {
        $user = auth()->user();
        
        // Check if user has access to this session
        $hasAccess = false;
        
        // Primary student access
        if ($counseling->student_id === $user->id) {
            $hasAccess = true;
        }
        
        // Group session participant access
        if ($counseling->session_type === 'group') {
            $isParticipant = $counseling->participants()
                ->where('email', $user->email)
                ->whereIn('status', ['invited', 'joined'])
                ->exists();
            
            if ($isParticipant) {
                $hasAccess = true;
            }
        }
        
        if (!$hasAccess) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string|min:1',
        ]);

        $counseling->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    public function cancel(CounselingSession $counseling)
    {
        // Ensure the session belongs to the authenticated user
        if ($counseling->student_id !== auth()->id()) {
            abort(403);
        }

        // Only allow canceling pending sessions
        if ($counseling->status !== 'pending') {
            return back()->with('error', 'Only pending sessions can be cancelled.');
        }

        $counseling->update(['status' => 'cancelled']);

        return redirect()
            ->route('student.counseling.index')
            ->with('success', 'Your counseling session request has been cancelled.');
    }

    public function acceptInvitation(CounselingSession $counseling)
    {
        $user = auth()->user();
        
        // Find the participant record for this user
        $participant = $counseling->participants()
            ->where('email', $user->email)
            ->where('status', 'invited')
            ->first();
            
        if (!$participant) {
            return back()->with('error', 'Invitation not found or already responded to.');
        }
        
        // Mark as joined
        $participant->markAsJoined();
        
        return redirect()
            ->route('student.counseling.show', $counseling)
            ->with('success', 'You have successfully joined the group session!');
    }
    
    public function declineInvitation(CounselingSession $counseling)
    {
        $user = auth()->user();
        
        // Find the participant record for this user
        $participant = $counseling->participants()
            ->where('email', $user->email)
            ->where('status', 'invited')
            ->first();
            
        if (!$participant) {
            return back()->with('error', 'Invitation not found or already responded to.');
        }
        
        // Mark as declined
        $participant->markAsDeclined();
        
        return redirect()
            ->route('student.counseling.index')
            ->with('success', 'You have declined the group session invitation.');
    }
}
