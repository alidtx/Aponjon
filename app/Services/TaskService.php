<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Enum\PaginationLimits;
use Illuminate\Http\Request;

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

public static function getPaginate(Request $request): LengthAwarePaginator 
{
return Task::query()
    ->select(['id','category_id','title','description','district_id','zila_id','upozila_id','emergency','budget','created_at'
    ])
    ->with(['category:id,name','districts:id,name','zilas:id,name','upozilas:id,name',
    ])
    ->paginate(
        perPage: $request->per_page ?? PaginationLimits::PER_PAGE_FIFTEEN->value,
        page: $request->current_page ?? 1
    );
}

}
