<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zila extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'district_id'];

    public function districts()
    {
        return $this->belongsTo(District::class);
    }

    public function upozilas()
    {

        return $this->hasMany(Upozila::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }



}
