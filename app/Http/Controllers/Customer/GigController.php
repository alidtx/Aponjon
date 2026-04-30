<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\GigRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DistrictResource;
use Inertia\Inertia;
use App\Http\Resources\ZilaResource;
use App\Models\Category;
use App\Services\LocationService;
use App\Services\TaskService;


class GigController extends Controller
{

    public function index()
    {
        return Inertia::render('Customer/CreateGig/Index');
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
