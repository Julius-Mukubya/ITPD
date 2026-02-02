<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionFeedback extends Model
{
    use HasFactory;

    protected $table = 'session_feedback';

    protected $fillable = [
        'counseling_session_id',
        'user_id',
        'feedback_type',
        'rating',
        'feedback_text',
        'is_anonymous',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'rating' => 'integer',
    ];

    // Relationships
    public function session()
    {
        return $this->belongsTo(CounselingSession::class, 'counseling_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeStudentToCounselor($query)
    {
        return $query->where('feedback_type', 'student_to_counselor');
    }

    public function scopeCounselorToStudent($query)
    {
        return $query->where('feedback_type', 'counselor_to_student');
    }

    // Helper methods
    public function isFromStudent()
    {
        return $this->feedback_type === 'student_to_counselor';
    }

    public function isFromCounselor()
    {
        return $this->feedback_type === 'counselor_to_student';
    }

    public function getAuthorNameAttribute()
    {
        if ($this->is_anonymous) {
            return $this->isFromStudent() ? 'Anonymous Student' : 'Anonymous Counselor';
        }
        
        return $this->user->name;
    }

    public function getRatingStarsAttribute()
    {
        if (!$this->rating) {
            return null;
        }

        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '★' : '☆';
        }
        return $stars;
    }
}