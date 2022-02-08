<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Fare extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schedule_bus()
    {
        return $this->belongsTo(ScheduleBus::class);
    }
}