<?php

namespace App\Models\CounterManager;

use App\Models\CounterManager\AssignBus;
// use Illuminate\Database\Eloquent\Model;
use App\Models\ScheduleBus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class TicketBook extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'seat_no' => 'array',
    ];

    public function schedule_bus()
    {
        return $this->belongsTo(ScheduleBus::class, "route_id", "_id");
    }
    public function assign_bus()
    {
        return $this->belongsTo(AssignBus::class, "coach_id", "_id");
    }
}