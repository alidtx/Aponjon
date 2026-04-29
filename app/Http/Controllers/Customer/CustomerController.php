<?php

namespace App\Http\Controllers\Customer;

use App\Enum\BidStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\GigRequest;
use App\Http\Resources\BidResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\TaskResource;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Http\Resources\ZilaResource;
use App\Models\Bid;
use App\Models\Category;
use App\Models\User;
use App\Services\LocationService;
use App\Services\TaskService;
use App\Services\CustomerService;

class CustomerController extends Controller
{

 public function index()
{
    $user = auth()->user();

   abort_unless($user->isCustomer(), 403, 'Unauthorized');

   $taskCounts = CustomerService::getTaskCounts($user);
    $recentActivity = Bid::with('task') 
        ->where('tasker_id', $user->id)
        ->whereIn('status', [
            BidStatus::Pending->value,
            BidStatus::Accepted->value
        ])
        ->latest()
        ->limit(10)
        ->get();
    $activities = CustomerService::getAllActivities($user);

    return Inertia::render('Customer/Dashboard/Index', [
        'inProgress' => (int) $taskCounts->in_progress,
        'inBiding'   => (int) $taskCounts->in_biding,
        'activity'      => BidResource::collection($recentActivity),
        'pendingActivity'  => TaskResource::collection($activities['pending']),
        'acceptedActivity' => TaskResource::collection($activities['accepted']),
        'monthlySpend' => CustomerService::customerCurrentMonthspend($user),
    ]);
}
 public function CustomerSidebarInfo()
  {
    $CustomerSidebarProfile = User::findOrFail(auth()->user()->id)->load([
      'customerProfile',
      'customerProfile.media',
    ]);
    return new UserResource($CustomerSidebarProfile);
  }
  public function CustomerTotalSpend()
  {
    return CustomerService::CustomerTotalSpend(auth()->user());
  }
  public function CustomerSuccessRate()
  {
    return CustomerService::getSuccessRate(auth()->user());
  }

  public function createGig()
  {

    $categories = Category::where('is_active', true)
      ->get(['id', 'name', 'icon']);

    return Inertia::render('Customer/CreateGig/Index', [
      'districts' => DistrictResource::collection(LocationService::districtWiseZila()),
      'zilas' => ZilaResource::collection(LocationService::zilaWiseUpozila()),
      'categories' => CategoryResource::collection($categories),
    ]);
  }

  public function gigsStore(GigRequest $request)
  {
    TaskService::store($request);
    return redirect()->back()->with([
      'type' => 'success',
      'message' => 'আপনার গিগ সফলভাবে তৈরি হয়েছে!',
    ]);
  }
}
