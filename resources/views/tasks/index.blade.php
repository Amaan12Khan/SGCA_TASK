@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-icon">📋</div>
        <div class="stat-number">{{ $total }}</div>
        <div class="stat-label">Total Tasks</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon">⏳</div>
        <div class="stat-number">{{ $pending }}</div>
        <div class="stat-label">Pending Tasks</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon">📤</div>
        <div class="stat-number">{{ $awaiting }}</div>
        <div class="stat-label">Awaiting Approval</div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon">🚨</div>
        <div class="stat-number">{{ $overdue }}</div>
        <div class="stat-label">Overdue Tasks</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon">✅</div>
        <div class="stat-number">{{ $approved }}</div>
        <div class="stat-label">Approved</div>
    </div>
</div>

<div class="grid-2">
<!-- Tasks Table -->
<div>
<div class="table-wrapper">
    <div class="table-header">
        <div class="table-title">📋 All Tasks</div>
        <form method="GET" action="{{ route('tasks.index') }}" style="display:contents;">
            <div class="filters">
                <input type="text" name="search" class="filter-input"
                    placeholder="🔍 Search tasks..." value="{{ request('search') }}">
                <select name="status" class="filter-input">
                    <option value="">All Status</option>
                    @foreach(['Pending','In Progress','Submitted','Manager Approved','Approved','Rejected'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                <select name="priority" class="filter-input">
                    <option value="">All Priority</option>
                    @foreach(['High','Medium','Low'] as $p)
                        <option value="{{ $p }}" {{ request('priority') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
                <button type="submit" class="filter-btn">Filter</button>
                <a href="{{ route('tasks.index') }}" class="reset-btn">✕</a>
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th>Assigned To</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Deadline</th>
                <th>Update Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tasks as $task)
        <tr class="{{ $task->overdue ? 'overdue' : '' }}">
            <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
            <td>
                <div style="font-weight:600;">
                    {{ $task->title }}
                    @if($task->overdue)
                        <span class="badge overdue-tag">🚨 Overdue</span>
                    @endif
                    @if($task->isLocked())
                        <span style="color:var(--success);">🔒</span>
                    @endif
                </div>
                @if($task->description)
                <div style="font-size:12px;color:var(--text-muted);margin-top:3px;">
                    {{ Str::limit($task->description, 40) }}
                </div>
                @endif
            </td>
            <td>
                <div style="font-weight:500;">{{ $task->assigned_to }}</div>
                <div style="font-size:11px;color:var(--text-muted);">{{ $task->assigned_role }}</div>
            </td>
            <td><span class="priority-badge {{ $task->priority }}">{{ $task->priority }}</span></td>
            <td>
                <span class="badge {{ str_replace(' ', '-', $task->status) }}">
                    <span class="badge-dot"></span>{{ $task->status }}
                </span>
            </td>
            <td>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $task->progress }}%"></div>
                </div>
                <div style="font-size:10px;color:var(--text-muted);margin-top:3px;">{{ $task->progress }}%</div>
            </td>
            <td>
                <div>{{ $task->deadline->format('d M Y') }}</div>
                @php $d = $task->daysLeft; @endphp
                @if(!$task->isLocked())
                    <span class="days-chip {{ $d < 0 ? 'urgent' : ($d <= 3 ? 'soon' : 'ok') }}">
                        {{ $d < 0 ? abs($d).' days ago' : $d.' days left' }}
                    </span>
                @endif
            </td>
            <td>
                @if(!$task->isLocked())
                <form action="{{ route('tasks.status', $task) }}" method="POST"
                    style="display:flex;gap:6px;align-items:center;">
                    @csrf
                    <input type="hidden" name="performed_by" value="Admin">
                    <select name="status" class="status-select">
                        @foreach(['Pending','In Progress','Submitted','Manager Approved','Approved','Rejected'] as $s)
                            <option value="{{ $s }}" {{ $task->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-icon success" title="Save">💾</button>
                </form>
                @else
                    <span style="color:var(--success);font-size:13px;">🔒 Locked</span>
                @endif
            </td>
            <td>
                <div class="action-btns">
                    <a href="{{ route('tasks.show', $task) }}" class="btn-icon" title="View">👁️</a>
                    @if(!$task->isLocked())
                        <a href="{{ route('tasks.edit', $task) }}" class="btn-icon" title="Edit">✏️</a>
                        <button class="btn-icon danger" title="Delete"
                            onclick="confirmDelete('{{ route('tasks.destroy', $task) }}')">🗑️</button>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9">
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <div>No tasks found</div>
                    <div style="font-size:13px;margin-top:6px;">
                        <a href="{{ route('tasks.create') }}" style="color:var(--accent);">Create your first task</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>
</div>

<!-- Activity Log -->
<div>
    <div class="card">
        <div class="section-title">📜 Activity Log</div>
        @forelse($recentLogs as $log)
        <div class="activity-item">
            <div class="activity-dot"></div>
            <div style="flex:1;">
                <div class="activity-action">{{ $log->action }}</div>
                <div class="activity-details">{{ $log->details }}</div>
                <div style="font-size:11px;color:var(--text-muted);margin-top:3px;">
                    by {{ $log->performed_by }}
                </div>
            </div>
            <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
        </div>
        @empty
        <div style="text-align:center;color:var(--text-muted);padding:20px;font-size:13px;">
            No activity yet
        </div>
        @endforelse
    </div>
</div>
</div>

@endsection