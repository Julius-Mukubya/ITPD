<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'organization',
        'phone',
        'email',
        'description',
        'address',
        'type',
        'is_24_7',
        'is_active',
        'order',
    ];

    protected $casts = [
            'is_24_7' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scope247($query)
    {
        return $query->where('is_24_7', true);
    }

    // Methods
    public function getTypeBadgeAttribute()
    {
        switch($this->type) {
            case 'hotline':
                return ['text' => 'Hotline', 'color' => 'red'];
            case 'hospital':
                return ['text' => 'Hospital', 'color' => 'blue'];
            case 'counseling':
                return ['text' => 'Counseling', 'color' => 'green'];
            case 'police':
                return ['text' => 'Police', 'color' => 'purple'];
            case 'other':
                return ['text' => 'Other', 'color' => 'gray'];
            default:
                return ['text' => 'Unknown', 'color' => 'gray'];
        }
    }
}
