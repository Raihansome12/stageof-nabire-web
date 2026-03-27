<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    protected $table = 'informasi_publik';

    protected $fillable = [
        'type',
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

    public function scopeBerita($query)
    {
        return $query->where('type', 'berita');
    }

    public function scopePengumuman($query)
    {
        return $query->where('type', 'pengumuman');
    }
}
