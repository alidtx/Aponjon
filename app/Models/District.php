<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug'];

    public function zilas()
    {
        return $this->hasMany(Zila::class, 'district_id');
    }

    public function upozilas()
    {
        return $this->hasManyThrough(Upozila::class, Zila::class);
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