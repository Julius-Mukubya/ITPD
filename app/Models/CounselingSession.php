<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CounselingSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'counselor_id',
        'preferred_counselor_id',
        'parent_session_id',
        'subject',
        'description',
        'status',
        'priority',
        'session_type',
        'preferred_method',
        'meeting_link',
        'is_anonymous',
        'wants_followup',
        'scheduled_at',
        'started_at',
        'completed_at',
        'outcome_notes',
        'counselor_notes',
        'rating',
        'feedback',
    ];

    protected $casts = [
            'is_anonymous' => 'boolean',
            'wants_followup' => 'boolean',
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'rating' => 'integer',
        ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function preferredCounselor()
    {
        return $this->belongsTo(User::class, 'preferred_counselor_id');
    }

    public function messages()
    {
        return $this->hasMany(CounselingMessage::class, 'session_id')->orderBy('created_at');
    }

    public function notes()
    {
        return $this->hasMany(SessionNote::class, 'session_id')->orderBy('created_at', 'desc');
    }

    public function participants()
    {
        return $this->hasMany(SessionParticipant::class, 'counseling_session_id');
    }

    // Follow-up session relationships
    public function parentSession()
    {
        return $this->belongsTo(CounselingSession::class, 'parent_session_id');
    }

    public function followUpSessions()
    {
        return $this->hasMany(CounselingSession::class, 'parent_session_id')->orderBy('created_at');
    }

    // Check if this is a follow-up session
    public function isFollowUp()
    {
        return !is_null($this->parent_session_id);
    }

    // Check if this is a group session
    public function isGroupSession()
    {
        return $this->session_type === 'group';
    }

    // Get active participants count
    public function getActiveParticipantsCount()
    {
        return $this->participants()->where('status', 'joined')->count();
    }

    // Get all participants (including the main student)
    public function getAllParticipants()
    {
        $participants = collect([$this->student]);
        
        if ($this->isGroupSession()) {
            $groupParticipants = $this->participants()->where('status', 'joined')->get();
            $participants = $participants->merge($groupParticipants);
        }
        
        return $participants;
    }

    // Get the session series (parent + all follow-ups)
    public function getSessionSeries()
    {
        if ($this->isFollowUp()) {
            return $this->parentSession->followUpSessions()->get()->prepend($this->parentSession);
        }
        return $this->followUpSessions()->get()->prepend($this);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Methods
    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function getStatusBadgeAttribute()
    {
        switch($this->status) {
            case 'pending':
                return ['text' => 'Pending', 'color' => 'yellow'];
            case 'active':
                return ['text' => 'Active', 'color' => 'blue'];
            case 'completed':
                return ['text' => 'Completed', 'color' => 'green'];
            case 'cancelled':
                return ['text' => 'Cancelled', 'color' => 'red'];
            default:
                return ['text' => 'Unknown', 'color' => 'gray'];
        }
    }

    public function getPriorityBadgeAttribute()
    {
        switch($this->priority) {
            case 'low':
                return ['text' => 'Low', 'color' => 'gray'];
            case 'medium':
                return ['text' => 'Medium', 'color' => 'blue'];
            case 'high':
                return ['text' => 'High', 'color' => 'orange'];
            case 'urgent':
                return ['text' => 'Urgent', 'color' => 'red'];
            default:
                return ['text' => 'Normal', 'color' => 'gray'];
        }
    }
}
