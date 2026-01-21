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
            'contact_method' => 'required|in:zoom,google_meet,whatsapp,phone_call,physical',
        ]);

        // Get existing meeting links
        $existingLinks = $session->meeting_link ? explode("\n", trim($session->meeting_link)) : [];
        $existingLinks = array_filter(array_map('trim', $existingLinks));
        
        // Add the new link
        $newLink = trim($request->meeting_link);
        if (!in_array($newLink, $existingLinks)) {
            $existingLinks[] = $newLink;
        }
        
        // Update session with all links
        $session->update([
            'meeting_link' => implode("\n", $existingLinks),
        ]);

        return back()->with('success', 'Meeting link added successfully!');
    }

    public function removeMeetingLink(Request $request, CounselingSession $session)
    {
        if ($session->counselor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'link_to_remove' => 'required|string',
        ]);

        // Get existing meeting links
        $existingLinks = $session->meeting_link ? explode("\n", trim($session->meeting_link)) : [];
        $existingLinks = array_filter(array_map('trim', $existingLinks));
        
        // Remove the specified link
        $linkToRemove = trim($request->link_to_remove);
        $existingLinks = array_filter($existingLinks, function($link) use ($linkToRemove) {
            return $link !== $linkToRemove;
        });
        
        // Update session
        $session->update([
            'meeting_link' => empty($existingLinks) ? null : implode("\n", $existingLinks),
        ]);

        return response()->json(['success' => true, 'message' => 'Meeting link removed successfully!']);
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

    public function exportReports(Request $request)
    {
        $user = auth()->user();
        $type = $request->get('type', 'sessions'); // sessions, notes, or summary
        $period = $request->get('period', 'current_month'); // current_month, last_month, all_time
        
        $filename = "counselor_report_{$type}_{$period}_" . now()->format('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        return response()->stream(function() use ($user, $type, $period) {
            $handle = fopen('php://output', 'w');
            
            if ($type === 'sessions') {
                $this->exportSessionsData($handle, $user, $period);
            } elseif ($type === 'notes') {
                $this->exportNotesData($handle, $user, $period);
            } else {
                $this->exportSummaryData($handle, $user, $period);
            }
            
            fclose($handle);
        }, 200, $headers);
    }
    
    private function exportSessionsData($handle, $user, $period)
    {
        // CSV Headers
        fputcsv($handle, [
            'Session ID',
            'Client Name',
            'Client Email',
            'Session Type',
            'Status',
            'Priority',
            'Created Date',
            'Started Date',
            'Completed Date',
            'Duration (minutes)',
            'Subject',
            'Reason'
        ]);
        
        // Get sessions based on period
        $query = $user->counselingAsProvider()->with('student');
        
        if ($period === 'current_month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($period === 'last_month') {
            $lastMonth = now()->subMonth();
            $query->whereMonth('created_at', $lastMonth->month)
                  ->whereYear('created_at', $lastMonth->year);
        }
        // For 'all_time', no additional filters needed
        
        $sessions = $query->orderBy('created_at', 'desc')->get();
        
        foreach ($sessions as $session) {
            $duration = null;
            if ($session->started_at && $session->completed_at) {
                $duration = $session->started_at->diffInMinutes($session->completed_at);
            }
            
            fputcsv($handle, [
                $session->id,
                $session->student->name,
                $session->student->email,
                ucfirst(str_replace('_', ' ', $session->session_type)),
                ucfirst($session->status),
                ucfirst($session->priority),
                $session->created_at->format('Y-m-d H:i:s'),
                $session->started_at ? $session->started_at->format('Y-m-d H:i:s') : '',
                $session->completed_at ? $session->completed_at->format('Y-m-d H:i:s') : '',
                $duration,
                $session->subject,
                $session->reason
            ]);
        }
    }
    
    private function exportNotesData($handle, $user, $period)
    {
        // CSV Headers
        fputcsv($handle, [
            'Note ID',
            'Session ID',
            'Client Name',
            'Note Type',
            'Title',
            'Content',
            'Privacy',
            'Created Date',
            'Updated Date'
        ]);
        
        // Get notes based on period
        $query = \App\Models\SessionNote::where('counselor_id', $user->id)
            ->with(['session.student']);
        
        if ($period === 'current_month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($period === 'last_month') {
            $lastMonth = now()->subMonth();
            $query->whereMonth('created_at', $lastMonth->month)
                  ->whereYear('created_at', $lastMonth->year);
        }
        
        $notes = $query->orderBy('created_at', 'desc')->get();
        
        foreach ($notes as $note) {
            fputcsv($handle, [
                $note->id,
                $note->session_id,
                $note->session->student->name,
                ucfirst($note->type),
                $note->title,
                strip_tags($note->content),
                $note->is_private ? 'Private' : 'Public',
                $note->created_at->format('Y-m-d H:i:s'),
                $note->updated_at->format('Y-m-d H:i:s')
            ]);
        }
    }
    
    private function exportSummaryData($handle, $user, $period)
    {
        // CSV Headers
        fputcsv($handle, [
            'Metric',
            'Value',
            'Period'
        ]);
        
        $periodLabel = ucfirst(str_replace('_', ' ', $period));
        
        if ($period === 'current_month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } elseif ($period === 'last_month') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
        } else {
            $startDate = null;
            $endDate = null;
        }
        
        // Build query based on period
        $sessionsQuery = $user->counselingAsProvider();
        if ($startDate && $endDate) {
            $sessionsQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        $totalSessions = $sessionsQuery->count();
        $completedSessions = (clone $sessionsQuery)->where('status', 'completed')->count();
        $activeSessions = (clone $sessionsQuery)->where('status', 'active')->count();
        $pendingSessions = (clone $sessionsQuery)->where('status', 'pending')->count();
        
        // Calculate completion rate
        $completionRate = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100, 2) : 0;
        
        // Calculate average session duration
        $completedWithTime = (clone $sessionsQuery)
            ->where('status', 'completed')
            ->whereNotNull('started_at')
            ->whereNotNull('completed_at')
            ->get();
        
        $avgDuration = $completedWithTime->count() > 0 
            ? round($completedWithTime->avg(function($session) {
                return $session->started_at->diffInMinutes($session->completed_at);
            }), 2)
            : 0;
        
        // Unique clients helped
        $uniqueClients = \App\Models\User::where('role', 'user')
            ->whereHas('counselingSessions', function($query) use ($user, $startDate, $endDate) {
                $query->where('counselor_id', $user->id);
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            })->count();
        
        // Export summary data
        $summaryData = [
            ['Total Sessions', $totalSessions, $periodLabel],
            ['Completed Sessions', $completedSessions, $periodLabel],
            ['Active Sessions', $activeSessions, $periodLabel],
            ['Pending Sessions', $pendingSessions, $periodLabel],
            ['Completion Rate (%)', $completionRate, $periodLabel],
            ['Average Session Duration (minutes)', $avgDuration, $periodLabel],
            ['Unique Clients Helped', $uniqueClients, $periodLabel],
        ];
        
        foreach ($summaryData as $row) {
            fputcsv($handle, $row);
        }
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

    public function updateCustomContact(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $customContacts = $user->custom_contact_info ?: [];
        
        if (isset($customContacts[$request->key])) {
            $customContacts[$request->key]['value'] = $request->value;
            $user->update(['custom_contact_info' => $customContacts]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Custom contact updated successfully!'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Contact not found']);
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

    public function addMeetingLink(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:zoom,google_meet,whatsapp,phone_call,physical',
            'label' => 'nullable|string|max:100',
            'link' => 'required|string|max:500',
        ]);

        $user = auth()->user();
        $meetingLinks = $user->default_meeting_links ?: [];
        
        // Generate a unique key
        $key = $request->type . '_' . time();
        
        $meetingLinks[$key] = [
            'type' => $request->type,
            'label' => $request->label,
            'link' => $request->link,
        ];

        $user->update(['default_meeting_links' => $meetingLinks]);

        return response()->json([
            'success' => true, 
            'message' => 'Meeting link added successfully!',
            'meeting' => $meetingLinks[$key],
            'key' => $key
        ]);
    }

    public function deleteMeetingLink($key)
    {
        $user = auth()->user();
        $meetingLinks = $user->default_meeting_links ?: [];
        
        if (isset($meetingLinks[$key])) {
            unset($meetingLinks[$key]);
            $user->update(['default_meeting_links' => $meetingLinks]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Meeting link deleted successfully!'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Meeting link not found']);
    }
}