<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schedulesbuses()
    {
        return $this->hasMany(ScheduleBus::class);
    }
}
