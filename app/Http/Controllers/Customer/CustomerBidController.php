<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerBidController extends Controller
{
   
public function index() {
   return Inertia::render('Customer/Bid/Index');
}

}
