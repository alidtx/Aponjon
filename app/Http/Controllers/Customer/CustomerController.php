<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Models\User;
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

}
