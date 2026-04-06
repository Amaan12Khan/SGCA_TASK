
<?php $__env->startSection('title', 'Task Details'); ?>
<?php $__env->startSection('content'); ?>

<div style="max-width:900px;">

    <!-- Back button -->
    <a href="<?php echo e(route('tasks.index')); ?>"
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
                            <?php echo e($task->title); ?>

                            <?php if($task->isLocked()): ?>
                                <span style="color:var(--success);">🔒</span>
                            <?php endif; ?>
                        </div>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <span class="badge <?php echo e(str_replace(' ', '-', $task->status)); ?>">
                                <span class="badge-dot"></span><?php echo e($task->status); ?>

                            </span>
                            <span class="priority-badge <?php echo e($task->priority); ?>"><?php echo e($task->priority); ?></span>
                            <?php if($task->overdue): ?>
                                <span class="badge overdue-tag">🚨 Overdue</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if(!$task->isLocked()): ?>
                    <a href="<?php echo e(route('tasks.edit', $task)); ?>" class="btn-primary">✏️ Edit</a>
                    <?php endif; ?>
                </div>

                <!-- Progress -->
                <div style="margin-bottom:24px;">
                    <div style="display:flex;justify-content:space-between;
                        font-size:13px;color:var(--text-muted);margin-bottom:8px;">
                        <span>Progress</span>
                        <span><?php echo e($task->progress); ?>%</span>
                    </div>
                    <div style="height:8px;background:var(--border);border-radius:4px;overflow:hidden;">
                        <div style="height:100%;width:<?php echo e($task->progress); ?>%;
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
                        <?php
                            $steps = ['Pending','In Progress','Submitted','Manager Approved','Approved'];
                            $currentIndex = array_search($task->status, $steps);
                            if($task->status === 'Rejected') $currentIndex = 2;
                        ?>
                        <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div style="display:flex;align-items:center;">
                                <div style="text-align:center;">
                                    <div style="width:28px;height:28px;border-radius:50%;
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:12px;font-weight:700;
                                        background:<?php echo e($i <= $currentIndex ? 'var(--accent)' : 'var(--border)'); ?>;
                                        color:<?php echo e($i <= $currentIndex ? 'white' : 'var(--text-muted)'); ?>;">
                                        <?php echo e($i < $currentIndex ? '✓' : $i+1); ?>

                                    </div>
                                    <div style="font-size:9px;color:var(--text-muted);
                                        margin-top:4px;width:60px;text-align:center;
                                        white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        <?php echo e($step); ?>

                                    </div>
                                </div>
                                <?php if(!$loop->last): ?>
                                <div style="height:2px;width:30px;
                                    background:<?php echo e($i < $currentIndex ? 'var(--accent)' : 'var(--border)'); ?>;
                                    margin-bottom:16px;"></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Description -->
                <?php if($task->description): ?>
                <div style="margin-bottom:20px;">
                    <div style="font-size:13px;font-weight:600;color:var(--text-muted);margin-bottom:8px;">
                        DESCRIPTION
                    </div>
                    <div style="font-size:14px;color:var(--text-secondary);line-height:1.7;">
                        <?php echo e($task->description); ?>

                    </div>
                </div>
                <?php endif; ?>

                <!-- Notes -->
                <?php if($task->notes): ?>
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--text-muted);margin-bottom:8px;">
                        NOTES
                    </div>
                    <div style="background:var(--bg-primary);border:1px solid var(--border);
                        border-radius:8px;padding:14px;font-size:14px;
                        color:var(--text-secondary);line-height:1.7;">
                        <?php echo e($task->notes); ?>

                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Update Status -->
            <?php if(!$task->isLocked()): ?>
            <div class="card">
                <div class="section-title">🔄 Update Status</div>
                <form action="<?php echo e(route('tasks.status', $task)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-grid" style="margin-bottom:16px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">New Status</label>
                            <select name="status" class="form-control">
                                <?php $__currentLoopData = ['Pending','In Progress','Submitted','Manager Approved','Approved','Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s); ?>" <?php echo e($task->status == $s ? 'selected' : ''); ?>>
                                        <?php echo e($s); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <?php endif; ?>
        </div>

        <!-- Right: Details + Activity -->
        <div>
            <!-- Details Card -->
            <div class="card" style="margin-bottom:20px;">
                <div class="section-title">📌 Details</div>
                <div style="display:flex;flex-direction:column;gap:14px;">
                    <div>
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;">ASSIGNED TO</div>
                        <div style="font-weight:600;"><?php echo e($task->assigned_to); ?></div>
                        <div style="font-size:12px;color:var(--text-muted);"><?php echo e($task->assigned_role); ?></div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;">DEADLINE</div>
                        <div style="font-weight:600;"><?php echo e($task->deadline->format('d M Y')); ?></div>
                        <?php $d = $task->daysLeft; ?>
                        <span class="days-chip <?php echo e($d < 0 ? 'urgent' : ($d <= 3 ? 'soon' : 'ok')); ?>">
                            <?php echo e($d < 0 ? abs($d).' days overdue' : $d.' days remaining'); ?>

                        </span>
                    </div>
                    <div>
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;">CREATED</div>
                        <div style="font-weight:600;"><?php echo e($task->created_at->format('d M Y')); ?></div>
                        <div style="font-size:12px;color:var(--text-muted);"><?php echo e($task->created_at->diffForHumans()); ?></div>
                    </div>
                    <div>
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;">LAST UPDATED</div>
                        <div style="font-size:12px;color:var(--text-muted);"><?php echo e($task->updated_at->diffForHumans()); ?></div>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="card">
                <div class="section-title">📜 Activity Log</div>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div style="flex:1;">
                        <div class="activity-action"><?php echo e($log->action); ?></div>
                        <div class="activity-details"><?php echo e($log->details); ?></div>
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">
                            by <?php echo e($log->performed_by); ?> · <?php echo e($log->created_at->diffForHumans()); ?>

                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="text-align:center;color:var(--text-muted);padding:20px;font-size:13px;">
                    No activity yet
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\myapp\resources\views/tasks/show.blade.php ENDPATH**/ ?>