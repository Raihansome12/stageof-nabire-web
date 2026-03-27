<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'nip',
        'photo',
        'role',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeKepala($query)
    {
        return $query->where('role', 'kepala');
    }

    public function scopeFungsional($query)
    {
        return $query->where('role', 'fungsional');
    }
}
