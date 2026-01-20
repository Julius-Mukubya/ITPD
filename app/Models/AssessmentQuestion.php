<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'question',
        'options',
        'order',
    ];

    protected $casts = [
            'options' => 'array',
            'order' => 'integer',
        ];

    // Relationships
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function responses()
    {
        return $this->hasMany(AssessmentResponse::class, 'question_id');
    }
}
