<?php

namespace App\Http\Controllers\Payments;

use App\Enum\BidStatus;
use App\Enum\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\BidResource;
use App\Models\Bid;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentsController extends Controller
{
    public function index()
    {  
        $customerPayableBids = Bid::query()
            ->where('status', BidStatus::Accepted->value)

            ->whereHas('task', function ($q) {
                $q->where('customer_id', auth()->id());
                $q->where('status', TaskStatus::Completed->value);
            })

            ->with([
                'task:id,title,budget,status,task_number,customer_notes',
                'tasker:id,name',
                'tasker.taskerProfiles:id,user_id,district_id,zila_id,upozila_id'
            ])
            ->latest()
            ->paginate(10);
        return Inertia::render('Customer/Payments/Index',[
            'payableBids' => BidResource::collection($customerPayableBids)
        ]);
    }
}
