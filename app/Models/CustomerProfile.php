<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function media()
    {
        return $this->morphMany(Media::class, 'fileable');
    }
}
