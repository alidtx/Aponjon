<?php

namespace App\Services;

use App\Enum\PaymentStatus;
use App\Enum\TaskStatus;
use App\Models\CustomerProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\MediaService;


class CustomerService
{
    public static function storeCustomerProfile($request)
    {
        DB::beginTransaction();
        try {
            $customer = CustomerProfile::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'nid_number' => $request->nid_number,
                    'district_id' => $request->district_id,
                    'zila_id' => $request->zila_id,
                    'upozila_id' => $request->upozila_id,
                ]
            );

            if ($request->hasFile('person_image')) {

                MediaService::deleteByName($customer, 'Person Image');

                MediaService::upload(
                    file: $request->file('person_image'),
                    path: 'customer/documents',
                    name: 'Peron Image',
                    fileable: $customer
                );
            }

            if ($request->hasFile('nid_front')) {

                MediaService::deleteByName($customer, 'NID Front');

                MediaService::upload(
                    file: $request->file('nid_front'),
                    path: 'customer/documents',
                    name: 'NID Front',
                    fileable: $customer
                );
            }

            if ($request->hasFile('nid_back')) {
                MediaService::deleteByName($customer, 'NID Back');

                MediaService::upload(
                    file: $request->file('nid_back'),
                    path: 'customer/documents',
                    name: 'NID Back',
                    fileable: $customer
                );
            }
            if (!auth()->user()->is_profile_completed) {

                auth()->user()->update(['is_profile_completed' => true]);
            }
            DB::commit();

            return $customer;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public static function CustomerTotalSpend(User $customer): float
    {
        if (!$customer->isCustomer()) {
            return 0.0;
        }

        return $customer->customerTasks()
            ->where('tasks.status', TaskStatus::Completed->value)
            ->join('orders', 'tasks.id', '=', 'orders.task_id')
            ->where('orders.payment_status', PaymentStatus::Paid->value)
            ->sum('orders.amount');
    }

    public static function getSuccessRate(User $customer): float
    {
        if (!$customer->isCustomer()) {
            return 0.0;
        }

        $totalTasks = $customer->customerTasks()->count();

        if ($totalTasks === 0) {
            return 0.0;
        }

        $successfulTasks = $customer->customerTasks()
            ->where('status', TaskStatus::Completed->value)
            ->whereHas('order', function ($query) {
                $query->where('payment_status', PaymentStatus::Paid->value);
            })
            ->count();

        return round(($successfulTasks / $totalTasks) * 100, 2);
    }

     public static function customerCurrentMonthspend(User $tasker): float
    {
        if (!$tasker->isCustomer()) {
            return 0.0;
        }

        return $tasker->customerTasks()
            ->where('tasks.status', TaskStatus::Completed->value)
            ->whereMonth('tasks.updated_at', now()->month)
            ->whereYear('tasks.updated_at', now()->year)
            ->join('orders', 'tasks.id', '=', 'orders.task_id')
            ->where('orders.payment_status', PaymentStatus::Paid->value)
            ->sum('orders.amount');
    }

    public static function getTaskCounts(User $user): object
    {
        return $user->customerTasks()
            ->selectRaw("
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as in_biding
            ", [
                TaskStatus::InProgress->value,
                TaskStatus::Posted->value,
            ])
            ->first();
    }
}
