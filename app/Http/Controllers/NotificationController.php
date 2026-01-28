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

        // Get notifications from the custom notifications table
        $notifications = \DB::table('notifications')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Convert to collection with proper data structure
        $notifications->getCollection()->transform(function ($notification) {
            $notification->data = json_decode($notification->data, true) ?: [];
            $notification->data['type'] = $notification->type;
            $notification->data['title'] = $notification->title;
            $notification->data['message'] = $notification->message;
            $notification->read_at = $notification->is_read ? $notification->updated_at : null;
            $notification->created_at = \Carbon\Carbon::parse($notification->created_at);
            return $notification;
        });

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
        \DB::table('notifications')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->update([
                'is_read' => true,
                'read_at' => now(),
                'updated_at' => now()
            ]);

        return back();
    }

    public function markAllAsRead()
    {
        if (auth()->user()->isCounselor()) {
            return $this->markCounselorNotificationsAsRead();
        }

        \DB::table('notifications')
            ->where('user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
                'updated_at' => now()
            ]);

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

    public function createSystemNotification($type, $title, $message, $url = null, $userId = null)
    {
        // Create a system notification using the custom notifications table
        $notificationData = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => json_encode(['url' => $url]),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now()
        ];

        if ($userId) {
            // Send to specific user
            $notificationData['user_id'] = $userId;
            \DB::table('notifications')->insert($notificationData);
        } else {
            // Send to all admin users
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $notificationData['user_id'] = $admin->id;
                \DB::table('notifications')->insert($notificationData);
            }
        }

        return true;
    }
}