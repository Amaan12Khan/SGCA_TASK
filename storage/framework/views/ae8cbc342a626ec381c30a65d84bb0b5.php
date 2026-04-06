
<?php $__env->startSection('title', 'Create Task'); ?>
<?php $__env->startSection('content'); ?>

<div style="max-width:700px;">

    <a href="<?php echo e(route('tasks.index')); ?>"
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

        <form action="<?php echo e(route('tasks.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Task Title *</label>
                    <input type="text" name="title" class="form-control"
                        placeholder="e.g. Design Login Page"
                        value="<?php echo e(old('title')); ?>" />
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error">⚠️ <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-control">
                        <option value="">-- Select Priority --</option>
                        <?php $__currentLoopData = ['High','Medium','Low']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>"
                                <?php echo e(old('priority') == $p ? 'selected' : ''); ?>>
                                <?php echo e($p); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error">⚠️ <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"
                    placeholder="Describe the task in detail..."><?php echo e(old('description')); ?></textarea>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Assigned To *</label>
                    <input type="text" name="assigned_to" class="form-control"
                        placeholder="Employee name"
                        value="<?php echo e(old('assigned_to')); ?>" />
                    <?php $__errorArgs = ['assigned_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error">⚠️ <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="assigned_role" class="form-control">
                        <option value="">-- Select Role --</option>
                        <?php $__currentLoopData = ['Employee','Manager','Admin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r); ?>"
                                <?php echo e(old('assigned_role') == $r ? 'selected' : ''); ?>>
                                <?php echo e($r); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['assigned_role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error">⚠️ <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Deadline *</label>
                    <input type="date" name="deadline" class="form-control"
                        min="<?php echo e(date('Y-m-d')); ?>"
                        value="<?php echo e(old('deadline')); ?>" />
                    <?php $__errorArgs = ['deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error">⚠️ <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Notes (Optional)</label>
                    <input type="text" name="notes" class="form-control"
                        placeholder="Any additional notes..."
                        value="<?php echo e(old('notes')); ?>" />
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
                <a href="<?php echo e(route('tasks.index')); ?>"
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\myapp\resources\views/tasks/create.blade.php ENDPATH**/ ?>