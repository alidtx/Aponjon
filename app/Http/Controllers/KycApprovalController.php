<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class KycApprovalController extends Controller
{
    public function index()
    {
        return Inertia::render('Kyc/AwaitingForKycApproval');
    }
}
