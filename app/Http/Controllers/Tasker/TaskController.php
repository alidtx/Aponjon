<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskerProfileRequest;
use App\Http\Resources\BidResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ZilaResource;
use App\Models\Bid;
use App\Models\Task;
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
    
    $user = auth()->user();

    $userOverview = User::with([
      'taskerProfiles',
      'taskerProfiles.media',
      'bids',
    ])
      ->select('id', 'name')
      ->findOrFail($user->id);
    return Inertia::render('Task/Index', [
      'overview' => new UserResource($userOverview),
      'totalEarning' => TaskerService::TaskerTotalEarning($user),
      'monthlyErning' => TaskerService::TaskerCurrentMonthEarning($user)
    ]);
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
