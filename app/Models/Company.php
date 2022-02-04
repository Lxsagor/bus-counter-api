<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected $casts = [
        'sub_start_date' => 'datetime',
        'sub_end_date'   => 'datetime',
    ];

    protected $appends = ['sub_start_date_bangladesh', 'sub_end_date_bangladesh', 'sub_remaining'];

    public function getSubStartDateBangladeshAttribute()
    {
        return Carbon::parse($this->sub_start_date)->addHours(6);
    }

    public function getSubEndDateBangladeshAttribute()
    {
        return Carbon::parse($this->sub_end_date)->addHours(6);
    }
    public function getSubRemainingAttribute()
    {

        $today        = Carbon::now();
        $sub_end_date = Carbon::parse($this->sub_end_date);
        $remaining    = $today->diffInDays($sub_end_date, false);
        return $remaining;
    }
}