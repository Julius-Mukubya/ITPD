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

    public function feedback()
    {
        return $this->hasMany(SessionFeedback::class, 'counseling_session_id');
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

    // Check if a user is the session initiator (primary student)
    public function isInitiator($userId)
    {
        return $this->student_id === $userId;
    }

    // Check if a user is a participant in the group session
    public function isParticipant($userId)
    {
        if (!$this->isGroupSession()) {
            return false;
        }

        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        return $this->participants()
            ->where('email', $user->email)
            ->where('status', 'joined')
            ->exists();
    }

    // End session for everyone (only initiator can do this)
    public function endForEveryone($userId, $feedback = null)
    {
        if (!$this->isInitiator($userId)) {
            throw new \Exception('Only the session initiator can end the session for everyone.');
        }

        if ($this->status !== 'active') {
            throw new \Exception('Only active sessions can be ended.');
        }

        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Add feedback as a system message if provided
        if (!empty($feedback)) {
            $this->messages()->create([
                'sender_id' => $userId,
                'message' => "📝 Session Feedback:\n\n" . $feedback,
            ]);
        }

        // Add system message about session ending
        $this->messages()->create([
            'sender_id' => $userId,
            'message' => "🔚 Session ended by " . User::find($userId)->name . ".",
        ]);

        return true;
    }

    // Leave session (only participants can do this, not initiator)
    public function leaveSession($userId)
    {
        if ($this->isInitiator($userId)) {
            throw new \Exception('Session initiator cannot leave the session. Use endForEveryone() instead.');
        }

        if (!$this->isParticipant($userId)) {
            throw new \Exception('User is not a participant in this session.');
        }

        if ($this->status !== 'active') {
            throw new \Exception('Can only leave active sessions.');
        }

        $user = User::find($userId);
        
        // Update participant status to 'left'
        $participant = $this->participants()
            ->where('email', $user->email)
            ->where('status', 'joined')
            ->first();

        if ($participant) {
            $participant->update([
                'status' => 'left',
                'left_at' => now(),
            ]);

            // Add system message about participant leaving
            $this->messages()->create([
                'sender_id' => $userId,
                'message' => "👋 " . $user->name . " has left the session.",
            ]);

            return true;
        }

        return false;
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

    // Feedback helper methods
    public function canReceiveFeedback()
    {
        return $this->status === 'completed';
    }

    public function hasFeedbackFrom($userId, $feedbackType)
    {
        return $this->feedback()
            ->where('user_id', $userId)
            ->where('feedback_type', $feedbackType)
            ->exists();
    }

    public function getFeedbackFrom($userId, $feedbackType)
    {
        return $this->feedback()
            ->where('user_id', $userId)
            ->where('feedback_type', $feedbackType)
            ->first();
    }

    public function getStudentFeedback()
    {
        return $this->feedback()->studentToCounselor()->first();
    }

    public function getCounselorFeedback()
    {
        return $this->feedback()->counselorToStudent()->first();
    }
}
