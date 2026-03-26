<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LightningSubdistrictStat extends Model
{
    protected $fillable = [
        'period_id',
        'subdistrict',
        'total_strikes'
    ];

    public function period()
    {
        return $this->belongsTo(LightningPeriod::class, 'period_id');
    }
}
