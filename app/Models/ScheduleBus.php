<?php

namespace App\Models;

use App\Models\CounterManager\AssignBus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class ScheduleBus extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'route'    => 'array',
        'fare'     => 'array',
        'day_time' => 'array',
    ];

    // protected $appends = ['date_time_bangladesh'];

    // public function getDateTimeBangladeshAttribute()
    // {
    //     return Carbon::parse($this->date_time)->addHours(6);
    // }

    // public function bus()
    // {
    //     return $this->belongsTo(Bus::class);
    // }

    // public function bus_by_no()
    // {
    //     return $this->belongsTo(Bus::class, 'bus_no', 'bus_no');
    // }

    // public function start_counter()
    // {
    //     return $this->belongsTo(Counter::class, "start_counter_id", "_id");
    // }
    // public function end_counter()
    // {
    //     return $this->belongsTo(Counter::class, "end_counter_id", "_id");
    // }

    public function routes()
    {
        return $this->belongsTo(District::class, "routes_id", "_id");
    }
    public function assign_buses()
    {
        return $this->hasMany(AssignBus::class, 'route_id', '_id');
    }
}