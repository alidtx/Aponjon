<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('PublicResources/Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'siteConfig' => config('aponjon.siteConfig'),
        ]);
    }
}
