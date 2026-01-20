<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assessment_id',
        'total_score',
        'risk_level',
        'recommendation',
        'is_anonymous',
        'taken_at',
        'completed_at',
    ];

    protected $casts = [
            'is_anonymous' => 'boolean',
            'taken_at' => 'datetime',
            'total_score' => 'integer',
        ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function responses()
    {
        return $this->hasMany(AssessmentResponse::class, 'attempt_id');
    }

    // Accessors
    public function getRiskLevelColorAttribute()
    {
        switch($this->risk_level) {
            case 'low':
                return 'green';
            case 'medium':
                return 'yellow';
            case 'high':
                return 'red';
            default:
                return 'gray';
        }
    }

    public function getRiskLevelBadgeAttribute()
    {
        switch($this->risk_level) {
            case 'low':
                return 'Low Risk';
            case 'medium':
                return 'Medium Risk';
            case 'high':
                return 'High Risk';
            default:
                return 'Unknown';
        }
    }
}
