<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'content_id',
        'user_id',
        'ip_address',
        'user_agent',
        'viewed_at',
    ];

    protected $casts = [
            'viewed_at' => 'datetime',
        ];

    // Relationships
    public function content()
    {
        return $this->belongsTo(EducationalContent::class, 'content_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
