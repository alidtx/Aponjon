<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskerProfileRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\ZilaResource;
use App\Services\LocationService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
  public function createProfile()
  {
    return Inertia::render('Task/Index', [
      'districts' => DistrictResource::collection(LocationService::districtWiseZila()),
      'zilas' => ZilaResource::collection(LocationService::zilaWiseUpozila()),
    ]);
  }
  public function storeProfile(TaskerProfileRequest $request)
  {
    UserService::storeTaskerProfile($request);
  }
}
