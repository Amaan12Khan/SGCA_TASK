
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-icon">📋</div>
        <div class="stat-number"><?php echo e($total); ?></div>
        <div class="stat-label">Total Tasks</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon">⏳</div>
        <div class="stat-number"><?php echo e($pending); ?></div>
        <div class="stat-label">Pending Tasks</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon">📤</div>
        <div class="stat-number"><?php echo e($awaiting); ?></div>
        <div class="stat-label">Awaiting Approval</div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon">🚨</div>
        <div class="stat-number"><?php echo e($overdue); ?></div>
        <div class="stat-label">Overdue Tasks</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon">✅</div>
        <div class="stat-number"><?php echo e($approved); ?></div>
        <div class="stat-label">Approved</div>
    </div>
</div>

<div class="grid-2">
<!-- Tasks Table -->
<div>
<div class="table-wrapper">
    <div class="table-header">
        <div class="table-title">📋 All Tasks</div>
        <form method="GET" action="<?php echo e(route('tasks.index')); ?>" style="display:contents;">
            <div class="filters">
                <input type="text" name="search" class="filter-input"
                    placeholder="🔍 Search tasks..." value="<?php echo e(request('search')); ?>">
                <select name="status" class="filter-input">
                    <option value="">All Status</option>
                    <?php $__currentLoopData = ['Pending','In Progress','Submitted','Manager Approved','Approved','Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(request('status') == $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select name="priority" class="filter-input">
                    <option value="">All Priority</option>
                    <?php $__currentLoopData = ['High','Medium','Low']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p); ?>" <?php echo e(request('priority') == $p ? 'selected' : ''); ?>><?php echo e($p); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="filter-btn">Filter</button>
                <a href="<?php echo e(route('tasks.index')); ?>" class="reset-btn">✕</a>
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
        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr class="<?php echo e($task->overdue ? 'overdue' : ''); ?>">
            <td style="color:var(--text-muted);"><?php echo e($loop->iteration); ?></td>
            <td>
                <div style="font-weight:600;">
                    <?php echo e($task->title); ?>

                    <?php if($task->overdue): ?>
                        <span class="badge overdue-tag">🚨 Overdue</span>
                    <?php endif; ?>
                    <?php if($task->isLocked()): ?>
                        <span style="color:var(--success);">🔒</span>
                    <?php endif; ?>
                </div>
                <?php if($task->description): ?>
                <div style="font-size:12px;color:var(--text-muted);margin-top:3px;">
                    <?php echo e(Str::limit($task->description, 40)); ?>

                </div>
                <?php endif; ?>
            </td>
            <td>
                <div style="font-weight:500;"><?php echo e($task->assigned_to); ?></div>
                <div style="font-size:11px;color:var(--text-muted);"><?php echo e($task->assigned_role); ?></div>
            </td>
            <td><span class="priority-badge <?php echo e($task->priority); ?>"><?php echo e($task->priority); ?></span></td>
            <td>
                <span class="badge <?php echo e(str_replace(' ', '-', $task->status)); ?>">
                    <span class="badge-dot"></span><?php echo e($task->status); ?>

                </span>
            </td>
            <td>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:<?php echo e($task->progress); ?>%"></div>
                </div>
                <div style="font-size:10px;color:var(--text-muted);margin-top:3px;"><?php echo e($task->progress); ?>%</div>
            </td>
            <td>
                <div><?php echo e($task->deadline->format('d M Y')); ?></div>
                <?php $d = $task->daysLeft; ?>
                <?php if(!$task->isLocked()): ?>
                    <span class="days-chip <?php echo e($d < 0 ? 'urgent' : ($d <= 3 ? 'soon' : 'ok')); ?>">
                        <?php echo e($d < 0 ? abs($d).' days ago' : $d.' days left'); ?>

                    </span>
                <?php endif; ?>
            </td>
            <td>
                <?php if(!$task->isLocked()): ?>
                <form action="<?php echo e(route('tasks.status', $task)); ?>" method="POST"
                    style="display:flex;gap:6px;align-items:center;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="performed_by" value="Admin">
                    <select name="status" class="status-select">
                        <?php $__currentLoopData = ['Pending','In Progress','Submitted','Manager Approved','Approved','Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e($task->status == $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="btn-icon success" title="Save">💾</button>
                </form>
                <?php else: ?>
                    <span style="color:var(--success);font-size:13px;">🔒 Locked</span>
                <?php endif; ?>
            </td>
            <td>
                <div class="action-btns">
                    <a href="<?php echo e(route('tasks.show', $task)); ?>" class="btn-icon" title="View">👁️</a>
                    <?php if(!$task->isLocked()): ?>
                        <a href="<?php echo e(route('tasks.edit', $task)); ?>" class="btn-icon" title="Edit">✏️</a>
                        <button class="btn-icon danger" title="Delete"
                            onclick="confirmDelete('<?php echo e(route('tasks.destroy', $task)); ?>')">🗑️</button>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="9">
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <div>No tasks found</div>
                    <div style="font-size:13px;margin-top:6px;">
                        <a href="<?php echo e(route('tasks.create')); ?>" style="color:var(--accent);">Create your first task</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</div>

<!-- Activity Log -->
<div>
    <div class="card">
        <div class="section-title">📜 Activity Log</div>
        <?php $__empty_1 = true; $__currentLoopData = $recentLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="activity-item">
            <div class="activity-dot"></div>
            <div style="flex:1;">
                <div class="activity-action"><?php echo e($log->action); ?></div>
                <div class="activity-details"><?php echo e($log->details); ?></div>
                <div style="font-size:11px;color:var(--text-muted);margin-top:3px;">
                    by <?php echo e($log->performed_by); ?>

                </div>
            </div>
            <div class="activity-time"><?php echo e($log->created_at->diffForHumans()); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="text-align:center;color:var(--text-muted);padding:20px;font-size:13px;">
            No activity yet
        </div>
        <?php endif; ?>
    </div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\myapp\resources\views/tasks/index.blade.php ENDPATH**/ ?>