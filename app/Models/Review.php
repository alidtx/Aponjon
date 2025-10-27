<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{   
    Use HasFactory;
    protected $fillable = [
        'task_id',
        'reviewer_id',
        'reviewee_id',
        'rating',
        'comment',
        'type',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

}
