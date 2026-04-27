<?php

namespace App\Http\Controllers\Customer;


use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerProfileRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ZilaResource;
use App\Models\User;
use App\Services\CustomerService;
use App\Services\LocationService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;


class CustomerProfileController extends Controller
{

  public function createProfile(Request $request)
  {
    return Inertia::render('Customer/CreateProfile', [
      'loggedInUser' => new UserResource(Auth::user()),
      'districts' => DistrictResource::collection(LocationService::districtWiseZila()),
      'zilas' => ZilaResource::collection(LocationService::zilaWiseUpozila()),
    ]);
  }
  public function storeProfile(CustomerProfileRequest $request)
  {
    try {
      CustomerService::storeCustomerProfile($request);

      return redirect()->route('kyc.awaiting-approval.index');
    } catch (\Exception $e) {
      return redirect()->back()
        ->with('error', 'Failed to save profile: ' . $e->getMessage())
        ->withInput();
    }
  }
  public function editProfile($customerId)
  {
    $customer = User::with('customerProfile')->findOrFail($customerId);
    return Inertia::render('Customer/EditProfile', [
      'loggedInUser' => new UserResource($customer),
      'districts' => DistrictResource::collection(LocationService::districtWiseZila()),
      'zilas' => ZilaResource::collection(LocationService::zilaWiseUpozila()),
    ]);
  }
  public function updateProfile(CustomerProfileRequest $request, $customerId)
  {
    try {
      CustomerService::storeCustomerProfile($request);
    } catch (\Exception $e) {
      return redirect()->back()
        ->with('error', 'Failed to update profile: ' . $e->getMessage())
        ->withInput();
    }
  }
}
