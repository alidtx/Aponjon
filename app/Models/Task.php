<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'emergency',
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

    public function bids() {
        return $this->hasMany(Bid::class, 'task_id');
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

    public function order()
    {

        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
