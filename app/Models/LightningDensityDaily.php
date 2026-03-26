<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LightningDensityDaily extends Model
{
    protected $table = 'lightning_density_daily';

    protected $fillable = [
        'period_id',
        'date',
        'total_density'
    ];

    public function period()
    {
        return $this->belongsTo(LightningPeriod::class, 'period_id');
    }
}
