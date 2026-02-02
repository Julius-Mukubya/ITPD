<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'content',
        'is_anonymous',
        'is_pinned',
        'is_locked',
        'is_reported',
        'views',
        'upvotes',
    ];

    protected $casts = [
            'is_anonymous' => 'boolean',
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean',
            'is_reported' => 'boolean',
            'views' => 'integer',
            'upvotes' => 'integer',
        ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'post_id')->whereNull('parent_id')->orderBy('created_at');
    }

    public function allComments()
    {
        return $this->hasMany(ForumComment::class, 'post_id');
    }

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function upvoteRecords()
    {
        return $this->morphMany(ForumUpvote::class, 'votable');
    }

    public function flags()
    {
        return $this->morphMany(ContentFlag::class, 'flaggable');
    }

    // Scopes
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeNotLocked($query)
    {
        return $query->where('is_locked', false);
    }

    // Methods
    public function isFlaggedBy($userId)
    {
        return $this->flags()->where('user_id', $userId)->exists();
    }

    public function getFlagsCountAttribute()
    {
        return $this->flags()->count();
    }

    public function getPendingFlagsCountAttribute()
    {
        return $this->flags()->pending()->count();
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isUpvotedBy($userId)
    {
        return $this->upvoteRecords()->where('user_id', $userId)->exists();
    }

    public function toggleUpvote($userId)
    {
        if ($this->isUpvotedBy($userId)) {
            $this->upvoteRecords()->where('user_id', $userId)->delete();
            $this->decrement('upvotes');
        } else {
            $this->upvoteRecords()->create(['user_id' => $userId]);
            $this->increment('upvotes');
        }
    }

    public function commentsCount()
    {
        return $this->allComments()->count();
    }

    public function getAuthorNameAttribute()
    {
        return $this->is_anonymous ? 'Anonymous' : $this->user->name;
    }
}
