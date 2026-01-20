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
        'avatar',
        'role',
        'is_active',
        'last_login_at',
        'preferred_video_service',
        'auto_start_video',
        'default_camera_on',
        'default_microphone_on',
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
        'is_active' => 'boolean',
        'auto_start_video' => 'boolean',
        'default_camera_on' => 'boolean',
        'default_microphone_on' => 'boolean',
        'availability_hours' => 'array',
        'custom_contact_info' => 'array',
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

    // Backward compatibility - alias for isUser()
    public function isStudent()
    {
        return $this->role === 'user';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    public function unreadNotificationsCount()
    {
        return $this->unreadNotifications()->count();
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : asset('images/default-avatar.png');
    }
}

