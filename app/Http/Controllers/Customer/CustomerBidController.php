<?php

namespace App\Http\Controllers\Customer;

use App\Enum\BidStatus;
use App\Enum\PaginationLimits;
use App\Enum\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\BidResource;
use App\Models\Bid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerBidController extends Controller
{
    public function index()
    {
        return Inertia::render('Customer/Bid/Index');
    }

    public function waitingForAcceptance(Request $request)
    {
        return BidResource::collection(
            $this->baseQuery()
                ->where('status', BidStatus::Pending->value)
                ->latest('id')
                ->paginate($this->perPage($request))
        );
    }

    public function accepted(Request $request)
    {
        return BidResource::collection(
            $this->baseQuery()
                ->where('status', BidStatus::Accepted->value)
                ->latest('id')
                ->paginate($this->perPage($request))
        );
    }

    public function inProgress(Request $request)
    {
        return BidResource::collection(
            $this->baseQuery()
                ->where('status', BidStatus::Accepted->value)
                ->whereHas('task', fn (Builder $query) => $query->where('status', TaskStatus::InProgress->value))
                ->latest('id')
                ->paginate($this->perPage($request))
        );
    }

    public function completed(Request $request)
    {
        return BidResource::collection(
            $this->baseQuery()
                ->where('status', BidStatus::Accepted->value)
                ->whereHas('task', fn (Builder $query) => $query->where('status', TaskStatus::Completed->value))
                ->latest('id')
                ->paginate($this->perPage($request))
        );
    }

    private function baseQuery(): Builder
    {
        return Bid::query()
            ->select([
                'id',
                'task_id',
                'tasker_id',
                'amount',
                'proposal',
                'estimated_hours',
                'availability',
                'specific_date',
                'terms_accepted',
                'status',
                'created_at',
                'updated_at',
            ])
            ->whereHas('task', fn (Builder $query) => $query->where('customer_id', auth()->id()))
            ->with([
                'task:id,title,budget,status,task_number,customer_id,customer_notes,created_at,updated_at',
                'tasker:id,name,phone,avatar,is_verified',
                'tasker.taskerProfiles:id,user_id,district_id,zila_id,upozila_id,designation,rating,is_online',
            ]);
    }

    private function perPage(Request $request): int
    {
        $perPage = $request->integer('per_page', PaginationLimits::PER_PAGE_FIVE->value);

        return max(1, min(100, $perPage));
    }
}
