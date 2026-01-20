<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];

    // Relationships
    public function contents()
    {
        return $this->hasMany(EducationalContent::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    // Accessors & Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
