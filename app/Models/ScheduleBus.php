<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class ScheduleBus extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date'         => 'datetime',
        'time'         => 'datetime',
        'mid_counters' => 'array',

    ];

    protected $appends = ['date', 'time'];

    public function getDateAttribute()
    {
        return Carbon::parse($this->date)->addHours(6);
    }
    public function getTimeAttribute()
    {
        return Carbon::parse($this->time)->format('H');
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
