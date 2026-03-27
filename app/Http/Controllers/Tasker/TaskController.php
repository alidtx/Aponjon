<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskerProfileRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ZilaResource;
use App\Models\User;
use App\Services\LocationService;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;



class TaskController extends Controller
{
  public function createProfile(Request $request)
  {
    return Inertia::render('Task/Index', [
      'loggedInUser' => new UserResource(Auth::user()),
      'districts' => DistrictResource::collection(LocationService::districtWiseZila()),
      'zilas' => ZilaResource::collection(LocationService::zilaWiseUpozila()),
    ]);
  }
  public function storeProfile(TaskerProfileRequest $request)
  {
    $response=TaskService::storeTaskerProfile($request);
    return response()->json([
    'success' => true,
    'message' => 'Tasker profile created successfully',
    'data' => $response,
], 201); 

  }
}
