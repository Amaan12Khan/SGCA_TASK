<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    private function log(Task $task, string $action, string $by, string $details = '')
    {
        ActivityLog::create([
            'task_id'      => $task->id,
            'action'       => $action,
            'performed_by' => $by,
            'details'      => $details,
        ]);
    }

    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('assigned_to', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->latest()->get()->map(function ($task) {
            $task->overdue = $task->isOverdue();
            $task->progress = $task->getProgressPercent();
            $task->daysLeft = $task->getDaysUntilDeadline();
            return $task;
        });

        $total    = Task::count();
        $pending  = Task::where('status', 'Pending')->count();
        $awaiting = Task::whereIn('status', ['Submitted', 'Manager Approved'])->count();
        $overdue  = Task::all()->filter(fn($t) => $t->isOverdue())->count();
        $approved = Task::where('status', 'Approved')->count();

        $recentLogs = ActivityLog::with('task')
            ->latest()
            ->take(8)
            ->get();

        return view('tasks.index', compact(
            'tasks', 'total', 'pending', 'awaiting',
            'overdue', 'approved', 'recentLogs'
        ));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'assigned_to'   => 'required|string|max:255',
            'assigned_role' => 'required|in:Employee,Manager,Admin',
            'priority'      => 'required|in:Low,Medium,High',
            'deadline'      => 'required|date|after_or_equal:today',
            'description'   => 'nullable|string',
            'notes'         => 'nullable|string',
        ]);

        $task = Task::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'assigned_to'   => $request->assigned_to,
            'assigned_role' => $request->assigned_role,
            'priority'      => $request->priority,
            'deadline'      => $request->deadline,
            'notes'         => $request->notes,
            'status'        => 'Pending',
        ]);

        $this->log($task, 'Task Created', 'Admin',
            "Task '{$task->title}' assigned to {$task->assigned_to}");

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $task->overdue   = $task->isOverdue();
        $task->progress  = $task->getProgressPercent();
        $task->daysLeft  = $task->getDaysUntilDeadline();
        $logs = $task->activityLogs()->latest()->get();
        return view('tasks.show', compact('task', 'logs'));
    }

    public function edit(Task $task)
    {
        if ($task->isLocked()) {
            return redirect()->route('tasks.index')
                ->with('error', 'This task is approved and locked!');
        }
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->isLocked()) {
            return redirect()->route('tasks.index')
                ->with('error', 'This task is approved and locked!');
        }

        $request->validate([
            'title'         => 'required|string|max:255',
            'assigned_to'   => 'required|string|max:255',
            'assigned_role' => 'required|in:Employee,Manager,Admin',
            'priority'      => 'required|in:Low,Medium,High',
            'deadline'      => 'required|date',
            'description'   => 'nullable|string',
            'notes'         => 'nullable|string',
        ]);

        $old = $task->status;
        $task->update($request->only([
            'title', 'description', 'assigned_to',
            'assigned_role', 'priority', 'deadline', 'notes'
        ]));

        $this->log($task, 'Task Updated', 'Admin',
            "Task '{$task->title}' details updated");

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        if ($task->isLocked()) {
            return redirect()->route('tasks.index')
                ->with('error', 'Cannot delete an approved task!');
        }
        $name = $task->title;
        $task->delete();
        return redirect()->route('tasks.index')
            ->with('success', "Task '{$name}' deleted!");
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->isLocked()) {
            return redirect()->route('tasks.index')
                ->with('error', 'Task is locked!');
        }

        $request->validate([
            'status'       => 'required|in:Pending,In Progress,Submitted,Manager Approved,Approved,Rejected',
            'performed_by' => 'nullable|string|max:100',
        ]);

        $oldStatus = $task->status;
        $newStatus = $request->status;
        $by        = $request->performed_by ?? 'Admin';

        if ($newStatus === 'Rejected') {
            $task->update(['status' => 'In Progress']);
            $this->log($task, 'Task Rejected', $by,
                "Status changed from '{$oldStatus}' → 'In Progress'");
        } else {
            $task->update(['status' => $newStatus]);
            $this->log($task, 'Status Updated', $by,
                "Status changed from '{$oldStatus}' → '{$newStatus}'");
        }

        return redirect()->back()
            ->with('success', 'Status updated successfully!');
    }
}