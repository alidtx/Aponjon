<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class CustomerProfile extends Model
{
      protected $fillable = [
        'user_id',
        'district_id',
        'zila_id',
        'upozila_id',
        'nid_number',
        'rating',
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

}
