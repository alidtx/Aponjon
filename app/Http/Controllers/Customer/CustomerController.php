<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Services\TaskService;

class CustomerController extends Controller
{

  public function index()
  {
    $customerId = auth()->user()->id;
    // dd($customerId);
    $tasks = [
      'active' => TaskService::getTaskByStatus('in_progress', $customerId, ['taskers', 'bids']),
      'completed' => TaskService::getTaskByStatus('completed', $customerId, ['taskers']),
      'cancelled' => TaskService::getTaskByStatus('cancelled', $customerId, ['taskers']),
    ];
    // dd($tasks);
    return Inertia::render('Customer/Index', [
      'user' => new UserResource(auth()->user()),
      'tasks' => [
        'active' => TaskResource::collection($tasks['active']),
        'completed' => TaskResource::collection($tasks['completed']),
        'cancelled' => TaskResource::collection($tasks['cancelled']),
      ],
    ]);
  }
}
