<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LightningMap extends Model
{
    protected $fillable = [
        'period_id',
        'image_path',
        'source_updated_at'
    ];

    public function period()
    {
        return $this->belongsTo(LightningPeriod::class, 'period_id');
    }
}
