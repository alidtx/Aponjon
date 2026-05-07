<?php

namespace App\Http\Controllers\Bid;

use App\Enum\BidStatus;
use App\Enum\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\BidResource;
use App\Models\Bid;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BidDisputedController extends Controller
{
    public function index()
    {
        $disputed = Bid::query()
            ->where('status', BidStatus::Accepted->value)

            ->whereHas('task', function ($q) {
                $q->where('customer_id', auth()->id());
                $q->where('status', TaskStatus::Disputed->value);
            })

            ->with([
                'task:id,title,budget,status',
                'tasker:id,name',
                'tasker.taskerProfiles:id,user_id,district_id,zila_id,upozila_id'
            ])
            ->latest()
            ->paginate(10);
        return Inertia::render('Customer/Disputed/Index', [
            'disputed' => BidResource::collection($disputed)
        ]);
    }
}
