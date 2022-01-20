<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
