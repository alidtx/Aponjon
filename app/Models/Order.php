<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    Use HasFactory;
    protected $fillable = ['task_id', 'amount', 'platform_fee', 'tasker_earning', 'payment_status', 'payment_method', 'transaction_id'];

    public function  task()
    {
        return $this->belongsTo(Task::class);
    }
}
