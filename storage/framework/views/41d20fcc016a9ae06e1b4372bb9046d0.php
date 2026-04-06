<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Edit Task</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f6f9; }
        .navbar { background: #2c3e50; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 22px; }
        .navbar a { color: white; text-decoration: none; background: #7f8c8d; padding: 8px 16px; border-radius: 5px; }
        .container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 25px; color: #2c3e50; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 6px; font-weight: bold; color: #444; }
        input, select, textarea { width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
        textarea { height: 100px; resize: vertical; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #f39c12; }
        .error { color: #e74c3c; font-size: 13px; margin-top: 4px; }
        .btn-submit { background: #f39c12; color: white; padding: 12px 30px; border: none; border-radius: 6px; font-size: 15px; cursor: pointer; width: 100%; }
        .btn-submit:hover { background: #e67e22; }
        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 13px; font-weight: bold; margin-bottom: 20px; background: #cce5ff; color: #004085; }
    </style>
</head>
<body>
<div class="navbar">
    <h1>⚡ TaskSync</h1>
    <a href="<?php echo e(route('tasks.index')); ?>">← Back to Dashboard</a>
</div>

<div class="container">
    <h2>✏️ Edit Task</h2>
    <div class="status-badge">Current Status: <?php echo e($task->status); ?></div>

    <form action="<?php echo e(route('tasks.update', $task)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-group">
            <label>Task Title *</label>
            <input type="text" name="title" value="<?php echo e(old('title', $task->title)); ?>" />
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description"><?php echo e(old('description', $task->description)); ?></textarea>
        </div>

        <div class="form-group">
            <label>Assigned To *</label>
            <input type="text" name="assigned_to"
                value="<?php echo e(old('assigned_to', $task->assigned_to)); ?>" />
            <?php $__errorArgs = ['assigned_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label>Priority *</label>
            <select name="priority">
                <option value="Low" <?php echo e($task->priority == 'Low' ? 'selected' : ''); ?>>Low</option>
                <option value="Medium" <?php echo e($task->priority == 'Medium' ? 'selected' : ''); ?>>Medium</option>
                <option value="High" <?php echo e($task->priority == 'High' ? 'selected' : ''); ?>>High</option>
            </select>
        </div>

        <div class="form-group">
            <label>Deadline *</label>
            <input type="date" name="deadline"
                value="<?php echo e(old('deadline', $task->deadline->format('Y-m-d'))); ?>" />
            <?php $__errorArgs = ['deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="btn-submit">Update Task</button>
    </form>
</div>
</body>
</html><?php /**PATH C:\laragon\www\myapp\resources\views/tasks/edit.blade.php ENDPATH**/ ?>