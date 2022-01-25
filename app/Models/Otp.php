<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const FORGET   = 1;
    public const REGISTER = 2;
}
