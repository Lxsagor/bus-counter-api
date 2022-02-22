<?php

namespace App\Models;

use App\Models\CounterManager\AssignBus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Track extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'districts' => 'array',
        'day_time'  => 'array',
    ];
    public function districts()
    {
        return $this->belongsTo(Counter::class, "route", "_id");
    }
    public function assign_buses()
    {
        return $this->hasMany(AssignBus::class);
    }
}