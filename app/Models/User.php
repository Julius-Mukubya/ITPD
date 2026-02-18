<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'registration_number',
        'phone',
        'whatsapp_number',
        'counselor_email',
        'office_address',
        'office_phone',
        'availability_hours',
        'custom_contact_info',
        'default_meeting_links',
        'avatar',
        'role',
        'is_active',
        'last_login_at',
        'preferred_video_service',
        'auto_start_video',
        'default_camera_on',
        'default_microphone_on',
        'banned_at',
        'ban_reason',
        'banned_by',
        'warning_count',
        'last_warned_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'banned_at' => 'datetime',
        'last_warned_at' => 'datetime',
        'is_active' => 'boolean',
        'auto_start_video' => 'boolean',
        'default_camera_on' => 'boolean',
        'default_microphone_on' => 'boolean',
        'availability_hours' => 'array',
        'custom_contact_info' => 'array',
        'default_meeting_links' => 'array',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    // Relationships
    public function contents()
    {
        return $this->hasMany(EducationalContent::class, 'created_by');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'created_by');
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function assessmentAttempts()
    {
        return $this->hasMany(AssessmentAttempt::class);
    }

    public function counselingSessions()
    {
        return $this->hasMany(CounselingSession::class, 'student_id');
    }

    public function groupSessionParticipations()
    {
        return $this->hasManyThrough(
            CounselingSession::class,
            SessionParticipant::class,
            'email', // Foreign key on SessionParticipant table
            'id', // Foreign key on CounselingSession table
            'email', // Local key on User table
            'counseling_session_id' // Local key on SessionParticipant table
        )->where('session_participants.status', '!=', 'declined');
    }

    public function allCounselingSessions()
    {
        // Get all sessions where user is involved (primary student or participant)
        return CounselingSession::where(function($query) {
            $query->where('student_id', $this->id)
                  ->orWhere(function($subQuery) {
                      $subQuery->where('session_type', 'group')
                               ->whereHas('participants', function($participantQuery) {
                                   $participantQuery->where('email', $this->email)
                                                   ->whereIn('status', ['invited', 'joined']);
                               });
                  });
        });
    }

    public function counselingAsProvider()
    {
        return $this->hasMany(CounselingSession::class, 'counselor_id');
    }

    public function counselingMessages()
    {
        return $this->hasMany(CounselingMessage::class, 'sender_id');
    }

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function forumComments()
    {
        return $this->hasMany(ForumComment::class);
    }



    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'created_by');
    }

    public function campaignParticipations()
    {
        return $this->hasMany(CampaignParticipant::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function contentViews()
    {
        return $this->hasMany(ContentView::class);
    }

    public function upvotes()
    {
        return $this->hasMany(ForumUpvote::class);
    }

    public function warnings()
    {
        return $this->hasMany(UserWarning::class);
    }

    public function issuedWarnings()
    {
        return $this->hasMany(UserWarning::class, 'issued_by');
    }

    // Helper Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCounselor()
    {
        return $this->role === 'counselor';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    // Backward compatibility - alias for isUser()
    public function isStudent()
    {
        return $this->role === 'user';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if user is banned
     */
    public function isBanned(): bool
    {
        return !is_null($this->banned_at);
    }

    /**
     * Ban the user
     */
    public function ban(string $reason, int $bannedBy): void
    {
        $this->update([
            'banned_at' => now(),
            'ban_reason' => $reason,
            'banned_by' => $bannedBy,
        ]);
    }

    /**
     * Unban the user
     */
    public function unban(): void
    {
        $this->update([
            'banned_at' => null,
            'ban_reason' => null,
            'banned_by' => null,
        ]);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    public function unreadNotificationsCount()
    {
        if ($this->isCounselor()) {
            return $this->getCounselorNotificationCount();
        }
        
        return $this->unreadNotifications()->count();
    }

    public function getCounselorNotificationCount()
    {
        $pendingSessions = $this->getPendingSessionsCount();
        $upcomingSessions = $this->getUpcomingSessionsCount();
        $unreadMessages = $this->getUnreadSessionMessagesCount();
        
        return $pendingSessions + $upcomingSessions + $unreadMessages;
    }

    public function getPendingSessionsCount()
    {
        return $this->counselingAsProvider()
            ->where('status', 'pending')
            ->count();
    }

    public function getUpcomingSessionsCount()
    {
        return $this->counselingAsProvider()
            ->where('status', 'active')
            ->where('scheduled_at', '>', now())
            ->where('scheduled_at', '<=', now()->addDays(1)) // Next 24 hours
            ->count();
    }

    public function getUnreadSessionMessagesCount()
    {
        return CounselingMessage::whereHas('session', function($query) {
                $query->where('counselor_id', $this->id);
            })
            ->where('sender_id', '!=', $this->id)
            ->where('is_read', false)
            ->count();
    }

    public function getCounselorNotifications()
    {
        $notifications = collect();

        // Pending session requests
        $pendingSessions = $this->counselingAsProvider()
            ->where('status', 'pending')
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($pendingSessions as $session) {
            $notifications->push([
                'type' => 'pending_session',
                'title' => 'New Session Request',
                'message' => "New session request from {$session->student->name}",
                'url' => route('counselor.sessions.show', $session),
                'time' => $session->created_at,
                'priority' => $session->priority,
                'icon' => 'pending',
                'color' => 'yellow'
            ]);
        }

        // Upcoming sessions (next 24 hours)
        $upcomingSessions = $this->counselingAsProvider()
            ->where('status', 'active')
            ->where('scheduled_at', '>', now())
            ->where('scheduled_at', '<=', now()->addDays(1))
            ->with('student')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        foreach ($upcomingSessions as $session) {
            $notifications->push([
                'type' => 'upcoming_session',
                'title' => 'Upcoming Session',
                'message' => "Session with {$session->student->name} at " . $session->scheduled_at->format('g:i A'),
                'url' => route('counselor.sessions.show', $session),
                'time' => $session->scheduled_at,
                'priority' => 'medium',
                'icon' => 'schedule',
                'color' => 'blue'
            ]);
        }

        // Unread messages in sessions
        $unreadMessages = CounselingMessage::whereHas('session', function($query) {
                $query->where('counselor_id', $this->id);
            })
            ->where('sender_id', '!=', $this->id)
            ->where('is_read', false)
            ->with(['session.student', 'sender'])
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($unreadMessages as $message) {
            $notifications->push([
                'type' => 'unread_message',
                'title' => 'New Message',
                'message' => "New message from {$message->sender->name} in session",
                'url' => route('counselor.sessions.show', $message->session),
                'time' => $message->created_at,
                'priority' => 'medium',
                'icon' => 'message',
                'color' => 'green'
            ]);
        }

        return $notifications->sortByDesc('time')->take(10);
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : asset('images/default-avatar.png');
    }
}

