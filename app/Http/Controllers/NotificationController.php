<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingMessage;

class NotificationController extends Controller
{
    public function index()
    {
        if (auth()->user()->isCounselor()) {
            return $this->counselorNotifications();
        }

        $notifications = auth()->user()->notifications()
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    private function counselorNotifications()
    {
        $user = auth()->user();
        
        // Get all counselor notifications
        $allNotifications = $user->getCounselorNotifications();
        
        // Get detailed data for the notifications page
        $pendingSessions = $user->counselingAsProvider()
            ->where('status', 'pending')
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->get();

        $upcomingSessions = $user->counselingAsProvider()
            ->where('status', 'active')
            ->where('scheduled_at', '>', now())
            ->where('scheduled_at', '<=', now()->addDays(7)) // Next 7 days
            ->with('student')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $unreadMessages = CounselingMessage::whereHas('session', function($query) use ($user) {
                $query->where('counselor_id', $user->id);
            })
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->with(['session.student', 'sender'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.counselor', compact(
            'pendingSessions', 
            'upcomingSessions', 
            'unreadMessages',
            'allNotifications'
        ));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back();
    }

    public function markAllAsRead()
    {
        if (auth()->user()->isCounselor()) {
            return $this->markCounselorNotificationsAsRead();
        }

        auth()->user()->notifications()->unread()->each(fn($n) => $n->markAsRead());

        return back()->with('success', 'All notifications marked as read.');
    }

    private function markCounselorNotificationsAsRead()
    {
        $user = auth()->user();
        
        // Mark all unread messages as read
        CounselingMessage::whereHas('session', function($query) use ($user) {
                $query->where('counselor_id', $user->id);
            })
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function markMessageAsRead(Request $request)
    {
        $messageId = $request->input('message_id');
        $message = CounselingMessage::findOrFail($messageId);
        
        // Ensure the counselor owns this session
        if ($message->session->counselor_id !== auth()->id()) {
            abort(403);
        }
        
        $message->markAsRead();
        
        return response()->json(['success' => true]);
    }
}