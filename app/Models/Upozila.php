<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upozila extends Model
{

    protected $fillable = ['name', 'slug', 'zila_id'];
    public function zilas()
    {

        return $this->belongsTo(Zila::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
