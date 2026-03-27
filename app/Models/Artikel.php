<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = [
        'title',
        'description',
        'photo',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'published_at' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
