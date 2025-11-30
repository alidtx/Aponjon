<?php

namespace App\Services;

use App\Models\Otp;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Random\RandomException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class TaskService
{
    public static function getTaskByStatus(string $status, $customerId = null, array $relations = [])
    {
        return Task::with($relations)
            ->when($status !== 'all', function (Builder $query) use ($status, $customerId) {
                $query->where('status', $status);
                $query->where('customer_id', $customerId);
            })
            ->latest()
            ->get();
    }
    public static function store($request)
    {   
        return Task::create([
            'task_number' => RandomGigNum::generateWithPrefix('GIG'),
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'schedule_for' => $request->schedule_for,
            'category_id' => $request->category_id,
            'district_id' => $request->district_id,
            'zila_id' => $request->zila_id,
            'upozila_id' => $request->upozila_id,
        ]);
    }
}
