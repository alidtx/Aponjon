<?php

namespace App\Http\Controllers\Bid;

use App\Http\Controllers\Controller;
use App\Http\Requests\BidRequest;
use App\Http\Resources\BidResource;
use App\Http\Resources\TaskResource;
use App\Models\Bid;
use App\Models\Task;
use App\Services\BidService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BidController extends Controller
{
    public function show(Request $request,$taskId, $slug)
    {
        return Inertia::render('Bids/Index', [
            'totalTaskCount'=>Task::select('id')->get(),
            'paymentCompletionRate'=>BidService::paymentCompletionRate($taskId),
            'taskDetails' => TaskResource::make(BidService::findTaskDetails($taskId,$slug))
        ]);
    }
    public function showBidSubmissionForm (Request $request, $taskId , $slug)  {
      return Inertia::render('BidSubmitForm/Index',[
         'bidDetails' => TaskResource::make(BidService::bidDetails($taskId,$slug)),
         'allBids'=>BidResource::collection(Bid::select('id','amount')->get()),
      ]);
    }
    public function bidStore(BidRequest $request) {
         dd($request->all());
    }
}
