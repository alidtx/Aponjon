<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskerProfile extends Model
{   
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'district_id',
        'zila_id',
        'upozila_id',
        'bio',
        'skill',
        'hourly_rate',
        'document',
        'nid_number',
        'experience',
        'verification_status',
        'rating',
        'completed_task',
        'is_online'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function zila()
    {
        return $this->belongsTo(Zila::class);
    }

    public function upozila()
    {
        return $this->belongsTo(Upozila::class);
    }

    protected $casts = [
        'skill' => 'array',
        'document' => 'array',
        'experience' => 'array',
        'is_online' => 'boolean',
        'rating' => 'float',
        'hourly_rate' => 'float',
    ];
}