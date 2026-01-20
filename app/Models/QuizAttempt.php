<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'correct_answers',
        'total_points',
        'earned_points',
        'passed',
        'started_at',
        'completed_at',
        'time_taken',
    ];

    protected $casts = [
            'score' => 'decimal:2',
            'passed' => 'boolean',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'total_questions' => 'integer',
            'correct_answers' => 'integer',
            'total_points' => 'integer',
            'earned_points' => 'integer',
            'time_taken' => 'integer',
        ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'attempt_id');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    public function scopePassed($query)
    {
        return $query->where('passed', true);
    }

    // Methods
    public function isCompleted()
    {
        return !is_null($this->completed_at);
    }

    public function getScorePercentageAttribute()
    {
        return $this->score;
    }

    public function getStatusBadgeAttribute()
    {
        if (!$this->isCompleted()) {
            return ['text' => 'In Progress', 'color' => 'blue'];
        }

        return $this->passed 
            ? ['text' => 'Passed', 'color' => 'green']
            : ['text' => 'Failed', 'color' => 'red'];
    }

    public function getFormattedTimeAttribute()
    {
        if (!$this->time_taken) return 'N/A';
        
        $minutes = floor($this->time_taken / 60);
        $seconds = $this->time_taken % 60;
        
        return "{$minutes}m {$seconds}s";
    }
}
