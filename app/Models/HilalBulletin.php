<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HilalBulletin extends Model
{
    protected $fillable = [
        'title', 'description', 'thumbnail', 'image_2', 'image_3',
        'file_path', 'external_url', 'published_at', 'is_active',
    ];

    protected $casts = ['published_at' => 'date', 'is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Gallery images only (image_2 + image_3), in order, skipping any
     * that are empty. Used by the "Informasi Hilal" tab carousel on the
     * public site (Box 1). NOTE: `thumbnail` is intentionally excluded —
     * it's the dedicated PDF cover shown in Box 2, not a gallery photo.
     */
    public function getImagesAttribute(): array
    {
        return collect([$this->image_2, $this->image_3])
            ->filter()
            ->values()
            ->toArray();
    }
}
