<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public const SUPER_ADMIN     = 1;
    public const ADMIN           = 2;
    public const COUNTER_MANAGER = 3;
    public const USER            = 4;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['added_on'];

    public function getAddedOnAttribute()
    {
        return Carbon::parse($this->created_at)->format('d/m/Y h:m:i');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function counter()
    {
        return $this->belongsTo(User::class);
    }
}
