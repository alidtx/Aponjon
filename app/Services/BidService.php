<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;

class BidService
{
    public static function findTaskDetails($slug)
    {
      return Task::select([
            'id',
            'slug',
            'title',
            'description',
            'emergency', 
            'budget',
            'category_id',
            'customer_id',
            'district_id',
            'zila_id',
            'upozila_id',
            'created_at'
        ])
            ->with([
                'category:id,name',
                'customers:id,name',
                'bids:id,task_id,tasker_id,amount',
                'districts:id,name',
                'zilas:id,name',
                'upozilas:id,name',
            ])
            ->whereSlug($slug)
            ->firstOrFail();
    }
}
