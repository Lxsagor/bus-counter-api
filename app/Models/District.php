<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
    public function assignBuses()
    {
        return $this->hasMany(AssignBus::class);
    }
    public function schedulesbuses()
    {
        return $this->hasMany(ScheduleBus::class);
    }

}