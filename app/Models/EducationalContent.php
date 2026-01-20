<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'created_by',
        'title',
        'description',
        'content',
        'type',
        'featured_image',
        'video_url',
        'file_path',
        'views',
        'reading_time',
        'is_published',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'views' => 'integer',
            'reading_time' => 'integer',
        ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contentViews()
    {
        return $this->hasMany(ContentView::class, 'content_id');
    }

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function reviews()
    {
        return $this->hasMany(ContentReview::class, 'educational_content_id');
    }

    public function approvedReviews()
    {
        return $this->hasMany(ContentReview::class, 'educational_content_id')->approved();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isBookmarkedBy($userId)
    {
        return $this->bookmarks()->where('user_id', $userId)->exists();
    }

    public function hasReviewBy($userId)
    {
        return $this->reviews()->where('user_id', $userId)->exists();
    }

    public function getReviewBy($userId)
    {
        return $this->reviews()->where('user_id', $userId)->first();
    }

    public function getAverageRatingAttribute()
    {
        // Clear any cached relationships to ensure fresh data
        $this->unsetRelation('approvedReviews');
        return $this->approvedReviews()->avg('rating') ?: 0;
    }

    public function getFormattedAverageRatingAttribute()
    {
        return number_format($this->average_rating, 1);
    }

    public function getTotalReviewsAttribute()
    {
        // Clear any cached relationships to ensure fresh data
        $this->unsetRelation('approvedReviews');
        return $this->approvedReviews()->count();
    }

    public function getRatingDistributionAttribute()
    {
        // Clear any cached relationships to ensure fresh data
        $this->unsetRelation('approvedReviews');
        
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $this->approvedReviews()->where('rating', $i)->count();
            $percentage = $this->total_reviews > 0 ? ($count / $this->total_reviews) * 100 : 0;
            $distribution[$i] = [
                'count' => $count,
                'percentage' => round($percentage, 1)
            ];
        }
        return $distribution;
    }

    public function getHelpfulPercentageAttribute()
    {
        // Clear any cached relationships to ensure fresh data
        $this->unsetRelation('approvedReviews');
        
        $totalFeedback = $this->approvedReviews()->whereNotNull('is_helpful')->count();
        if ($totalFeedback === 0) return 0;
        
        $helpfulCount = $this->approvedReviews()->where('is_helpful', true)->count();
        return round(($helpfulCount / $totalFeedback) * 100, 1);
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image 
            ? asset('storage/' . $this->featured_image) 
            : asset('images/default-content.png');
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    /**
     * Clear cached review-related attributes
     */
    public function clearReviewCache()
    {
        $this->unsetRelation('approvedReviews');
        $this->unsetRelation('reviews');
        
        // Clear any cached attributes
        $cachedAttributes = ['average_rating', 'formatted_average_rating', 'total_reviews', 'rating_distribution', 'helpful_percentage'];
        foreach ($cachedAttributes as $attribute) {
            unset($this->attributes[$attribute]);
        }
        
        return $this;
    }
}
