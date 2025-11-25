<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\TaskResource;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Http\Resources\ZilaResource;
use App\Models\Category;
use App\Models\District;
use App\Models\Zila;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

  public function index()
  {
    $user = auth()->user();

    if (!$user->isCustomer()) {
      abort(403, 'Unauthorized');
    }

    $tasks = [
      'active' => $user->customerTasks()
        ->where('status', 'in_progress')
        ->with(['taskers', 'bids'])
        ->get(),
      'completed' => $user->customerTasks()
        ->where('status', 'completed')
        ->with('taskers')
        ->get(),
      'cancelled' => $user->customerTasks()
        ->where('status', 'cancelled')
        ->with('taskers')
        ->get(),
    ];

    return Inertia::render('Customer/Index', [
      'user' => new UserResource($user),
      'tasks' => [
        'active' => TaskResource::collection($tasks['active']),
        'completed' => TaskResource::collection($tasks['completed']),
        'cancelled' => TaskResource::collection($tasks['cancelled']),
      ],
    ]);
  }

 public function createGig()
{
    
    $categories = Category::where('is_active', true)
        ->get(['id', 'name', 'icon']);


    $districts = District::with(['zilas:id,name,district_id'])
        ->get(['id', 'name']);
      
    
    $zilas = Zila::with(['upozilas:id,name,zila_id'])
        ->get(['id', 'name', 'district_id']);

    return Inertia::render('Customer/CreateGig', [
        'districts' => DistrictResource::collection($districts),
        'zilas' => ZilaResource::collection($zilas),
        'categories' => CategoryResource::collection($categories),
    ]);
}
public function gigsStore(Request $request) {
  dd($request->all());

}



}
