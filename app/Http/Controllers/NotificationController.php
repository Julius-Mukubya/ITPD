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

    public function dropdown()
    {
        $user = auth()->user();
        
        if ($user->isCounselor()) {
            // Get counselor notifications
            $notifications = collect();
            
            // Pending sessions
            $pendingSessions = $user->counselingAsProvider()
                ->where('status', 'pending')
                ->with('student')
                ->latest()
                ->limit(3)
                ->get();
                
            foreach ($pendingSessions as $session) {
                $notifications->push([
                    'id' => 'session_' . $session->id,
                    'type' => 'session_request',
                    'title' => 'New Session Request',
                    'message' => 'From ' . $session->student->name,
                    'url' => route('counselor.sessions.show', $session->id),
                    'created_at' => $session->created_at,
                    'icon' => 'support_agent',
                    'color' => 'blue'
                ]);
            }
            
            // Unread messages
            $unreadMessages = CounselingMessage::whereHas('session', function($query) use ($user) {
                    $query->where('counselor_id', $user->id);
                })
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->with(['session.student', 'sender'])
                ->latest()
                ->limit(3)
                ->get();
                
            foreach ($unreadMessages as $message) {
                $notifications->push([
                    'id' => 'message_' . $message->id,
                    'type' => 'message',
                    'title' => 'New Message',
                    'message' => 'From ' . $message->sender->name,
                    'url' => route('counselor.sessions.show', $message->session->id),
                    'created_at' => $message->created_at,
                    'icon' => 'message',
                    'color' => 'green'
                ]);
            }
        } else {
            // Get admin/student notifications
            $dbNotifications = \DB::table('notifications')
                ->where('user_id', $user->id)
                ->where('is_read', false)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            $notifications = $dbNotifications->map(function ($notification) {
                $data = json_decode($notification->data, true) ?: [];
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'url' => $data['url'] ?? '#',
                    'created_at' => \Carbon\Carbon::parse($notification->created_at),
                    'icon' => $this->getNotificationIcon($notification->type),
                    'color' => $this->getNotificationColor($notification->type)
                ];
            });
        }
        
        // Sort by created_at and limit
        $notifications = $notifications->sortByDesc('created_at')->take(5)->values();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user->unreadNotificationsCount(),
            'has_more' => $notifications->count() >= 5
        ]);
    }
    
    private function getNotificationIcon($type)
    {
        $icons = [
            'session_request' => 'support_agent',
            'message' => 'message',
            'system' => 'notifications',
            'content' => 'article',
            'assessment' => 'psychology',
            'campaign' => 'campaign',
            'user' => 'person',
            'default' => 'notifications'
        ];
        
        return $icons[$type] ?? $icons['default'];
    }
    
    private function getNotificationColor($type)
    {
        $colors = [
            'session_request' => 'blue',
            'message' => 'green',
            'system' => 'gray',
            'content' => 'purple',
            'assessment' => 'emerald',
            'campaign' => 'teal',
            'user' => 'blue',
            'default' => 'gray'
        ];
        
        return $colors[$type] ?? $colors['default'];
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