<?php

namespace App\Http\Controllers\Customer;

use App\Enum\PaginationLimits;
use App\Http\Controllers\Controller;
use App\Http\Requests\GigRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\ZilaResource;
use App\Models\Category;
use App\Services\LocationService;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;


class GigController extends Controller
{

  public function index(Request $request)
  {
    $perPage = $request->integer('per_page', PaginationLimits::PER_PAGE_FIFTEEN->value);
    $perPage = max(1, min(100, $perPage));

    $customerTasks = auth()->user()
      ->customerTasks()
      ->with('category:id,name')
      ->latest()
      ->paginate($perPage);
      
    return Inertia::render('Customer/CreateGig/Index', [
      'customerTasks' => TaskResource::collection($customerTasks),
    ]);
  }

  public function createGig()
  {

    $categories = Category::where('is_active', true)
      ->get(['id', 'name', 'icon']);

    return Inertia::render('Customer/CreateGig/Create', [
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
