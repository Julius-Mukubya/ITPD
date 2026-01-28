<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'name',
        'title',
        'email',
        'phone',
        'office_location',
        'office_hours',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // Scopes
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('is_primary', 'desc')->orderBy('name');
    }
}