<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = [
        'type', 'title', 'description', 'thumbnail',
        'file_path', 'external_url', 'published_at', 'is_active'
    ];

    protected $casts = ['published_at' => 'date', 'is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBuletin($query)
    {
        return $query->where('type', 'buletin');
    }

    public function scopeBerita($query)
    {
        return $query->where('type', 'berita');
    }
}