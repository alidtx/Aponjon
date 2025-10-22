<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'base_price',
        'duration_unit',
        'estimated_duration',
        'requirements',
        'is_active'
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
