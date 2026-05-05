<?php

namespace App\Http\Controllers\Customer;

use App\Enum\BidStatus;
use App\Enum\PaginationLimits;
use App\Enum\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\BidResource;
use App\Http\Resources\TaskResource;
use App\Models\Bid;
use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CustomerBidController extends Controller
{
   
public function index() {
   return Inertia::render('Customer/Bid/Index');
}
public function waitingForAcceptance(Request $request)
{   
   $perPage = $request->integer('per_page', PaginationLimits::PER_PAGE_FIVE->value);
    $perPage = max(1, min(100, $perPage));

    $customerId = auth()->id();

    $bids = Bid::query()
        ->select([
            'id',
            'task_id',
            'tasker_id',
            'amount',
            'proposal',
            'estimated_hours',
            'availability',
            'status',
            'created_at'
        ])
        ->where('status', BidStatus::Pending->value)

        ->whereHas('task', function ($q) use ($customerId) {
            $q->where('customer_id', $customerId);
        })

        ->with([
            'task:id,title,budget',
            'tasker:id,name',
            'tasker.taskerProfiles:id,user_id,district_id,zila_id,upozila_id'
        ])

        ->latest()
        ->paginate($perPage);

    return BidResource::collection($bids);
}

public function inProgress()
{
    $bids = Bid::query()
        ->where('status', BidStatus::Accepted->value)

        ->whereHas('task', function ($q) {
            $q->where('customer_id', auth()->id());
        })

        ->with([
            'task:id,title,task_number,customer_id,category_id,status,budget',
            'task.category:id,name',
            'task.customers:id,name,email,phone',
            'tasker:id,name,email,phone,avatar'
        ])
        ->latest()
        ->paginate(10);

    return BidResource::collection($bids);
}
public function completed()
{
    $customerId = auth()->id();

    $tasks = Task::query()
        ->select([
            'id',
            'task_number',
            'title',
            'slug',
            'budget',
            'status',
            'customer_id',
            'category_id',
            'created_at',
            'updated_at'
        ])
        ->where('customer_id', $customerId)
        ->where('status', TaskStatus::Completed->value)

        ->with([
            'category:id,name',

            'bids' => function ($q) {
                $q->where('status', 'accepted')
                  ->select([
                      'id',
                      'task_id',
                      'tasker_id',
                      'amount',
                      'status'
                  ])
                  ->with('tasker:id,name,email,phone,avatar');
            },

            'customers:id,name,email,phone'
        ])

        ->latest()
        ->paginate(10);

    return TaskResource::collection($tasks);
}

}
