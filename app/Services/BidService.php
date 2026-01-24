<?php

namespace App\Services;

use App\Models\Task;


class BidService
{
    public static function findTaskDetails($id, $slug)
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
            'bidding_ends_at',
            'location_address',
            'location_coordinates',
            'created_at'
        ])
            ->with([
                'category:id,name',
                'customers' => function ($query) {
                    $query->select('id', 'name')
                        ->with([
                            'customerTasks' => function ($q) {
                                $q->select(
                                    'id',
                                    'customer_id',
                                    'status',
                                   )
                                    ->latest();
                            }
                        ]);
                },

                'bids' => function ($query) {
                    $query->select([
                        'id',
                        'task_id',
                        'tasker_id',
                        'amount',
                        'proposal',
                        'status',
                        'created_at'
                    ])
                        ->latest()
                        ->take(5);
                },
                'bids.tasker:id,name,avatar',
                'districts:id,name',
                'zilas:id,name',
                'upozilas:id,name',
            ])
            ->findOrFail($id);
    }
}
