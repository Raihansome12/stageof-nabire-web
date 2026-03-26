<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Earthquake extends Model
{
    protected $fillable = [
        'magnitude',
        'depth_km',
        'latitude',
        'longitude',
        'location_description',
        'felt_intensity',
        'potensi',
        'occurred_at',
        'shakemap_image'
    ];

    protected $casts = ['occurred_at' => 'datetime'];
}