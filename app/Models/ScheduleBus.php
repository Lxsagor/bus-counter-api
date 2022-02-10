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
        'date_time'    => 'datetime',
        'mid_counters' => 'array',
    ];

    protected $appends = ['date_time_bangladesh'];

    public function getDateTimeBangladeshAttribute()
    {
        return Carbon::parse($this->date_time)->addHours(6);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
    public function start_counter()
    {
        return $this->belongsTo(Counter::class, "start_counter_id", "_id");
    }
    public function end_counter()
    {
        return $this->belongsTo(Counter::class, "end_counter_id", "_id");
    }
    public function mid_counters()
    {
        return $this->belongsTo(Counter::class, "mid_counters_id", "_id");
    }
    public function fares()
    {
        return $this->hasMany(Fare::class);
    }
}