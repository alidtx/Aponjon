<?php

namespace App\Services;

use App\Models\TaskerProfile;
use Illuminate\Support\Facades\DB;
use App\Services\MediaService;
use App\Models\User;

class TaskerService
{
    public static function storeTaskerProfile($request)
    {
        DB::beginTransaction();
        try {
            $tasker = TaskerProfile::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'nid_number' => $request->nid_number,
                    'bio' => $request->bio,
                    'skill' => $request->skills,
                    'experience' => $request->experience,
                    'district_id' => $request->district_id,
                    'zila_id' => $request->zila_id,
                    'upozila_id' => $request->upozila_id,
                    'hourly_rate' => $request->hourly_rate,
                    'document' => $request->document,
                ]
            );
            if ($request->hasFile('person_image')) {

                MediaService::deleteByName($tasker, 'Person Image');

                MediaService::upload(
                    file: $request->file('person_image'),
                    path: 'tasker/documents',
                    name: 'Peron Image',
                    fileable: $tasker
                );
            }
            if ($request->hasFile('nid_front')) {

                MediaService::deleteByName($tasker, 'NID Front');

                MediaService::upload(
                    file: $request->file('nid_front'),
                    path: 'tasker/documents',
                    name: 'NID Front',
                    fileable: $tasker
                );
            }

            if ($request->hasFile('nid_back')) {
                MediaService::deleteByName($tasker, 'NID Back');

                MediaService::upload(
                    file: $request->file('nid_back'),
                    path: 'tasker/documents',
                    name: 'NID Back',
                    fileable: $tasker
                );
            }
            auth()->user()->update(['is_profile_completed' => true]);

            DB::commit();

            return $tasker;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public static function TaskerTotalEarning(User $user): float
    {
        if (!$user->isTasker()) {
            return 0.0;
        }

        return $user->taskerTasks()
            ->where('tasks.status', 'completed')
            ->join('orders', 'tasks.id', '=', 'orders.task_id')
            ->where('orders.payment_status', 'paid')
            ->sum('orders.tasker_earning');
    }

    public static function TaskerCurrentMonthEarning(User $user): float
    {
        if (!$user->isTasker()) {
            return 0.0;
        }

        return $user->taskerTasks()
            ->where('tasks.status', 'completed')
            ->whereMonth('tasks.updated_at', now()->month)
            ->whereYear('tasks.updated_at', now()->year)
            ->join('orders', 'tasks.id', '=', 'orders.task_id')
            ->where('orders.payment_status', 'paid')
            ->sum('orders.tasker_earning');
    }

}
