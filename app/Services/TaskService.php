<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Enum\PaginationLimits;
use App\Models\Category;
use App\Models\District;
use App\Models\Zila;
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
        $slug = $request->query('slug');
        $district = $request->query('district');
        $zila = $request->query('zila');
        $upozila = $request->query('upozila');
        $keyword = $request->query('keyword');
        $sort = $request->query('sort');

        $perPage = $request->integer('per_page', PaginationLimits::PER_PAGE_FIFTEEN->value);
        $perPage = max(1, min(100, $perPage));

        $query = Task::query()
            ->select([
                'id',
                'category_id',
                'title',
                'slug',
                'description',
                'district_id',
                'zila_id',
                'upozila_id',
                'emergency',
                'budget',
                'created_at'
            ])
            ->with([
                'category:id,name,slug',
                'districts:id,name',
                'zilas:id,name',
                'upozilas:id,name',
            ]);

        self::applyCategoryFilter($query, $slug);
        self::applyLocationFilter($query, 'district', $district, 'districts');
        self::applyLocationFilter($query, 'zila', $zila, 'zilas');
        self::applyLocationFilter($query, 'upozila', $upozila, 'upozilas');
        self::applyKeywordFilter($query, $keyword);
        self::applySorting($query, $sort);
        return $query->paginate($perPage);
    }
    private static function applyCategoryFilter($query, $slug): void
    {
        if (empty($slug)) {
            return;
        }

        if (is_array($slug)) {
            $slugs = array_filter(array_map('trim', $slug));
            if (!empty($slugs)) {
                $query->whereHas('category', function ($q) use ($slugs) {
                    $q->whereIn('slug', $slugs);
                });
            }
        } else {
            $slug = trim($slug);
            if (!empty($slug)) {
                $query->whereHas('category', function ($q) use ($slug) {
                    $q->where('slug', 'LIKE', '%' . $slug . '%');
                });
            }
        }
    }

   private static function applyKeywordFilter($query, $value): void
{
    if (empty($value)) {
        return;
    }

    $value = trim($value);

    if ($value === '') {
        return;
    }

    $query->where(function ($q) use ($value) {
        if (is_numeric($value)) {
            $q->where('id', (int) $value);
        } else {
            $q->where('title', 'LIKE', "%{$value}%")
              ->orWhere('description', 'LIKE', "%{$value}%");
        }
    });
}
private static function applySorting($query, string $sort=null): void
{
    match ($sort) {
        'newest'     => $query->orderBy('created_at', 'desc'),
        'oldest'     => $query->orderBy('created_at', 'asc'),
        'budget_high' => $query->orderBy('budget', 'desc'),
        'budget_low'  => $query->orderBy('budget', 'asc'),
        'urgent'  => $query->where('emergency', 'emergency'),
         default => $query->orderByDesc('id'),
    };
}

    private static function applyLocationFilter($query, string $field, $value, string $relation): void
    {
        if (empty($value)) {
            return;
        }

        $value = trim($value);
        if (empty($value)) {
            return;
        }

        $query->whereHas($relation, function ($q) use ($value) {
            if (is_numeric($value)) {
                $q->where('id', $value);
            } else {
                $q->where('name', 'LIKE', '%' . $value . '%');
            }
        });
    }

    public static function category()

    {
        $categories = Category::select('id', 'name', 'slug')
            ->with(['task:id,category_id'])
            ->where('is_active', true)
            ->get();

        return $categories;
    }
    public static function districtWiseZila()
    {
        $districts = District::with(['zilas:id,name,district_id'])
            ->get(['id', 'name']);
        return $districts;
    }

    public static function zilaWiseUpozila()
    {
        $zilas = Zila::with(['upozilas:id,name,zila_id'])
            ->get(['id', 'name', 'district_id']);
        return $zilas;
    }
}
