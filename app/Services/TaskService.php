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
    public static function getTaskByStatus(string $status, $customerId=null, array $relations=[]) {
        return Task::with($relations)
            ->when($status !== 'all', function (Builder $query) use ($status, $customerId) {
                $query->where('status', $status);
                $query->where('customer_id', $customerId);
            })
            ->latest() 
            ->get();
    }
}
