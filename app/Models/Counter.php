<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        // 'go_through' => 'array',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function counter_managers()
    {
        return $this->hasMany(User::class);
    }

    public function schedulesbuses()
    {
        return $this->hasMany(ScheduleBus::class);
    }
}
