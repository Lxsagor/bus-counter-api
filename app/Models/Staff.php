<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'docs' => 'array',
    ];

    public function assignBuses()
    {
        return $this->hasMany(AssignBus::class);
    }
}