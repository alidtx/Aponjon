<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'skill',
        'daily_rate',
        'document',
        'verification_status',
        'rating',
        'completed_task',
        'is_online'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $casts = [
        'skill' => 'array',
        'document' => 'array',
        'is_online' => 'boolean',
        'rating' => 'float',
        'daily_rate' => 'float',
    ];




}
