<?php

namespace App\Http\Controllers\Tasker;

use App\Enum\BidStatus;
use App\Enum\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\BidResource;
use App\Models\Bid;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskerBidController extends Controller
{
     public function Index()
     {
          $appliedTask = Bid::query()
               ->select('id', 'task_id', 'tasker_id', 'status','amount', 'created_at')
               ->whereStatus(BidStatus::Pending->value)
               ->whereTaskerId(auth()->id())
               ->with([
                    'task:id,title,budget,status,task_number,customer_notes',
                    'tasker:id,name',
                    'tasker.taskerProfiles:id,user_id,district_id,zila_id,upozila_id',
               ])
               ->latest('id')
               ->paginate(10);

          return Inertia::render('Tasker/AppliedTask/Index', [
               'appliedTask' => BidResource::collection($appliedTask),
          ]);
     }
}
