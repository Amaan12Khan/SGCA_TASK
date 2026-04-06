@extends('layouts.app')
@section('title', 'Edit Task')
@section('content')

<div style="max-width:700px;">

    <a href="{{ route('tasks.index') }}"
        style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted);
        text-decoration:none;font-size:14px;margin-bottom:20px;">
        ← Back to Dashboard
    </a>

    <div class="card">
        <div style="margin-bottom:28px;">
            <div style="font-size:22px;font-weight:800;margin-bottom:6px;">✏️ Edit Task</div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="color:var(--text-muted);font-size:14px;">Current Status:</div>
                <span class="badge {{ str_replace(' ', '-', $task->status) }}">
                    <span class="badge-dot"></span>{{ $task->status }}
                </span>
            </div>
        </div>

        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Task Title *</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ old('title', $task->title) }}" />
                    @error('title')
                        <div class="form-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-control">
                        @foreach(['High','Medium','Low'] as $p)
                            <option value="{{ $p }}"
                                {{ $task->priority == $p ? 'selected' : '' }}>
                                {{ $p }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Assigned To *</label>
                    <input type="text" name="assigned_to" class="form-control"
                        value="{{ old('assigned_to', $task->assigned_to) }}" />
                    @error('assigned_to')
                        <div class="form-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="assigned_role" class="form-control">
                        @foreach(['Employee','Manager','Admin'] as $r)
                            <option value="{{ $r }}"
                                {{ $task->assigned_role == $r ? 'selected' : '' }}>
                                {{ $r }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Deadline *</label>
                    <input type="date" name="deadline" class="form-control"
                        value="{{ old('deadline', $task->deadline->format('Y-m-d')) }}" />
                    @error('deadline')
                        <div class="form-error">⚠️ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <input type="text" name="notes" class="form-control"
                        value="{{ old('notes', $task->notes) }}" />
                </div>
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn-primary" style="padding:12px 32px;">
                    💾 Save Changes
                </button>
                <a href="{{ route('tasks.show', $task) }}"
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