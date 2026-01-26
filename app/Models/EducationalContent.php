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
        // Always get fresh data from database, don't use cached relationships
        // Use a fresh query to ensure we get the latest data
        return ContentReview::where('educational_content_id', $this->id)
            ->where('is_approved', true)
            ->avg('rating') ?: 0;
    }

    public function getFormattedAverageRatingAttribute()
    {
        return number_format($this->average_rating, 1);
    }

    public function getTotalReviewsAttribute()
    {
        // Always get fresh data from database, don't use cached relationships
        return ContentReview::where('educational_content_id', $this->id)
            ->where('is_approved', true)
            ->count();
    }

    public function getRatingDistributionAttribute()
    {
        $distribution = [];
        $totalReviews = $this->total_reviews;
        
        for ($i = 1; $i <= 5; $i++) {
            // Always get fresh data from database using direct query
            $count = ContentReview::where('educational_content_id', $this->id)
                ->where('is_approved', true)
                ->where('rating', $i)
                ->count();
            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
            $distribution[$i] = [
                'count' => $count,
                'percentage' => round($percentage, 1)
            ];
        }
        return $distribution;
    }

    public function getHelpfulPercentageAttribute()
    {
        // Always get fresh data from database using direct queries
        $totalFeedback = ContentReview::where('educational_content_id', $this->id)
            ->where('is_approved', true)
            ->whereNotNull('is_helpful')
            ->count();
        
        if ($totalFeedback === 0) return 0;
        
        $helpfulCount = ContentReview::where('educational_content_id', $this->id)
            ->where('is_approved', true)
            ->where('is_helpful', true)
            ->count();
            
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
        
        // Also clear the appends cache if it exists
        if (property_exists($this, 'accessorCache')) {
            $this->accessorCache = [];
        }
        
        return $this;
    }
}
