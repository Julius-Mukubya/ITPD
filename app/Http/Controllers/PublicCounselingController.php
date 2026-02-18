<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CounselingSession;
use Illuminate\Http\Request;

class PublicCounselingController extends Controller
{
    public function index()
    {
        $counselors = User::where('role', 'counselor')
            ->where('is_active', true)
            ->orderBy('name')
            ->take(3)
            ->get();
        
        return view('public.counseling.index', compact('counselors'));
    }
    
    public function counselors()
    {
        $counselors = User::where('role', 'counselor')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('public.counseling.counselors', compact('counselors'));
    }
    
    public function counselor($slug)
    {
        // For now, just return a view - you can implement individual counselor pages later
        return view('public.counseling.counselor', compact('slug'));
    }
    
    public function sessions()
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to view your counseling sessions.');
        }
        
        // Get user's counseling sessions (including group sessions where they're participants)
        $user = auth()->user();
        $sessions = $user->allCounselingSessions()->with('counselor')->latest()->get();
        
        // Calculate statistics
        $pendingSessions = $sessions->where('status', 'pending')->count();
        $activeSessions = $sessions->where('status', 'active')->count();
        $completedSessions = $sessions->where('status', 'completed')->count();
        
        // Get counselors for the request modal
        $counselors = User::where('role', 'counselor')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('public.counseling.sessions', compact(
            'sessions',
            'pendingSessions',
            'activeSessions',
            'completedSessions',
            'counselors'
        ));
    }
    
    public function requestForm()
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to request a counseling session.');
        }
        
        $counselors = User::where('role', 'counselor')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('public.counseling.request', compact('counselors'));
    }
    
    public function storeRequest(Request $request)
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to request a counseling session.');
        }
        
        $validated = $request->validate([
            'session_type' => 'required|in:individual,group',
            'counselor_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'preferred_method' => 'nullable|in:jitsi,zoom,google_meet,whatsapp,physical,phone_call',
            'reason' => 'required|string|min:10',
            'preferred_datetime' => 'nullable|date',
            'anonymous' => 'nullable|boolean',
            'follow_up' => 'nullable|boolean',
            'resources' => 'nullable|boolean',
            'participants' => 'nullable|array',
            'participants.*.name' => 'required_with:participants|string|max:255',
            'participants.*.email' => 'required_with:participants|email|max:255',
        ]);

        // Additional validation for group sessions
        if ($validated['session_type'] === 'group') {
            if (empty($validated['participants']) || count($validated['participants']) === 0) {
                return back()->withErrors(['participants' => 'At least one participant is required for group sessions.'])->withInput();
            }
            
            if (count($validated['participants']) > 8) {
                return back()->withErrors(['participants' => 'Maximum 8 participants allowed for group sessions.'])->withInput();
            }
        }

        $session = CounselingSession::create([
            'student_id' => auth()->id(),
            'counselor_id' => $validated['counselor_id'] ?? null,
            'preferred_counselor_id' => $validated['counselor_id'] ?? null, // Track who was specifically requested
            'subject' => ucfirst($validated['session_type']) . ' Counseling Session',
            'description' => $validated['reason'],
            'priority' => $validated['priority'],
            'session_type' => $validated['session_type'],
            'preferred_method' => $validated['preferred_method'] ?? null,
            'scheduled_at' => $validated['preferred_datetime'] ?? null,
            'is_anonymous' => $request->has('anonymous'),
            'wants_followup' => $request->has('follow_up'),
            'status' => 'pending',
        ]);

        // Add group participants if this is a group session
        if ($validated['session_type'] === 'group' && !empty($validated['participants'])) {
            foreach ($validated['participants'] as $participantData) {
                $session->participants()->create([
                    'name' => $participantData['name'],
                    'email' => $participantData['email'],
                    'status' => 'invited',
                    'invitation_token' => \App\Models\SessionParticipant::generateInvitationToken(),
                    'invited_at' => now(),
                ]);
            }
        }

        $message = $validated['session_type'] === 'group' 
            ? 'Your group counseling request has been submitted successfully. Invitations will be sent to participants once a counselor accepts the session.'
            : 'Your counseling request has been submitted successfully. A counselor will contact you soon.';

        return redirect()
            ->route('public.counseling.session.show', $session)
            ->with('success', $message);
    }
    
    public function scheduleFollowUp(Request $request, CounselingSession $session)
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to schedule a follow-up session.');
        }
        
        // Ensure the session belongs to the authenticated user or user is a counselor
        if ($session->student_id !== auth()->id() && auth()->user()->role !== 'counselor') {
            abort(403, 'Unauthorized access.');
        }
        
        // Validate that the original session is completed or active
        if (!in_array($session->status, ['active', 'completed'])) {
            return back()->with('error', 'Follow-up sessions can only be scheduled for active or completed sessions.');
        }
        
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
            'preferred_datetime' => 'nullable|date|after:now',
        ]);
        
        // Get the root parent session (in case this is already a follow-up)
        $parentSession = $session->isFollowUp() ? $session->parentSession : $session;
        
        // Create follow-up session
        $followUpSession = CounselingSession::create([
            'student_id' => $parentSession->student_id,
            'counselor_id' => $parentSession->counselor_id,
            'preferred_counselor_id' => $parentSession->preferred_counselor_id, // Keep the same preferred counselor
            'parent_session_id' => $parentSession->id,
            'subject' => 'Follow-up: ' . $parentSession->subject,
            'description' => $validated['reason'] ?? 'Follow-up session for continued support.',
            'priority' => 'medium',
            'session_type' => $parentSession->session_type,
            'preferred_method' => $parentSession->preferred_method,
            'scheduled_at' => $validated['preferred_datetime'] ?? null,
            'is_anonymous' => $parentSession->is_anonymous,
            'wants_followup' => false,
            'status' => 'pending',
        ]);
        
        return redirect()
            ->route('public.counseling.session.show', $followUpSession)
            ->with('success', 'Follow-up session has been scheduled successfully.');
    }
    
    public function showSession(CounselingSession $session)
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to view your counseling session.');
        }
        
        $user = auth()->user();
        
        // Check if user has access to this session
        $hasAccess = false;
        
        // Primary student access
        if ($session->student_id === $user->id) {
            $hasAccess = true;
        }
        
        // Group participant access
        if ($session->session_type === 'group') {
            $participant = $session->participants()
                ->where('email', $user->email)
                ->whereIn('status', ['invited', 'joined'])
                ->first();
                
            if ($participant) {
                // If participant hasn't joined yet, redirect to sessions page to accept invitation
                if ($participant->status === 'invited') {
                    return redirect()
                        ->route('public.counseling.sessions')
                        ->with('info', 'Please accept the group session invitation first.');
                }
                
                $hasAccess = true;
            }
        }
        
        if (!$hasAccess) {
            abort(403, 'Unauthorized access to this counseling session.');
        }

        $session->load('messages.sender', 'counselor');

        return view('public.counseling.session', compact('session'));
    }
    
    public function sendMessage(Request $request, CounselingSession $session)
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to send messages.');
        }
        
        $user = auth()->user();
        
        // Check if user has access to this session
        $hasAccess = false;
        
        // Primary student access
        if ($session->student_id === $user->id) {
            $hasAccess = true;
        }
        
        // Group participant access
        if ($session->session_type === 'group') {
            $participant = $session->participants()
                ->where('email', $user->email)
                ->where('status', 'joined')
                ->first();
                
            if ($participant) {
                $hasAccess = true;
            }
        }
        
        if (!$hasAccess) {
            abort(403, 'Unauthorized access to this counseling session.');
        }

        $validated = $request->validate([
            'message' => 'required|string|min:1',
        ]);

        $session->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        // Return JSON response for AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully.'
            ]);
        }

        return back()->with('success', 'Message sent successfully.');
    }
    
    public function endSession(Request $request, CounselingSession $session)
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to end your session.');
        }
        
        $user = auth()->user();
        
        // Check if user has access to this session
        $hasAccess = false;
        $isInitiator = $session->isInitiator($user->id);
        $isParticipant = $session->isParticipant($user->id);
        
        if ($isInitiator || $isParticipant) {
            $hasAccess = true;
        }
        
        if (!$hasAccess) {
            abort(403, 'You do not have access to this session.');
        }

        // Only allow ending active sessions
        if ($session->status !== 'active') {
            return back()->with('error', 'Only active sessions can be ended.');
        }

        $validated = $request->validate([
            'feedback' => 'nullable|string|max:1000',
            'action' => 'required|in:end_for_all,leave_session',
        ]);

        try {
            if ($validated['action'] === 'end_for_all') {
                // Only initiator can end session for everyone
                if (!$isInitiator) {
                    return back()->with('error', 'Only the session creator can end the session for everyone.');
                }
                
                $session->endForEveryone($user->id, $validated['feedback']);
                $message = 'Session has been ended successfully for all participants.';
                
            } else { // leave_session
                // Only participants can leave (not initiator)
                if ($isInitiator) {
                    return back()->with('error', 'As the session creator, you cannot leave the session. You can end it for everyone instead.');
                }
                
                if (!$isParticipant) {
                    return back()->with('error', 'You are not a participant in this session.');
                }
                
                $session->leaveSession($user->id);
                $message = 'You have left the session successfully.';
            }
            
            return redirect()
                ->route('public.counseling.sessions')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function cancelSession(CounselingSession $session)
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to cancel your session.');
        }
        
        // Only the primary student can cancel sessions
        if ($session->student_id !== auth()->id()) {
            abort(403, 'Only the session creator can cancel this session.');
        }

        // Only allow canceling pending sessions
        if ($session->status !== 'pending') {
            return back()->with('error', 'Only pending sessions can be cancelled.');
        }

        $session->update(['status' => 'cancelled']);

        return redirect()
            ->route('public.counseling.sessions')
            ->with('success', 'Your counseling session request has been cancelled.');
    }

    public function acceptInvitation(CounselingSession $session)
    {
        $user = auth()->user();
        
        // Find the participant record for this user
        $participant = $session->participants()
            ->where('email', $user->email)
            ->where('status', 'invited')
            ->first();
            
        if (!$participant) {
            return back()->with('error', 'Invitation not found or already responded to.');
        }
        
        // Mark as joined
        $participant->markAsJoined();
        
        return redirect()
            ->route('public.counseling.session.show', $session)
            ->with('success', 'You have successfully joined the group session!');
    }
    
    public function declineInvitation(CounselingSession $session)
    {
        $user = auth()->user();
        
        // Find the participant record for this user
        $participant = $session->participants()
            ->where('email', $user->email)
            ->where('status', 'invited')
            ->first();
            
        if (!$participant) {
            return back()->with('error', 'Invitation not found or already responded to.');
        }
        
        // Mark as declined
        $participant->markAsDeclined();
        
        return redirect()
            ->route('public.counseling.sessions')
            ->with('success', 'You have declined the group session invitation.');
    }
    
    public function shareContactInfo(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:counseling_sessions,id',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'required|email',
            'preferred_contact' => 'required|in:phone,whatsapp,email',
            'contact_notes' => 'nullable|string|max:500',
        ]);
        
        $session = CounselingSession::findOrFail($validated['session_id']);
        $user = auth()->user();
        
        // Check if user has access to this session
        $hasAccess = false;
        
        // Primary student access
        if ($session->student_id === $user->id) {
            $hasAccess = true;
        }
        
        // Group participant access
        if ($session->session_type === 'group') {
            $participant = $session->participants()
                ->where('email', $user->email)
                ->where('status', 'joined')
                ->first();
                
            if ($participant) {
                $hasAccess = true;
            }
        }
        
        if (!$hasAccess) {
            return response()->json(['error' => 'Unauthorized access to this session.'], 403);
        }
        
        // Only allow sharing contact info for active sessions
        if ($session->status !== 'active') {
            return response()->json(['error' => 'Contact information can only be shared for active sessions.'], 400);
        }
        
        // Create or update contact information record
        // For now, we'll store it as a session note
        $contactInfo = [
            'phone' => $validated['phone'],
            'whatsapp' => $validated['whatsapp'],
            'email' => $validated['email'],
            'preferred_contact' => $validated['preferred_contact'],
            'notes' => $validated['contact_notes'],
            'shared_by' => $user->name,
            'shared_at' => now()->toDateTimeString(),
        ];
        
        // Add a system message to the session
        $session->messages()->create([
            'sender_id' => $user->id,
            'message' => "📞 Contact Information Shared:\n\n" .
                        "Phone: " . ($validated['phone'] ?: 'Not provided') . "\n" .
                        "WhatsApp: " . ($validated['whatsapp'] ?: 'Not provided') . "\n" .
                        "Email: " . $validated['email'] . "\n" .
                        "Preferred Method: " . ucfirst($validated['preferred_contact']) . "\n" .
                        ($validated['contact_notes'] ? "Notes: " . $validated['contact_notes'] : ''),
        ]);
        
        // Update user's phone number if provided and different
        if ($validated['phone'] && $user->phone !== $validated['phone']) {
            $user->update(['phone' => $validated['phone']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Contact information shared successfully with your counselor.',
        ]);
    }
}