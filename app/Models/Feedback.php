<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'subject',
        'message',
        'rating',
        'is_anonymous',
        'status',
        'admin_response',
        'responded_at',
    ];

    protected $casts = [
            'is_anonymous' => 'boolean',
            'rating' => 'integer',
            'responded_at' => 'datetime',
        ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    // Methods
    public function getTypeBadgeAttribute()
    {
        switch($this->type) {
            case 'suggestion':
                return ['text' => 'Suggestion', 'color' => 'blue'];
            case 'complaint':
                return ['text' => 'Complaint', 'color' => 'red'];
            case 'compliment':
                return ['text' => 'Compliment', 'color' => 'green'];
            case 'bug_report':
                return ['text' => 'Bug Report', 'color' => 'orange'];
            default:
                return ['text' => 'Unknown', 'color' => 'gray'];
        }
    }

    public function getSubmitterNameAttribute()
    {
        return $this->is_anonymous ? 'Anonymous' : ($this->user ? $this->user->name : 'Unknown');
    }
}
