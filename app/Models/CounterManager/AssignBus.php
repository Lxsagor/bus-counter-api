<?php

namespace App\Models\CounterManager;

use App\Models\Bus;
use App\Models\District;
use App\Models\Driver;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class AssignBus extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function journey_start()
    {
        return $this->belongsTo(District::class, "journey_start_id", "_id");
    }
    public function journey_end()
    {
        return $this->belongsTo(District::class, "journey_end_id", "_id");
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class, "driver_id", "_id");
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, "staff_id", "_id");
    }

    public function bus_by_no()
    {
        return $this->belongsTo(Bus::class, "bus_no", "bus_no");
    }

    public function schedule_bus()
    {
        return $this->belongsTo(ScheduleBus::class, "route_id", "_id");
    }
    public function ticket_books()
    {
        return $this->hasMany(TicketBook::class, 'coach_id', '_id');
    }
}