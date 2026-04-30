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
use App\Models\Task;
use App\Models\User;
use App\Services\LocationService;
use App\Services\TaskService;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

 public function index()
{
    $user = auth()->user();

   abort_unless($user->isCustomer(), 403, 'Unauthorized');

   $taskCounts = CustomerService::getTaskCounts($user);

    return Inertia::render('Customer/Dashboard/Index', [
        'inProgress' => (int) $taskCounts->in_progress,
        'inBiding'   => (int) $taskCounts->in_biding,
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
 public function bidActivity(Request $request)
{   
    return CustomerService::getAllActivities(auth()->user(), $request);
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
