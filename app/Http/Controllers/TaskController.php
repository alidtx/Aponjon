<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function createProfile()  {
          return Inertia::render('Task/Index');
    }
}
