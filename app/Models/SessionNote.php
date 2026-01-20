<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'counselor_id',
        'title',
        'content',
        'type',
        'is_private',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(CounselingSession::class, 'session_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }
}
