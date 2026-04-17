<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskerProfileRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ZilaResource;
use App\Services\LocationService;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;



class TaskController extends Controller
{

  public function index()
{
     return Inertia::render('Task/Index');

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
            TaskService::storeTaskerProfile($request);

            return redirect()->route('kyc.awaiting-approval.index');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to save profile: ' . $e->getMessage())
                ->withInput();
        }
    }


}
