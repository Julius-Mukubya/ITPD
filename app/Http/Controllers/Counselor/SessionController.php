<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\{CounselingSession, CounselingMessage};
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Admins can see all sessions, counselors only see their own
        if ($user->role === 'admin') {
            $pendingSessions = CounselingSession::pending()
                ->with('student')
                ->latest()
                ->get();

            $activeSessions = CounselingSession::active()
                ->with(['student', 'counselor'])
                ->latest()
                ->get();

            $completedSessions = CounselingSession::completed()
                ->with(['student', 'counselor'])
                ->latest()
                ->paginate(10);
        } else {
            // Counselors can only see:
            // 1. Pending sessions that were specifically requested to them (if they have a preferred_counselor_id)
            // 2. Active sessions they are assigned to
            // 3. Completed sessions they handled
            $pendingSessions = CounselingSession::pending()
                ->where(function($query) use ($user) {
                    // Only show pending sessions that were specifically requested to this counselor
                    $query->where('preferred_counselor_id', $user->id)
                          // OR sessions that are already assigned to them but still pending
                          ->orWhere('counselor_id', $user->id);
                })
                ->with('student')
                ->latest()
                ->get();

            $activeSessions = $user->counselingAsProvider()
                ->active()
                ->with('student')
                ->latest()
                ->get();

            $completedSessions = $user->counselingAsProvider()
                ->completed()
                ->with('student')
                ->latest()
                ->paginate(10);
        }

        return view('counselor.sessions.index', compact('pendingSessions', 'activeSessions', 'completedSessions'));
    }

    public function show(CounselingSession $session)
    {
        $user = auth()->user();
        
        // Allow admins to view all sessions, counselors only their own or sessions specifically requested to them
        if ($user->role !== 'admin') {
            $canView = false;
            
            // Counselor can view if:
            // 1. They are assigned to the session
            // 2. The session is pending and was specifically requested to them
            if ($session->counselor_id === $user->id) {
                $canView = true;
            } elseif ($session->status === 'pending' && $session->preferred_counselor_id === $user->id) {
                $canView = true;
            }
            
            if (!$canView) {
                abort(403, 'You are not authorized to view this session.');
            }
        }

        $session->load(['student', 'counselor', 'messages.sender']);

        // Mark messages as read (only for counselors, not admins viewing)
        if ($user->role === 'counselor' && $session->counselor_id === $user->id) {
            $session->messages()
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->each(fn($msg) => $msg->markAsRead());
        }

        return view('counselor.sessions.show', compact('session'));
    }

    public function accept(CounselingSession $session)
    {
        if ($session->status !== 'pending') {
            return back()->with('error', 'Session is not pending.');
        }

        $user = auth()->user();
        
        // Only allow acceptance if:
        // 1. The session was specifically requested to this counselor, OR
        // 2. The session has no preferred counselor (general request) and user is admin, OR
        // 3. The session is already assigned to this counselor
        if ($session->preferred_counselor_id !== $user->id && 
            $session->counselor_id !== $user->id && 
            !($user->role === 'admin' && !$session->preferred_counselor_id)) {
            return back()->with('error', 'You are not authorized to accept this session.');
        }

        $session->update([
            'counselor_id' => auth()->id(),
            'status' => 'active',
            'started_at' => now(),
        ]);

        return redirect()->route('counselor.sessions.show', $session)
            ->with('success', 'Session accepted!');
    }

    public function complete(Request $request, CounselingSession $session)
    {
        if ($session->counselor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'outcome_notes' => 'required|string',
            'counselor_notes' => 'nullable|string',
        ]);

        $session->update([
            'status' => 'completed',
            'completed_at' => now(),
            'outcome_notes' => $request->outcome_notes,
            'counselor_notes' => $request->counselor_notes,
        ]);

        return redirect()->route('counselor.sessions.index')
            ->with('success', 'Session completed successfully!');
    }

    public function sendMessage(Request $request, CounselingSession $session)
    {
        if ($session->counselor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('counseling-attachments', 'public');
        }

        $message = CounselingMessage::create([
            'session_id' => $session->id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'attachment_path' => $attachmentPath,
        ]);

        \Log::info('Message created', [
            'message_id' => $message->id,
            'session_id' => $session->id,
            'sender_id' => auth()->id(),
            'message_content' => $request->message
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!',
                'data' => $message
            ]);
        }

        return back()->with('success', 'Message sent!');
    }

    public function updateMeetingLink(Request $request, CounselingSession $session)
    {
        if ($session->counselor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'meeting_link' => 'required|string|max:500',
            'contact_method' => 'required|in:zoom,google_meet,whatsapp,phone_call,physical,jitsi',
        ]);

        $session->update([
            'meeting_link' => $request->meeting_link,
        ]);

        // Use the selected method from the form, not the preferred method
        $selectedMethod = $request->contact_method;
        $methodName = ucfirst(str_replace('_', ' ', $selectedMethod));
        $scheduledTime = $session->scheduled_at ? $session->scheduled_at->format('l, F j, Y \a\t g:i A') : 'To be confirmed';
        
        $message = "📅 {$methodName} Session Details\n\n";
        $message .= "Hello! I've scheduled our counseling session. Here are the details:\n\n";
        
        if ($selectedMethod === 'zoom') {
            $message .= "🎥 Zoom Meeting Link:\n{$request->meeting_link}\n\n";
            $message .= "📌 Instructions:\n";
            $message .= "1. Click the link above at the scheduled time\n";
            $message .= "2. You may need to download Zoom if you haven't already\n";
            $message .= "3. Please join a few minutes early to test your audio/video\n";
        } elseif ($selectedMethod === 'google_meet') {
            $message .= "🎥 Google Meet Link:\n{$request->meeting_link}\n\n";
            $message .= "📌 Instructions:\n";
            $message .= "1. Click the link above at the scheduled time\n";
            $message .= "2. Make sure you're signed into your Google account\n";
            $message .= "3. Allow camera and microphone access when prompted\n";
        } elseif ($selectedMethod === 'whatsapp') {
            $message .= "💬 WhatsApp Contact:\n{$request->meeting_link}\n\n";
            $message .= "📌 Instructions:\n";
            $message .= "1. Save this number or click the link to start a chat\n";
            $message .= "2. Send me a message to confirm you've added me\n";
            $message .= "3. I'll reach out at the scheduled time\n";
        } elseif ($selectedMethod === 'phone_call') {
            $message .= "📞 Phone Number:\n{$request->meeting_link}\n\n";
            $message .= "📌 Instructions:\n";
            $message .= "1. I will call you at the scheduled time\n";
            $message .= "2. Please ensure you're in a quiet, private space\n";
            $message .= "3. If you miss the call, I'll try again in 5 minutes\n";
        } elseif ($selectedMethod === 'jitsi') {
            $message .= "🎥 Jitsi Meet (Embedded Video Call):\n{$request->meeting_link}\n\n";
            $message .= "📌 Instructions:\n";
            $message .= "1. The video call will appear directly in this chat interface\n";
            $message .= "2. No need to download any apps or leave this page\n";
            $message .= "3. Allow camera and microphone access when prompted\n";
            $message .= "4. You can also click the link above to open in a new tab if needed\n";
        } else {
            $message .= "📍 Meeting Location:\n{$request->meeting_link}\n\n";
            $message .= "📌 Instructions:\n";
            $message .= "1. Please arrive 5-10 minutes early\n";
            $message .= "2. Check in at the reception if needed\n";
            $message .= "3. Bring any relevant documents or notes\n";
        }
        
        $message .= "\n⏰ Scheduled Time: {$scheduledTime}\n\n";
        $message .= "If you need to reschedule or have any questions, please let me know. Looking forward to our session!";

        CounselingMessage::create([
            'session_id' => $session->id,
            'sender_id' => auth()->id(),
            'message' => $message,
        ]);

        return back()->with('success', 'Meeting details saved and shared with the student!');
    }

    public function addNote(Request $request, CounselingSession $session)
    {
        // Allow counselors to add notes to their sessions or pending sessions
        if (auth()->user()->role !== 'admin' && $session->counselor_id !== auth()->id() && $session->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:progress,observation,reminder,general',
            'is_private' => 'boolean',
        ]);

        $session->notes()->create([
            'counselor_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'is_private' => $request->is_private ?? true,
        ]);

        return back()->with('success', 'Note added successfully!');
    }

    public function deleteNote(CounselingSession $session, $noteId)
    {
        $note = $session->notes()->findOrFail($noteId);

        // Only the note creator or admin can delete
        if (auth()->user()->role !== 'admin' && $note->counselor_id !== auth()->id()) {
            abort(403);
        }

        $note->delete();

        return back()->with('success', 'Note deleted successfully!');
    }

    // Simple counseling features
    public function students()
    {
        $user = auth()->user();
        
        // Get all unique clients (users) who have interacted with this counselor
        // either as primary students or as group session participants
        
        $clientsData = collect();
        $processedEmails = collect();
        
        // Get all sessions for this counselor
        $counselorSessions = \App\Models\CounselingSession::where('counselor_id', $user->id)
            ->with(['student', 'participants'])
            ->get();
        
        foreach ($counselorSessions as $session) {
            // Add primary student
            if ($session->student && !$processedEmails->contains($session->student->email)) {
                $processedEmails->push($session->student->email);
                
                // Count all sessions for this client with this counselor
                $totalSessions = $this->countClientSessions($session->student, $user->id);
                $lastSession = $this->getLastClientSession($session->student, $user->id);
                $sessionTypes = $this->getClientSessionTypes($session->student, $user->id);
                
                $clientsData->push((object)[
                    'id' => $session->student->id,
                    'name' => $session->student->name,
                    'email' => $session->student->email,
                    'role' => $session->student->role,
                    'total_sessions' => $totalSessions,
                    'last_session' => $lastSession,
                    'session_types' => $sessionTypes
                ]);
            }
            
            // Add group session participants
            if ($session->session_type === 'group') {
                foreach ($session->participants as $participant) {
                    if ($participant->status !== 'declined' && !$processedEmails->contains($participant->email)) {
                        $processedEmails->push($participant->email);
                        
                        // Find the user record for this participant
                        $participantUser = \App\Models\User::where('email', $participant->email)->first();
                        
                        if ($participantUser) {
                            $totalSessions = $this->countClientSessions($participantUser, $user->id);
                            $lastSession = $this->getLastClientSession($participantUser, $user->id);
                            $sessionTypes = $this->getClientSessionTypes($participantUser, $user->id);
                            
                            $clientsData->push((object)[
                                'id' => $participantUser->id,
                                'name' => $participantUser->name,
                                'email' => $participantUser->email,
                                'role' => $participantUser->role,
                                'total_sessions' => $totalSessions,
                                'last_session' => $lastSession,
                                'session_types' => $sessionTypes
                            ]);
                        }
                    }
                }
            }
        }
        
        // Sort by most recent session
        $students = $clientsData->sortByDesc(function($client) {
            return $client->last_session ? $client->last_session->created_at : null;
        });

        return view('counselor.clients', compact('students'));
    }
    
    private function countClientSessions($client, $counselorId)
    {
        // Count individual sessions where client is the primary student
        $individualSessions = $client->counselingSessions()
            ->where('counselor_id', $counselorId)
            ->count();
            
        // Count group sessions where client is a participant
        $groupSessions = \App\Models\CounselingSession::where('counselor_id', $counselorId)
            ->where('session_type', 'group')
            ->whereHas('participants', function($query) use ($client) {
                $query->where('email', $client->email)
                      ->whereIn('status', ['joined', 'invited']);
            })
            ->count();
        
        return $individualSessions + $groupSessions;
    }
    
    private function getLastClientSession($client, $counselorId)
    {
        // Get most recent individual session
        $lastIndividualSession = $client->counselingSessions()
            ->where('counselor_id', $counselorId)
            ->latest()
            ->first();
            
        // Get most recent group session
        $lastGroupSession = \App\Models\CounselingSession::where('counselor_id', $counselorId)
            ->where('session_type', 'group')
            ->whereHas('participants', function($query) use ($client) {
                $query->where('email', $client->email)
                      ->whereIn('status', ['joined', 'invited']);
            })
            ->latest()
            ->first();
        
        // Return the most recent of the two
        if ($lastIndividualSession && $lastGroupSession) {
            return $lastIndividualSession->created_at->gt($lastGroupSession->created_at) 
                ? $lastIndividualSession 
                : $lastGroupSession;
        }
        
        return $lastIndividualSession ?: $lastGroupSession;
    }
    
    private function getClientSessionTypes($client, $counselorId)
    {
        $types = [];
        
        // Check for individual sessions
        $hasIndividual = $client->counselingSessions()
            ->where('counselor_id', $counselorId)
            ->where('session_type', 'individual')
            ->exists();
            
        if ($hasIndividual) {
            $types[] = 'individual';
        }
        
        // Check for group sessions
        $hasGroup = \App\Models\CounselingSession::where('counselor_id', $counselorId)
            ->where('session_type', 'group')
            ->whereHas('participants', function($query) use ($client) {
                $query->where('email', $client->email)
                      ->whereIn('status', ['joined', 'invited']);
            })
            ->exists();
            
        if ($hasGroup) {
            $types[] = 'group';
        }
        
        return $types;
    }

    public function schedule()
    {
        $user = auth()->user();
        
        // Get upcoming sessions for this counselor
        $upcomingSessions = $user->counselingAsProvider()
            ->whereIn('status', ['pending', 'active'])
            ->whereDate('scheduled_at', '>=', now()->toDateString())
            ->with('student')
            ->orderBy('scheduled_at')
            ->get();

        // Get today's sessions
        $todaysSessions = $user->counselingAsProvider()
            ->whereIn('status', ['pending', 'active'])
            ->whereDate('scheduled_at', now()->toDateString())
            ->with('student')
            ->orderBy('scheduled_at')
            ->get();

        // Get this week's sessions
        $weekSessions = $user->counselingAsProvider()
            ->whereIn('status', ['pending', 'active'])
            ->whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->with('student')
            ->orderBy('scheduled_at')
            ->get();

        return view('counselor.schedule', compact('upcomingSessions', 'todaysSessions', 'weekSessions'));
    }

    public function reports()
    {
        $user = auth()->user();
        
        // Monthly statistics
        $currentMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        
        $monthlyStats = [
            'current_month' => [
                'total' => $user->counselingAsProvider()
                    ->whereMonth('created_at', $currentMonth->month)
                    ->whereYear('created_at', $currentMonth->year)
                    ->count(),
                'completed' => $user->counselingAsProvider()
                    ->where('status', 'completed')
                    ->whereMonth('completed_at', $currentMonth->month)
                    ->whereYear('completed_at', $currentMonth->year)
                    ->count(),
                'pending' => $user->counselingAsProvider()
                    ->where('status', 'pending')
                    ->whereMonth('created_at', $currentMonth->month)
                    ->whereYear('created_at', $currentMonth->year)
                    ->count(),
                'active' => $user->counselingAsProvider()
                    ->where('status', 'active')
                    ->whereMonth('started_at', $currentMonth->month)
                    ->whereYear('started_at', $currentMonth->year)
                    ->count(),
            ],
            'last_month' => [
                'total' => $user->counselingAsProvider()
                    ->whereMonth('created_at', $lastMonth->month)
                    ->whereYear('created_at', $lastMonth->year)
                    ->count(),
                'completed' => $user->counselingAsProvider()
                    ->where('status', 'completed')
                    ->whereMonth('completed_at', $lastMonth->month)
                    ->whereYear('completed_at', $lastMonth->year)
                    ->count(),
            ]
        ];

        // Recent completed sessions for detailed view
        $recentSessions = $user->counselingAsProvider()
            ->where('status', 'completed')
            ->with('student')
            ->latest('completed_at')
            ->limit(10)
            ->get();

        return view('counselor.reports', compact('monthlyStats', 'recentSessions'));
    }

    public function contactSetup()
    {
        $user = auth()->user();
        return view('counselor.contact-setup', compact('user'));
    }

    public function updateContactInfo(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'counselor_email' => 'nullable|email|max:255',
            'office_address' => 'nullable|string|max:500',
            'office_phone' => 'nullable|string|max:20',
            'availability_hours' => 'nullable|array',
        ]);

        $user = auth()->user();
        $user->update([
            'phone' => $request->phone,
            'whatsapp_number' => $request->whatsapp_number,
            'counselor_email' => $request->counselor_email ?: $user->email,
            'office_address' => $request->office_address,
            'office_phone' => $request->office_phone,
            'availability_hours' => $request->availability_hours,
        ]);

        return redirect()->route('counselor.contact-setup')
            ->with('success', 'Contact information updated successfully!');
    }

    public function updateContactField(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        
        $allowedFields = ['phone', 'whatsapp_number', 'counselor_email', 'office_address', 'office_phone'];
        
        if (!in_array($field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'Invalid field']);
        }

        $validationRules = [
            'phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'counselor_email' => 'nullable|email|max:255',
            'office_address' => 'nullable|string|max:500',
            'office_phone' => 'nullable|string|max:20',
        ];

        $validator = validator(['value' => $value], ['value' => $validationRules[$field]]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $user = auth()->user();
        $user->update([$field => $value]);

        $fieldNames = [
            'phone' => 'Phone number',
            'whatsapp_number' => 'WhatsApp number',
            'counselor_email' => 'Email address',
            'office_address' => 'Office address',
            'office_phone' => 'Office phone',
        ];

        return response()->json([
            'success' => true, 
            'message' => $fieldNames[$field] . ' updated successfully!'
        ]);
    }

    public function addCustomContact(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $user = auth()->user();
        $customContacts = $user->custom_contact_info ?: [];
        
        // Generate a unique key
        $key = strtolower(str_replace(' ', '_', $request->label)) . '_' . time();
        
        $customContacts[$key] = [
            'label' => $request->label,
            'value' => $request->value,
            'icon' => $request->icon ?: 'contact_page',
        ];

        $user->update(['custom_contact_info' => $customContacts]);

        return response()->json([
            'success' => true, 
            'message' => 'Custom contact added successfully!',
            'contact' => $customContacts[$key],
            'key' => $key
        ]);
    }

    public function deleteCustomContact($key)
    {
        $user = auth()->user();
        $customContacts = $user->custom_contact_info ?: [];
        
        if (isset($customContacts[$key])) {
            unset($customContacts[$key]);
            $user->update(['custom_contact_info' => $customContacts]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Custom contact deleted successfully!'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Contact not found']);
    }
}