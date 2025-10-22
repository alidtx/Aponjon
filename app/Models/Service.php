<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{   
    use HasFactory;
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

    protected $casts = [
    'requirements' => 'array',  
    'is_active' => 'boolean',   
    'base_price' => 'float',   
    'estimated_duration' => 'integer', 
   ];

   
}
