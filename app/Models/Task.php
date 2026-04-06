<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'assigned_role',
        'priority',
        'deadline',
        'status',
        'notes'
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isOverdue(): bool
    {
        return Carbon::now()->gt($this->deadline)
            && !in_array($this->status, ['Approved']);
    }

    public function isLocked(): bool
    {
        return $this->status === 'Approved';
    }

    public function getDaysUntilDeadline(): int
    {
        return Carbon::now()->diffInDays($this->deadline, false);
    }

    public function getProgressPercent(): int
    {
        $map = [
            'Pending'          => 0,
            'In Progress'      => 25,
            'Submitted'        => 50,
            'Manager Approved' => 75,
            'Approved'         => 100,
            'Rejected'         => 25,
        ];
        return $map[$this->status] ?? 0;
    }
}