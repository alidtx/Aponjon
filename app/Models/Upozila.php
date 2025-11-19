<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upozila extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug', 'zila_id'];

    public function zila()
    {
        return $this->belongsTo(Zila::class);
    }


    public function district()
    {
        return $this->hasOneThrough(District::class, Zila::class, 'id', 'id', 'zila_id', 'district_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}