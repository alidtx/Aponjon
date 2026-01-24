<?php

namespace App\Http\Controllers\Bid;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\BidService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BidController extends Controller
{
    public function show(Request $request,$id, $slug)
    {
        return Inertia::render('Bids/Index', [
            'totalTaskCount'=>Task::count(),
            'paymentCompletionRate'=>BidService::paymentCompletionRate($id),
            'taskDetails' => TaskResource::make(
                BidService::findTaskDetails($id,$slug)
            )
        ]);
    }
}
