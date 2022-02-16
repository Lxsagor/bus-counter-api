<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Track extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'day_time' => 'datetime',
        'route'    => 'array',
    ];
    public function districts()
    {
        return $this->belongsTo(Counter::class, "route", "_id");
    }
}