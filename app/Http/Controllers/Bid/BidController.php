<?php

namespace App\Http\Controllers\Bid;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Services\BidService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BidController extends Controller
{
    public function show(Request $request, $slug)
    {
        return Inertia::render('Bids/Index', [
            'taskDetails' => TaskResource::make(
                BidService::findTaskDetails($slug)
            )
        ]);
    }
}
