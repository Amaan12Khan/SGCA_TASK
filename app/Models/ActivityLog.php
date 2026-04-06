<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'task_id',
        'action',
        'performed_by',
        'details'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}