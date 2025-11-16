<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\UserResource;

class CustomerController extends Controller
{
    
    public function index()  
    {
          return Inertia::render('Customer/Index',[
            'user' => new UserResource(auth()->user())
          ]);
    }


}