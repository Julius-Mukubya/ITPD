<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ContentFlag extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flaggable_type',
        'flaggable_id',
        'reason',
        'description',
        'status',
        'reviewed_by',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the flagged content (polymorphic relationship)
     */
    public function flaggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who flagged the content
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who reviewed the flag
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope for pending flags
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for reviewed flags
     */
    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    /**
     * Get human-readable reason
     */
    public function getReasonLabelAttribute(): string
    {
        return match($this->reason) {
            'inappropriate_content' => 'Inappropriate Content',
            'harassment' => 'Harassment',
            'spam' => 'Spam',
            'misinformation' => 'Misinformation',
            'hate_speech' => 'Hate Speech',
            'violence' => 'Violence',
            'self_harm' => 'Self Harm',
            'other' => 'Other',
            default => 'Unknown'
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'reviewed' => 'blue',
            'dismissed' => 'gray',
            'action_taken' => 'green',
            default => 'gray'
        };
    }

    /**
     * Get human-readable status
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending Review',
            'reviewed' => 'Reviewed',
            'dismissed' => 'Dismissed',
            'action_taken' => 'Action Taken',
            default => 'Unknown'
        };
    }
}