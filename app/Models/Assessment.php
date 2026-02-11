<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'full_name',
        'description',
        'card_image',
        'type',
        'scoring_guidelines',
        'is_active',
    ];

    protected $casts = [
            'scoring_guidelines' => 'array',
            'is_active' => 'boolean',
        ];

    // Relationships
    public function questions()
    {
        return $this->hasMany(AssessmentQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(AssessmentAttempt::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Methods
    public function calculateRiskLevel($totalScore)
    {
        $guidelines = $this->scoring_guidelines;
        
        // Handle new format with ranges
        if (isset($guidelines['ranges']) && is_array($guidelines['ranges'])) {
            foreach ($guidelines['ranges'] as $range) {
                if ($totalScore >= $range['min'] && $totalScore <= $range['max']) {
                    // Map level names to risk levels
                    $level = strtolower($range['level']);
                    if (in_array($level, ['severe', 'high'])) {
                        return 'high';
                    } elseif (in_array($level, ['moderate', 'medium'])) {
                        return 'medium';
                    } elseif (in_array($level, ['mild'])) {
                        return 'medium';
                    } else {
                        return 'low';
                    }
                }
            }
            return 'low';
        }
        
        // Handle old format with thresholds (backward compatibility)
        if (isset($guidelines['high_risk_threshold']) && $totalScore >= $guidelines['high_risk_threshold']) {
            return 'high';
        } elseif (isset($guidelines['medium_risk_threshold']) && $totalScore >= $guidelines['medium_risk_threshold']) {
            return 'medium';
        }
        
        return 'low';
    }
    
    public function getInterpretation($totalScore)
    {
        $guidelines = $this->scoring_guidelines;
        
        if (isset($guidelines['ranges']) && is_array($guidelines['ranges'])) {
            foreach ($guidelines['ranges'] as $range) {
                if ($totalScore >= $range['min'] && $totalScore <= $range['max']) {
                    return [
                        'level' => $range['level'],
                        'interpretation' => $range['interpretation']
                    ];
                }
            }
        }
        
        return [
            'level' => 'Unknown',
            'interpretation' => 'Unable to determine risk level.'
        ];
    }

    // Accessor for card image URL
    public function getCardImageUrlAttribute()
    {
        if ($this->card_image) {
            return asset('storage/' . $this->card_image);
        }
        return null;
    }
}
