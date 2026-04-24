<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
    public function media()
    {
        return $this->morphMany(Media::class, 'fileable');
    }
    public function userProfilePicture(): Attribute
    {
        return new Attribute(
            get: fn () => $this->userProfilePhoto ? $this->userProfilePhoto->path : ''
        );
    }

    public function userProfilePhoto(): MorphOne
    {
        return $this->morphOne(Media::class, 'fileable')->where('name', 'Person Image')->latest();
    }

    protected $casts = [
        'skill' => 'array',
        'experience' => 'integer',
        'is_online' => 'boolean',
        'rating' => 'float',
        'hourly_rate' => 'float',
    ];
}