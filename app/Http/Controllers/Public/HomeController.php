<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\Task;
use App\Models\TaskerProfile;
use App\Models\User;

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
    public function marketplace()
    {   
        return Inertia::render('Marketplace/Index',[
              'totalTask'=>Task::select('id')->count(),
              'activeTasker'=>TaskerProfile::select('id', 'verification_status')->where('verification_status', 'verified')->count(),
              'totalBudget'=>Task::sum('budget')
        ]);
    }
}
