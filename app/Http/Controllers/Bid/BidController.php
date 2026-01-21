<?php

namespace App\Http\Controllers\Bid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BidController extends Controller
{
    public function show (Request $request, $slug)   {
            return Inertia::render('Bids/Index');
    }    
}
