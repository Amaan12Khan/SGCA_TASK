@extends('layouts.app')
@section('title', 'Task Details')
@section('content')

<div style="max-width:900px;">

    <!-- Back button -->
    <a href="{{ route('tasks.index') }}"
        style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted);
        text-decoration:none;font-size:14px;margin-bottom:20px;">
        ← Back to Dashboard
    </a>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;">

        <!-- Left: Task Info -->
        <div>
            <div class="card" style="margin-bottom:20px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;">
                    <div>
                        <div style="font-size:22px;font-weight:800;margin-bottom:8px;">
                            {{ $task->title }}
                            @if($task->isLocked())
                                <span style="color:var(--success);">🔒</span>
                            @endif
                        </div>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <span class="badge {{ str_replace(' ', '-', $task->status) }}">
                                <span class="badge-dot"></span>{{ $task->status }}
                            </span>
                            <span class="priority-badge {{ $task->priority }}">{{ $task->priority }}</span>
                            @if($task->overdue)
                                <span class="badge overdue-tag">🚨 Overdue</span>
                            @endif
                        </div>
                    </div>
                    @if(!$task->isLocked())
                    <a href="{{ route('tasks.edit', $task) }}" class="btn-primary">✏️ Edit</a>
                    @endif
                </div>

                <!-- Progress -->
                <div style="margin-bottom:24px;">
                    <div style="display:flex;justify-content:space-between;
                        font-size:13px;color:var(--text-muted);margin-bottom:8px;">
                        <span>Progress</span>
                        <span>{{ $task->progress }}%</span>
                    </div>
                    <div style="height:8px;background:var(--border);border-radius:4px;overflow:hidden;">
                        <div style="height:100%;width:{{ $task->progress }}%;
                            background:linear-gradient(90deg,var(--accent),var(--purple));
                            border-radius:4px;transition:width 0.5s;"></div>
                    </div>
                </div>

                <!-- Workflow Steps -->
                <div style="margin-bottom:24px;">
                    <div style="font-size:13px;font-weight:600;color:var(--text-muted);margin-bottom:12px;">
                        WORKFLOW
                    </div>
                    <div style="display:flex;align-items:center;gap:0;">
                        @php
                            $steps = ['Pending','In Progress','Submitted','Manager Approved','Approved'];
                            $currentIndex = array_search($task->status, $steps);
                            if($task->status === 'Rejected') $currentIndex = 2;
                        @endphp
                        @foreach($steps as $i => $step)
                            <div style="display:flex;align-items:center;">
                                <div style="text-align:center;">
                                    <div style="width:28px;height:28px;border-radius:50%;
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:12px;font-weight:700;
                                        background:{{ $i <= $currentIndex ? 'var(--accent)' : 'var(--border)' }};
                                        color:{{ $i <= $currentIndex ? 'white' : 'var(--text-muted)' }};">
                                        {{ $i < $currentIndex ? '✓' : $i+1 }}
                                    </div>
                                    <div style="font-size:9px;color:var(--text-muted);
                                        margin-top:4px;width:60px;text-align:center;
                                        white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        {{ $step }}
                                    </div>
                                </div>
                                @if(!$loop->last)
                                <div style="height:2px;width:30px;
                                    background:{{ $i < $currentIndex ? 'var(--accent)' : 'var(--border)' }};
                                    margin-bottom:16px;"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Description -->
                @if($task->description)
                <div style="margin-bottom:20px;">
                    <div style="font-size:13px;font-weight:600;color:var(--text-muted);margin-bottom:8px;">
                        DESCRIPTION
                    </div>
                    <div style="font-size:14px;color:var(--text-secondary);line-height:1.7;">
                        {{ $task->description }}
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($task->notes)
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--text-muted);margin-bottom:8px;">
                        NOTES
                    </div>
                    <div style="background:var(--bg-primary);border:1px solid var(--border);
                        border-radius:8px;padding:14px;font-size:14px;
                        color:var(--text-secondary);line-height:1.7;">
                        {{ $task->notes }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Update Status -->
            @if(!$task->isLocked())
            <div class="card">
                <div class="section-title">🔄 Update Status</div>
                <form action="{{ route('tasks.status', $task) }}" method="POST">
                    @csrf
                    <div class="form-grid" style="margin-bottom:16px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">New Status</label>
                            <select name="status" class="form-control">
                                @foreach(['Pending','In Progress','Submitted','Manager Approved','Approved','Rejected'] as $s)
                                    <option value="{{ $s }}" {{ $task->status == $s ? 'selected' : '' }}>
                                        {{ $s }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Performed By</label>
                            <select name="performed_by" class="form-control">
                                <option value="Admin">Admin</option>
                                <option value="Manager">Manager</option>
                                <option value="Employee">Employee</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Update Status</button>
                </form>
            </div>
            @endif
        </div>

        <!-- Right: Details + Activity -->
        <div>
            <!-- Details Card -->
            <div class="card" style="margin-bottom:20px;">
                <div class="section-title">📌 Details</div>
                <div style="display:flex;flex-direction:column;gap:14px;">
                    <div>
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;">ASSIGNED TO</div>
                        <div style="font-weight:600;">{{ $task->assigned_to }}</div>
                        <div style="font-size:12px;color:var(--text-muted);">{{ $task->assigned_role }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;">DEADLINE</div>
                        <div style="font-weight:600;">{{ $task->deadline->format('d M Y') }}</div>
                        @php $d = $task->daysLeft; @endphp
                        <span class="days-chip {{ $d < 0 ? 'urgent' : ($d <= 3 ? 'soon' : 'ok') }}">
                            {{ $d < 0 ? abs($d).' days overdue' : $d.' days remaining' }}
                        </span>
                    </div>
                    <div>
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;">CREATED</div>
                        <div style="font-weight:600;">{{ $task->created_at->format('d M Y') }}</div>
                        <div style="font-size:12px;color:var(--text-muted);">{{ $task->created_at->diffForHumans() }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;">LAST UPDATED</div>
                        <div style="font-size:12px;color:var(--text-muted);">{{ $task->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="card">
                <div class="section-title">📜 Activity Log</div>
                @forelse($logs as $log)
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div style="flex:1;">
                        <div class="activity-action">{{ $log->action }}</div>
                        <div class="activity-details">{{ $log->details }}</div>
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">
                            by {{ $log->performed_by }} · {{ $log->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;color:var(--text-muted);padding:20px;font-size:13px;">
                    No activity yet
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection