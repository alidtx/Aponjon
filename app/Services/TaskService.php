<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Enum\PaginationLimits;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskService
{
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
            ->select([
                'id',
                'category_id',
                'title',
                'description',
                'district_id',
                'zila_id',
                'upozila_id',
                'emergency',
                'budget',
                'created_at'
            ])
            ->with([
                'category:id,name',
                'districts:id,name',
                'zilas:id,name',
                'upozilas:id,name',
            ])
            ->orderByDesc('id')
            ->paginate(
                perPage: $request->per_page ?? PaginationLimits::PER_PAGE_FIFTEEN->value,
            );
    }
    public static function category()

    {
        $categories = Category::select('id', 'name', 'slug')
            ->with(['task:id,category_id'])
            ->where('is_active', true)
            ->get();

        return $categories;
    }
}
