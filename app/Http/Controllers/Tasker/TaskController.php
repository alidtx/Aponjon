<?php

namespace App\Http\Controllers\Tasker;

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

  public function pendingBids()
  {
    return Inertia::render('Task/PendingTask');
  }

  public function AssignedTask()
  {
    return Inertia::render('Task/AssignedTask');
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
