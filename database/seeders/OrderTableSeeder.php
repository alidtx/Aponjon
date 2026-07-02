<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Order;
use App\Models\Task;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Task::query()->with('bids')->get();

        foreach ($tasks as $index => $task) {
            $acceptedBid = $task->bids->sortBy('amount')->first();

            if (! $acceptedBid) {
                continue;
            }

            $status = $index < 8 ? 'completed' : ($index < 16 ? 'assigned' : 'posted');

            if ($status === 'posted') {
                continue;
            }

            Bid::query()
                ->where('task_id', $task->id)
                ->update(['status' => 'rejected']);

            $acceptedBid->update(['status' => 'accepted']);

            $task->update([
                'tasker_id' => $acceptedBid->tasker_id,
                'status' => $status,
            ]);

            Order::factory()->create([
                'task_id' => $task->id,
                'amount' => $acceptedBid->amount,
                'platform_fee' => round($acceptedBid->amount * 0.1, 2),
                'tasker_earning' => round($acceptedBid->amount * 0.9, 2),
                'payment_status' => $status === 'completed' ? 'paid' : 'pending',
            ]);
        }
    }
}
