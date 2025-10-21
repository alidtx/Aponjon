<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{


    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'type',
        'avatar',
        'is_verified',
        'location',
        'district_id',
        'zila_id',
        'upozila_id',
    ];

    public function districts()
    {
        return $this->belongsTo(District::class);
    }

    public function zilas()
    {
        return $this->belongsTo(zila::class);
    }

    public function upozilas()
    {

        return $this->belongsTo(Upozila::class);
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
