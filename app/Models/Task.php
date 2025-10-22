<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{ 
    use HasFactory;
    protected $fillable = [
        'task_number',
        'customer_id',
        'service_id',
        'tasker_id',
        'title',
        'description',
        'location_address',
        'location_coordinates',  // string or point handled with package
        'district_id',
        'zila_id',
        'upozila_id',
        'scheduled_for',
        'budget',
        'status',
        'customer_notes',
    ];

    public function customers()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function taskers()
    {
        return $this->belongsTo(User::class, 'tasker_id');
    }

    public function services()
    {
        return $this->belongsTo(Service::class);
    }

    public function districts()
    {
        return $this->belongsTo(District::class);
    }

    public function zilas()
    {
        return $this->belongsTo(Zila::class);
    }

    public function upozilas()
    {
        return $this->belongsTo(Upozila::class);
    }


}
