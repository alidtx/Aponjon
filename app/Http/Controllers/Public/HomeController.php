<?php

namespace App\Http\Controllers\Public;

use App\Enum\PaginationLimits;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Models\District;
use App\Models\Task;
use App\Models\TaskerProfile;
use App\Services\TaskService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('PublicResources/Home', [
            'user' => auth()->check() ? new UserResource(auth()->user()) : null,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'siteConfig' => config('aponjon.siteConfig'),
        ]);
    }

    public function marketplace(Request $request)
    {
        $activeTasker = TaskerProfile::select('id', 'verification_status')
            ->where('verification_status', 'verified')
            ->count();
        $completedTasks = Task::select('id', 'status')
            ->where('status', 'completed')
            ->count();

        return Inertia::render('Marketplace/Index', [
            'totalTask' => Task::select('id')->count(),
            'activeTasker' => $activeTasker,
            'completedTasks' => $completedTasks,
            'totalBudget' => Task::sum('budget'),
            'task'=>TaskResource::collection(TaskService::getPaginate($request))
        ]);
    }
}
