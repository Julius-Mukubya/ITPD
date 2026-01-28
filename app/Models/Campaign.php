<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'created_by',
        'title',
        'description',
        'content',
        'banner_image',
        'type',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'location',
        'max_participants',
        'contact_email',
        'contact_phone',
        'contact_office',
        'contact_hours',
        'status',
        'is_featured',
    ];

    protected $casts = [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'is_featured' => 'boolean',
            'max_participants' => 'integer',
        ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(CampaignParticipant::class);
    }

    public function contacts()
    {
        return $this->hasMany(CampaignContact::class)->ordered();
    }

    public function primaryContact()
    {
        return $this->hasOne(CampaignContact::class)->where('is_primary', true);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Methods
    public function isFull()
    {
        if (!$this->max_participants) {
            return false;
        }

        return $this->participants()->where('status', 'registered')->count() >= $this->max_participants;
    }

    public function isUserRegistered($userId)
    {
        return $this->participants()->where('user_id', $userId)->exists();
    }

    public function isEmailRegistered($email)
    {
        return $this->participants()
            ->where('is_guest_registration', true)
            ->where('guest_email', $email)
            ->exists();
    }

    public function participantsCount()
    {
        return $this->participants()->where('status', 'registered')->count();
    }

    public function attendedCount()
    {
        return $this->participants()->where('status', 'attended')->count();
    }

    public function getStatusBadgeAttribute()
    {
        switch($this->status) {
            case 'draft':
                return ['text' => 'Draft', 'color' => 'gray'];
            case 'active':
                return ['text' => 'Active', 'color' => 'green'];
            case 'completed':
                return ['text' => 'Completed', 'color' => 'blue'];
            case 'cancelled':
                return ['text' => 'Cancelled', 'color' => 'red'];
            default:
                return ['text' => 'Unknown', 'color' => 'gray'];
        }
    }

    public function getBannerUrlAttribute()
    {
        return $this->banner_image 
            ? asset('storage/' . $this->banner_image) 
            : asset('images/default-campaign.png');
    }

    public function getStartDateTimeAttribute()
    {
        return $this->start_date->format('Y-m-d') . ' ' . ($this->start_time ?? '00:00:00');
    }

    public function getEndDateTimeAttribute()
    {
        return $this->end_date->format('Y-m-d') . ' ' . ($this->end_time ?? '23:59:59');
    }


}
