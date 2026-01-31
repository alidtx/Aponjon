<?php

namespace App\Services;

use App\Models\Bid;
use App\Models\Order;
use App\Models\Task;


class BidService
{
    public static function findTaskDetails($taskId, $slug)
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
            ->findOrFail($taskId);
    }
    public static function bidDetails($taskId, $slug)
    {
        return Task::select([
            'id',
            'task_number',
            'slug',
            'title',
            'description',
            'emergency',
            'budget',
            'category_id',
            'bidding_ends_at',
            'location_address',
            'created_at'
        ])->with(['category:id,name', 'bids:id,task_id,amount'])->findOrFail($taskId);
    }
    public static function store($request)
    {
        return Bid::create([
            "task_id" => $request->task_id,
            "tasker_id" => 3,
            "amount" => $request->bid_amount,
            "proposal" => $request->proposal,
            "estimated_hours" => $request->estimated_hours,
            'availability'  => $request->availability,
            'specific_date' => $request->availability === 'specific'
                ? $request->specific_date
                : null,
            "terms_accepted" => $request->terms_accepted,
        ]);
    }

    public static function paymentCompletionRate($taskId)
    {
        $task = Task::with([
            'customers.customerTasks' => function ($q) {
                $q->select('id', 'customer_id', 'status')
                    ->where('status', 'completed');
            }
        ])->where('id', $taskId)->firstOrFail();

        $customerTasks = $task->customers->customerTasks;

        $totalCompletedTasks = $customerTasks->count();

        if ($totalCompletedTasks === 0) {
            return 0;
        }

        $taskIds = $customerTasks->pluck('id');

        $paidTasksCount = Order::whereIn('task_id', $taskIds)
            ->where('payment_status', 'paid')
            ->count();

        return round(($paidTasksCount / $totalCompletedTasks) * 100, 2);
    }
}
