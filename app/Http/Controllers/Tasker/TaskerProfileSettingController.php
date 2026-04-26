<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskerProfileSettingController extends Controller
{
    public function editSetting($taskerId)
    {
        return Inertia::render('Task/TaskerProfileSettings');
    }
}
