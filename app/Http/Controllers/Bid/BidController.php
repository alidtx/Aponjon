<?php

namespace App\Http\Controllers\Bid;

use App\Enum\BidStatus;
use App\Enum\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\BidRequest;
use App\Http\Requests\CancelBidRequest;
use App\Http\Requests\DisputedBidRequest;
use App\Http\Resources\BidResource;
use App\Http\Resources\TaskResource;
use App\Models\Bid;
use App\Models\Task;
use App\Services\BidService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BidController extends Controller
{
    public function show(Request $request, $taskId, $slug)
    {
        return Inertia::render('Bids/Index', [
            'totalTaskCount' => Task::select('id')->get(),
            'paymentCompletionRate' => BidService::paymentCompletionRate($taskId),
            'taskDetails' => TaskResource::make(BidService::findTaskDetails($taskId, $slug))
        ]);
    }
    public function showBidSubmissionForm(Request $request, $taskId, $slug)
    {
        return Inertia::render('BidSubmitForm/Index', [
            'bidDetails' => TaskResource::make(BidService::bidDetails($taskId, $slug)),
            'allBids' => BidResource::collection(Bid::select('id', 'amount')->get()),
        ]);
    }
    public function bidStore(BidRequest $request)
    {

        BidService::store($request);
        return redirect()->back()->with([
            'type' => 'success',
            'message' => 'কাটি সপল ভাবে আবেদন করা হয়েছে',
        ]);
    }
    public function accept(Bid $bid)
    {
        $bid->update(['status' => BidStatus::Accepted->value]);
        $bid->task->update(['status' => TaskStatus::Assigned->value]);
        return response()->json(['success' => true]);
    }
    public function cancel(CancelBidRequest $request, Bid $bid)
{        
      
    $bid->update(['status' => BidStatus::Rejected->value]);
     // 'cancelled_at' => now(),
    // 'cancelled_by' => auth()->id()
    $bid->task->update([
        'status' => TaskStatus::Cancelled->value,
        'customer_notes' => $request->cancellation_reason,
        ]);

    // Optional: Store in a separate log table for analytics
    // CancellationLog::create([
    //     'bid_id' => $bid->id,
    //     'user_id' => auth()->id(),
    //     'reason' => $request->cancellation_reason,
    //     'cancelled_at' => now()
    // ]);

    return response()->json(['success' => true]);
}
public function dispute(DisputedBidRequest $request, Bid $bid)
{
   
    $bid->task->update([
        'status' => TaskStatus::Disputed->value,
        'dispute_reason' => $request->dispute_reason,
        // 'disputed_at' => now()
    ]);
    
    return response()->json(['success' => true]);
}

}
