<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Fare extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function start_point()
    {
        return $this->belongsTo(District::class, "starting_district_id", "_id");
    }

    public function destination_point()
    {
        return $this->belongsTo(District::class, "destination_district_id", "_id");
    }

}