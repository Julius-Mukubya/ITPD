<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'comment',
        'is_anonymous',
        'is_reported',
        'upvotes',
    ];

    protected $casts = [
            'is_anonymous' => 'boolean',
            'is_reported' => 'boolean',
            'upvotes' => 'integer',
        ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ForumComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ForumComment::class, 'parent_id')->orderBy('created_at');
    }

    public function upvoteRecords()
    {
        return $this->morphMany(ForumUpvote::class, 'votable');
    }

    public function flags()
    {
        return $this->morphMany(ContentFlag::class, 'flaggable');
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

    public function getAuthorNameAttribute()
    {
        return $this->is_anonymous ? 'Anonymous' : $this->user->name;
    }
}
