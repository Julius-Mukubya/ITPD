<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'educational_content_id',
        'rating',
        'review',
        'is_helpful',
        'feedback_data',
        'is_approved',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'feedback_data' => 'array',
        'is_helpful' => 'boolean',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime'
    ];

    /**
     * Get the user who wrote the review
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the content being reviewed
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(EducationalContent::class, 'educational_content_id');
    }

    /**
     * Get the admin who approved the review
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope for approved reviews only
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for pending reviews
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Scope for reviews with specific rating
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get formatted rating display
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    /**
     * Get star display for rating
     */
    public function getStarDisplayAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '★' : '☆';
        }
        return $stars;
    }

    /**
     * Check if review has written content
     */
    public function getHasReviewTextAttribute()
    {
        return !empty(trim($this->review));
    }

    /**
     * Get truncated review text
     */
    public function getTruncatedReviewAttribute()
    {
        if (!$this->has_review_text) {
            return null;
        }
        
        return strlen($this->review) > 150 
            ? substr($this->review, 0, 150) . '...' 
            : $this->review;
    }

    /**
     * Get time ago format
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}