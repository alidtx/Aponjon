<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

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
            'customer_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'location_address' => $request->location_address,
            'budget' => $request->budget,
            'emergency' => $request->emergency,
            'category_id' => $request->category_id,
            'district_id' => $request->district_id,
            'zila_id' => $request->zila_id,
            'upozila_id' => $request->upozila_id,
        ]);
    }
public static function fetchTaskData(int $perPage = 15): LengthAwarePaginator 

{
          $task = Task::select(
        'category_id',
        'district_id',
        'tasker_id',
        'zila_id',
        'upozila_id',
        'title',
        'description',
        'location_address',
        'district_id',
        'zila_id',
        'upozila_id',
        'emergency',
        'budget',
        'created_at'
        )
        ->with('category', 'districts', 'zilas', 'upozilas')
        // ->orderBy('id', 'DESC')
        ->get();

        $collection = collect($task);
        $currentPage = request()->get('page', 1);
        $currentPageItems = $collection
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $currentPage,
        );
}

}
