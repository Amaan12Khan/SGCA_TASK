@extends('layouts.app')
@section('title', 'Create Task')
@section('content')

<div style="max-width:700px;">

    <a href="{{ route('tasks.index') }}"
        style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted);
        text-decoration:none;font-size:14px;margin-bottom:20px;">
        ← Back to Dashboard
    </a>

    <div class="card">
        <div style="margin-bottom:28px;">
            <div style="font-size:22px;font-weight:800;margin-bottom:6px;">➕ Create New Task</div>
            <div style="color:var(--text-muted);font-size:14px;">
                Fill in the details below to create and assign a new task.
            </div>
        </div>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Task Title *</label>
                    <input type="text" name="title" class="form-control"
                        placeholder="e.g. Design Login Page"
                        value="{{ old('title') }}" />
                    @error('title')
                        <div class="form-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-control">
                        <option value="">-- Select Priority --</option>
                        @foreach(['High','Medium','Low'] as $p)
                            <option value="{{ $p }}"
                                {{ old('priority') == $p ? 'selected' : '' }}>
                                {{ $p }}
                            </option>
                        @endforeach
                    </select>
                    @error('priority')
                        <div class="form-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"
                    placeholder="Describe the task in detail...">{{ old('description') }}</textarea>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Assigned To *</label>
                    <input type="text" name="assigned_to" class="form-control"
                        placeholder="Employee name"
                        value="{{ old('assigned_to') }}" />
                    @error('assigned_to')
                        <div class="form-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="assigned_role" class="form-control">
                        <option value="">-- Select Role --</option>
                        @foreach(['Employee','Manager','Admin'] as $r)
                            <option value="{{ $r }}"
                                {{ old('assigned_role') == $r ? 'selected' : '' }}>
                                {{ $r }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_role')
                        <div class="form-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Deadline *</label>
                    <input type="date" name="deadline" class="form-control"
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('deadline') }}" />
                    @error('deadline')
                        <div class="form-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Notes (Optional)</label>
                    <input type="text" name="notes" class="form-control"
                        placeholder="Any additional notes..."
                        value="{{ old('notes') }}" />
                </div>
            </div>

            <!-- Approval Flow Info -->
            <div style="background:var(--bg-primary);border:1px solid var(--border);
                border-radius:10px;padding:16px;margin-bottom:24px;">
                <div style="font-size:13px;font-weight:600;
                    color:var(--text-muted);margin-bottom:10px;">
                    ℹ️ APPROVAL WORKFLOW
                </div>
                <div style="display:flex;align-items:center;gap:8px;
                    flex-wrap:wrap;font-size:13px;color:var(--text-secondary);">
                    <span style="background:var(--bg-card);border:1px solid var(--border);
                        padding:4px 10px;border-radius:6px;">Pending</span>
                    <span style="color:var(--text-muted);">→</span>
                    <span style="background:var(--bg-card);border:1px solid var(--border);
                        padding:4px 10px;border-radius:6px;">In Progress</span>
                    <span style="color:var(--text-muted);">→</span>
                    <span style="background:var(--bg-card);border:1px solid var(--border);
                        padding:4px 10px;border-radius:6px;">Submitted</span>
                    <span style="color:var(--text-muted);">→</span>
                    <span style="background:var(--bg-card);border:1px solid var(--border);
                        padding:4px 10px;border-radius:6px;">Manager Approved</span>
                    <span style="color:var(--text-muted);">→</span>
                    <span style="background:rgba(16,185,129,0.15);
                        border:1px solid var(--success);color:var(--success);
                        padding:4px 10px;border-radius:6px;">Approved ✓</span>
                </div>
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn-primary" style="padding:12px 32px;">
                    ➕ Create Task
                </button>
                <a href="{{ route('tasks.index') }}"
                    style="padding:12px 24px;border-radius:8px;
                    background:var(--bg-primary);border:1px solid var(--border);
                    color:var(--text-secondary);text-decoration:none;font-size:14px;
                    display:inline-flex;align-items:center;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection