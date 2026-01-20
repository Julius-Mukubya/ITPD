<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bookmarkable_type',
        'bookmarkable_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookmarkable()
    {
        return $this->morphTo();
    }

    // Static Methods
    public static function toggle($userId, $bookmarkable)
    {
        $bookmark = static::where([
            'user_id' => $userId,
            'bookmarkable_type' => get_class($bookmarkable),
            'bookmarkable_id' => $bookmarkable->id,
        ])->first();

        if ($bookmark) {
            $bookmark->delete();
            return false; // Unbookmarked
        }

        static::create([
            'user_id' => $userId,
            'bookmarkable_type' => get_class($bookmarkable),
            'bookmarkable_id' => $bookmarkable->id,
        ]);

        return true; // Bookmarked
    }
}
