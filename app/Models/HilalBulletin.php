<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HilalBulletin extends Model
{
    protected $fillable = [
        'title', 'description', 'thumbnail',
        'file_path', 'external_url', 'published_at', 'is_active',
    ];

    protected $casts = ['published_at' => 'date', 'is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
