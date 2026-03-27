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
use Illuminate\Http\JsonResponse;
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
  public function storeProfile(TaskerProfileRequest $request) : JsonResponse
{
    $result = TaskService::storeTaskerProfile($request);
    
    if (!$result['success']) {
        return response()->json($result, 422);
    }
    
    return response()->json($result, 200);
}
}
