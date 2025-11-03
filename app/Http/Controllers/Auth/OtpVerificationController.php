<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
class OtpVerificationController extends Controller
{
    public function showVerificationForm() {
            return Inertia::render('Auth/VerifyOtp', );
     }
}
