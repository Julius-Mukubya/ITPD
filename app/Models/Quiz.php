<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'created_by',
        'title',
        'description',
        'duration_minutes',
        'passing_score',
        'difficulty',
        'is_active',
        'shuffle_questions',
        'show_correct_answers',
        'max_attempts',
    ];

    protected $casts = [
            'is_active' => 'boolean',
            'shuffle_questions' => 'boolean',
            'show_correct_answers' => 'boolean',
            'duration_minutes' => 'integer',
            'passing_score' => 'integer',
            'max_attempts' => 'integer',
        ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    // Methods
    public function canUserAttempt($userId)
    {
        if (!$this->max_attempts) {
            return true;
        }

        $userAttempts = $this->attempts()->where('user_id', $userId)->count();
        return $userAttempts < $this->max_attempts;
    }

    public function getUserAttemptsCount($userId)
    {
        return $this->attempts()->where('user_id', $userId)->count();
    }

    public function getDifficultyBadgeAttribute()
    {
        switch($this->difficulty) {
            case 'easy':
                return ['text' => 'Easy', 'color' => 'green'];
            case 'medium':
                return ['text' => 'Medium', 'color' => 'yellow'];
            case 'hard':
                return ['text' => 'Hard', 'color' => 'red'];
            default:
                return ['text' => 'Unknown', 'color' => 'gray'];
        }
    }
}
