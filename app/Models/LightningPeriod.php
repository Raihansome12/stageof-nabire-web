<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LightningPeriod extends Model
{
    protected $fillable = [
        'year',
        'month',
        'type',
        'label',
        'start_date',
        'end_date'
    ];

    public function map()
    {
        return $this->hasOne(LightningMap::class, 'period_id');
    }

    public function subdistrictStats()
    {
        return $this->hasMany(LightningSubdistrictStat::class, 'period_id');
    }

    public function densities()
    {
        return $this->hasMany(LightningDensityDaily::class, 'period_id');
    }
}