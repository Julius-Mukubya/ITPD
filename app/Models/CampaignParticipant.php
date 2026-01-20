<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'student_id',
        'year_of_study',
        'course',
        'motivation',
        'is_guest_registration',
        'status',
        'registered_at',
        'attended_at',
        'feedback',
        'rating',
    ];

    protected $casts = [
            'registered_at' => 'datetime',
            'attended_at' => 'datetime',
            'rating' => 'integer',
            'is_guest_registration' => 'boolean',
        ];

    // Relationships
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }

    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    // Methods
    public function markAsAttended()
    {
        $this->update([
            'status' => 'attended',
            'attended_at' => now(),
        ]);
    }

    public function getDisplayNameAttribute()
    {
        if ($this->is_guest_registration) {
            return $this->guest_name;
        }
        
        return $this->user ? $this->user->name : 'Unknown';
    }

    public function getDisplayEmailAttribute()
    {
        if ($this->is_guest_registration) {
            return $this->guest_email;
        }
        
        return $this->user ? $this->user->email : null;
    }
}
