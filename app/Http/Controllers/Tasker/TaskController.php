<?php

namespace App\Http\Controllers\Tasker;

use App\Enum\BidStatus;
use App\Enum\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskerProfileRequest;
use App\Http\Resources\BidResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ZilaResource;
use App\Models\Bid;
use App\Models\User;
use App\Services\LocationService;
use App\Services\TaskerService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;


class TaskController extends Controller
{

  public function index()
  {


    $userOverview = User::with('bids')->select('id', 'name')
      ->findOrFail(auth()->user()->id);

    $recentActivity = Bid::with('task')
      ->where('tasker_id', auth()->user()->id)
      ->whereIn('status', ['pending', 'accepted'])
      ->latest()
      ->limit(10)
      ->get();

    return Inertia::render('Task/Index', [
      'overview' => new UserResource($userOverview),
      'activity' => BidResource::collection($recentActivity),
      'monthlyErning' => TaskerService::TaskerCurrentMonthEarning(auth()->user()),
    ]);
  }
  public function pendingTasks()
  {
    $taskerId = auth()->id();

    $allBids = self::getAllPendingBids($taskerId);

    return Inertia::render('Task/PendingTask', [
      'pendingBids' => BidResource::collection($allBids->where('status', BidStatus::Pending->value)),
      'acceptedBids' => BidResource::collection($allBids->where('status', BidStatus::Accepted->value)),
      'rejectedBids' => BidResource::collection($allBids->where('status', BidStatus::Rejected->value)),
    ]);
  }

  public function AssignedTask()
  {
    $allBids = $this->getAllAssignedBids(auth()->id());
   
    return Inertia::render('Task/AssignedTask', [

    'inProgressTasks' => BidResource::collection($allBids->filter(
          fn($bid) =>
          $bid->task && $bid->task->status === TaskStatus::InProgress->value
        )
      ),

      'assignedTasks' => BidResource::collection(
        $allBids->filter(
          fn($bid) =>
          $bid->task && $bid->task->status === TaskStatus::Assigned->value
        )
      ),

      'completedTasks' => BidResource::collection(
        $allBids->filter(
          fn($bid) =>
          $bid->task && $bid->task->status === TaskStatus::Completed->value
        )
      ),
       'disputedTasks' => BidResource::collection(
        $allBids->filter(
          fn($bid) =>
          $bid->task && $bid->task->status === TaskStatus::Disputed->value
        )
      ),
      
    ]);
  }

  private static function getAllPendingBids($taskerId)
  {
    return Bid::where('tasker_id', $taskerId)
      ->with([
        'task:id,title,customer_id,status,created_at',
        'task.customers:id,name,phone',
        'task.customers.customerProfile:id,user_id,district_id,zila_id,upozila_id',
        'task.customers.customerProfile.district:id,name',
        'task.customers.customerProfile.zila:id,name',
        'task.customers.customerProfile.upozila:id,name',
      ])
      ->select('id', 'task_id', 'tasker_id', 'amount', 'status', 'created_at')
      ->get();
  }

   private static function getAllAssignedBids($taskerId)
  {
    return Bid::where('tasker_id', $taskerId)
      ->with([
        'task:id,title,customer_id,status,created_at',
        'task.customers:id,name,phone',
        'task.customers.customerProfile:id,user_id,district_id,zila_id,upozila_id',
        'task.customers.customerProfile.district:id,name',
        'task.customers.customerProfile.zila:id,name',
        'task.customers.customerProfile.upozila:id,name',
      ])
      ->select('id', 'task_id', 'tasker_id', 'amount', 'status', 'created_at')
      ->get();
  }


  public function taskerSidebarInfo()
  {
    $taskerSidebarProfile = User::findOrFail(auth()->user()->id)->load([
      'taskerProfiles',
      'taskerProfiles.media',
    ]);
    return new UserResource($taskerSidebarProfile);
  }
  public function TaskerTotalEarning()
  {
    return TaskerService::TaskerTotalEarning(auth()->user());
  }
  public function TaskerSuccessRate()
  {
    return TaskerService::getSuccessRate(auth()->user());
  }


  public function createProfile(Request $request)
  {
    return Inertia::render('Task/CreateProfile', [
      'loggedInUser' => new UserResource(Auth::user()),
      'districts' => DistrictResource::collection(LocationService::districtWiseZila()),
      'zilas' => ZilaResource::collection(LocationService::zilaWiseUpozila()),
    ]);
  }
  public function storeProfile(TaskerProfileRequest $request)
  {
    try {
      TaskerService::storeTaskerProfile($request);

      return redirect()->route('kyc.awaiting-approval.index');
    } catch (\Exception $e) {
      return redirect()->back()
        ->with('error', 'Failed to save profile: ' . $e->getMessage())
        ->withInput();
    }
  }
}
