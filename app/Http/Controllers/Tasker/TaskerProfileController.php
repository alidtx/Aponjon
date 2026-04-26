<?php

namespace App\Http\Controllers\Tasker;


use App\Http\Controllers\Controller;
use App\Http\Requests\TaskerProfileRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ZilaResource;
use App\Models\User;
use App\Services\LocationService;
use App\Services\TaskerService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;


class TaskerProfileController extends Controller
{

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
  public function editProfile($taskerId)
  {
    $tasker = User::with('taskerProfiles')->findOrFail($taskerId);
    return Inertia::render('Task/EditProfile', [
      'loggedInUser' => new UserResource($tasker),
      'districts' => DistrictResource::collection(LocationService::districtWiseZila()),
      'zilas' => ZilaResource::collection(LocationService::zilaWiseUpozila()),
    ]);
  }
  public function updateProfile(TaskerProfileRequest $request, $taskerId)
  {
    try {
      TaskerService::storeTaskerProfile($request);
    } catch (\Exception $e) {
      return redirect()->back()
        ->with('error', 'Failed to update profile: ' . $e->getMessage())
        ->withInput();
    }
  }
}
