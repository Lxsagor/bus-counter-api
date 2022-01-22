<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class ScheduleBus extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date_time'    => 'datetime',
        'mid_counters' => 'array',
    ];

    // protected $appends = ['date_time'];

    // public function getDateTimeAttribute()
    // {
    //     return Carbon::parse($this->date)->addHours(6);
    // }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
