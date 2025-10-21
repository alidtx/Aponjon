<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upozila extends Model
{
    use HasFactory;
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
