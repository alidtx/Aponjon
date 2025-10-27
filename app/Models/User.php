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

    public function taskerProfiles()
    {
        return $this->hasMany(TaskerProfile::class);
    }

    public function customerTasks()
    {
        return $this->hasMany(Task::class, 'customer_id');
    }

    public function taskerTasks()
    {
        return $this->hasMany(Task::class, 'tasker_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'tasker_id');
    }

    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeTaskers($query)
    {
        return $query->where('role', 'tasker');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function isCustomer()
    {

        return $this->role === 'customer';
    }
    public function isTasker()
    {

        return $this->role === 'tasker';
    }

    public function isAdmin()
    {

        return $this->role === 'admin';
    }

    public function isVerified()
    {

        return $this->is_verified === true;
    }

    public function getFullAddressAttribute(): string
    {
        $parts = [];

        if ($this->upozila) {
            $parts[] = $this->upozila->name;
        }

        if ($this->zila) {
            $parts[] = $this->zila->name;
        }

        if ($this->district) {
            $parts[] = $this->district->name;
        }

        return implode(', ', $parts) ?: 'Address not set';
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
