<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sunrise extends Model
{
    protected $fillable = [
        'location',
        'date',
        'dawn_time',
        'sunrise_time',
        'azimuth_sunrise',
        'transit_time',
        'transit_altitude',
        'sunset_time',
        'azimuth_sunset',
        'dusk_time',
    ];

    protected $casts = ['date' => 'date'];
}