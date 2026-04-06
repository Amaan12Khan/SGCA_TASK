<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync Pro — @yield('title', 'Dashboard')</title>
    <style>
        :root[data-theme="dark"] {
            --bg-primary: #0f1117;
            --bg-secondary: #1a1d27;
            --bg-card: #1e2130;
            --bg-hover: #252840;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border: #2d3148;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --accent-glow: rgba(99,102,241,0.3);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --purple: #8b5cf6;
            --sidebar-width: 260px;
        }
        :root[data-theme="light"] {
            --bg-primary: #f1f5f9;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-hover: #f8fafc;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --accent-glow: rgba(99,102,241,0.15);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --purple: #8b5cf6;
            --sidebar-width: 260px;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-secondary);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
            transition: all 0.3s ease;
        }
        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--accent), var(--purple));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; box-shadow: 0 0 15px var(--accent-glow);
        }
        .logo-text { font-size: 18px; font-weight: 700; color: var(--text-primary); }
        .logo-sub { font-size: 11px; color: var(--text-muted); }
        .sidebar-nav { padding: 20px 12px; flex: 1; }
        .nav-section-title {
            font-size: 10px; font-weight: 600;
            color: var(--text-muted); text-transform: uppercase;
            letter-spacing: 1px; padding: 0 8px; margin-bottom: 8px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 8px;
            color: var(--text-secondary); text-decoration: none;
            font-size: 14px; font-weight: 500;
            margin-bottom: 2px; transition: all 0.2s;
            cursor: pointer; border: none; background: none; width: 100%;
        }
        .nav-item:hover, .nav-item.active {
            background: var(--accent-glow);
            color: var(--accent);
        }
        .nav-item .icon { font-size: 16px; width: 20px; text-align: center; }
        .nav-item .badge-count {
            margin-left: auto; background: var(--accent);
            color: white; font-size: 10px; padding: 2px 7px;
            border-radius: 10px; font-weight: 600;
        }
        .sidebar-bottom {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }

        /* Main */
        .main {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .topbar {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border);
            padding: 16px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 20px; font-weight: 700; }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }
        .theme-toggle {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            padding: 8px 14px; border-radius: 8px;
            cursor: pointer; font-size: 14px;
            transition: all 0.2s; display: flex; align-items: center; gap: 6px;
        }
        .theme-toggle:hover { border-color: var(--accent); color: var(--accent); }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--purple));
            color: white; border: none; padding: 9px 18px;
            border-radius: 8px; cursor: pointer; font-size: 14px;
            font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
            transition: all 0.2s; box-shadow: 0 0 15px var(--accent-glow);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 20px var(--accent-glow); }
        .content { padding: 30px; flex: 1; }

        /* Toast */
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .toast {
            padding: 14px 20px; border-radius: 10px; margin-bottom: 10px;
            font-size: 14px; font-weight: 500; min-width: 280px;
            display: flex; align-items: center; gap: 10px;
            animation: slideIn 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .toast.success { background: var(--success); color: white; }
        .toast.error { background: var(--danger); color: white; }
        @keyframes slideIn {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Cards */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.2s;
        }
        .card:hover { border-color: var(--accent); box-shadow: 0 0 20px var(--accent-glow); }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.2); }
        .stat-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 3px;
        }
        .stat-card.blue::before { background: var(--info); }
        .stat-card.orange::before { background: var(--warning); }
        .stat-card.purple::before { background: var(--purple); }
        .stat-card.red::before { background: var(--danger); }
        .stat-card.green::before { background: var(--success); }
        .stat-number { font-size: 32px; font-weight: 800; margin-bottom: 4px; }
        .stat-card.blue .stat-number { color: var(--info); }
        .stat-card.orange .stat-number { color: var(--warning); }
        .stat-card.purple .stat-number { color: var(--purple); }
        .stat-card.red .stat-number { color: var(--danger); }
        .stat-card.green .stat-number { color: var(--success); }
        .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 500; }
        .stat-icon { position: absolute; right: 16px; top: 16px; font-size: 28px; opacity: 0.2; }

        /* Table */
        .table-wrapper {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        .table-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .table-title { font-size: 16px; font-weight: 700; }
        .filters { display: flex; gap: 10px; flex-wrap: wrap; }
        .filter-input {
            background: var(--bg-primary);
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 8px 14px; border-radius: 8px;
            font-size: 13px; outline: none;
            transition: border-color 0.2s;
        }
        .filter-input:focus { border-color: var(--accent); }
        .filter-btn {
            background: var(--accent);
            color: white; border: none;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13px; cursor: pointer;
            transition: background 0.2s;
        }
        .filter-btn:hover { background: var(--accent-hover); }
        .reset-btn {
            background: var(--bg-primary);
            color: var(--text-secondary);
            border: 1px solid var(--border);
            padding: 8px 14px; border-radius: 8px;
            font-size: 13px; cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center;
        }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: var(--bg-primary); }
        th {
            padding: 12px 16px; text-align: left;
            font-size: 11px; font-weight: 600;
            color: var(--text-muted); text-transform: uppercase;
            letter-spacing: 0.5px; border-bottom: 1px solid var(--border);
        }
        td { padding: 14px 16px; border-bottom: 1px solid var(--border); font-size: 14px; }
        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: var(--bg-hover); }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr.overdue { background: rgba(239,68,68,0.05); }
        tbody tr.overdue:hover { background: rgba(239,68,68,0.1); }

        /* Badges */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; }
        .badge.Pending { background: rgba(245,158,11,0.15); color: var(--warning); }
        .badge.Pending .badge-dot { background: var(--warning); }
        .badge.In-Progress { background: rgba(59,130,246,0.15); color: var(--info); }
        .badge.In-Progress .badge-dot { background: var(--info); }
        .badge.Submitted { background: rgba(139,92,246,0.15); color: var(--purple); }
        .badge.Submitted .badge-dot { background: var(--purple); }
        .badge.Manager-Approved { background: rgba(16,185,129,0.15); color: var(--success); }
        .badge.Manager-Approved .badge-dot { background: var(--success); }
        .badge.Approved { background: rgba(16,185,129,0.2); color: var(--success); }
        .badge.Approved .badge-dot { background: var(--success); }
        .badge.Rejected { background: rgba(239,68,68,0.15); color: var(--danger); }
        .badge.Rejected .badge-dot { background: var(--danger); }
        .badge.overdue-tag { background: rgba(239,68,68,0.2); color: var(--danger); margin-left: 6px; }
        .priority-badge {
            display: inline-block; padding: 3px 10px;
            border-radius: 6px; font-size: 11px; font-weight: 700;
        }
        .priority-badge.High { background: rgba(239,68,68,0.15); color: var(--danger); }
        .priority-badge.Medium { background: rgba(245,158,11,0.15); color: var(--warning); }
        .priority-badge.Low { background: rgba(16,185,129,0.15); color: var(--success); }

        /* Progress bar */
        .progress-bar {
            width: 80px; height: 6px;
            background: var(--border); border-radius: 3px; overflow: hidden;
        }
        .progress-fill {
            height: 100%; border-radius: 3px;
            background: linear-gradient(90deg, var(--accent), var(--purple));
            transition: width 0.3s;
        }

        /* Action buttons */
        .action-btns { display: flex; gap: 6px; align-items: center; }
        .btn-icon {
            width: 30px; height: 30px; border-radius: 7px;
            border: 1px solid var(--border); background: var(--bg-primary);
            color: var(--text-secondary); cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 13px; text-decoration: none; transition: all 0.2s;
        }
        .btn-icon:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-glow); }
        .btn-icon.danger:hover { border-color: var(--danger); color: var(--danger); background: rgba(239,68,68,0.1); }
        .btn-icon.success:hover { border-color: var(--success); color: var(--success); background: rgba(16,185,129,0.1); }

        /* Status select */
        .status-select {
            background: var(--bg-primary);
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 5px 10px; border-radius: 7px;
            font-size: 12px; outline: none; cursor: pointer;
        }

        /* Activity log */
        .activity-item {
            display: flex; gap: 12px; align-items: flex-start;
            padding: 10px 0; border-bottom: 1px solid var(--border);
        }
        .activity-item:last-child { border-bottom: none; }
        .activity-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--accent); margin-top: 5px; flex-shrink: 0;
        }
        .activity-action { font-size: 13px; font-weight: 600; }
        .activity-details { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .activity-time { font-size: 11px; color: var(--text-muted); margin-left: auto; white-space: nowrap; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 7px; font-size: 13px; font-weight: 600; color: var(--text-secondary); }
        .form-control {
            width: 100%; padding: 10px 14px;
            background: var(--bg-primary); border: 1px solid var(--border);
            color: var(--text-primary); border-radius: 8px;
            font-size: 14px; outline: none; transition: border-color 0.2s;
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
        textarea.form-control { height: 100px; resize: vertical; }
        .form-error { color: var(--danger); font-size: 12px; margin-top: 5px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);
            z-index: 1000; display: none;
            align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; padding: 28px; max-width: 420px; width: 90%;
            animation: modalIn 0.2s ease;
        }
        @keyframes modalIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 10px; }
        .modal-body { color: var(--text-secondary); font-size: 14px; margin-bottom: 24px; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
        .btn-cancel {
            padding: 9px 18px; border-radius: 8px;
            background: var(--bg-primary); border: 1px solid var(--border);
            color: var(--text-secondary); cursor: pointer; font-size: 14px;
        }
        .btn-danger {
            padding: 9px 18px; border-radius: 8px;
            background: var(--danger); border: none;
            color: white; cursor: pointer; font-size: 14px; font-weight: 600;
        }

        /* Days left chip */
        .days-chip {
            font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;
        }
        .days-chip.urgent { background: rgba(239,68,68,0.15); color: var(--danger); }
        .days-chip.soon { background: rgba(245,158,11,0.15); color: var(--warning); }
        .days-chip.ok { background: rgba(16,185,129,0.15); color: var(--success); }

        .section-title {
            font-size: 16px; font-weight: 700;
            margin-bottom: 16px; display: flex;
            align-items: center; gap: 8px;
        }
        .empty-state {
            text-align: center; padding: 50px 20px;
            color: var(--text-muted);
        }
        .empty-state .empty-icon { font-size: 48px; margin-bottom: 12px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 350px; gap: 20px; }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">⚡</div>
        <div>
            <div class="logo-text">TaskSync</div>
            <div class="logo-sub">Pro Workflow System</div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-title">Main</div>
        <a href="{{ route('tasks.index') }}" class="nav-item {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
            <span class="icon">📊</span> Dashboard
        </a>
        <a href="{{ route('tasks.create') }}" class="nav-item {{ request()->routeIs('tasks.create') ? 'active' : '' }}">
            <span class="icon">➕</span> New Task
        </a>
        <div class="nav-section-title" style="margin-top:16px;">Filters</div>
        <a href="{{ route('tasks.index', ['status' => 'Pending']) }}" class="nav-item">
            <span class="icon">⏳</span> Pending
        </a>
        <a href="{{ route('tasks.index', ['status' => 'Submitted']) }}" class="nav-item">
            <span class="icon">📤</span> Awaiting Approval
        </a>
        <a href="{{ route('tasks.index', ['status' => 'Approved']) }}" class="nav-item">
            <span class="icon">✅</span> Approved
        </a>
        <a href="{{ route('tasks.index', ['priority' => 'High']) }}" class="nav-item">
            <span class="icon">🔴</span> High Priority
        </a>
    </nav>
    <div class="sidebar-bottom">
        <div style="font-size:12px; color:var(--text-muted); text-align:center;">
            TaskSync Pro v2.0<br>SGCA Technologies
        </div>
    </div>
</aside>

<!-- Main -->
<div class="main">
    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-title">@yield('title', 'Dashboard')</div>
        <div class="topbar-actions">
            <button class="theme-toggle" onclick="toggleTheme()">
                <span id="theme-icon">☀️</span>
                <span id="theme-label">Light</span>
            </button>
            <a href="{{ route('tasks.create') }}" class="btn-primary">
                ➕ New Task
            </a>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-container">
        @if(session('success'))
            <div class="toast success" id="toast">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="toast error" id="toast">❌ {{ session('error') }}</div>
        @endif
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>
</div>

<!-- Delete Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-title">🗑️ Delete Task</div>
        <div class="modal-body">Are you sure you want to delete this task? This action cannot be undone.</div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Theme toggle
    function toggleTheme() {
        const html = document.documentElement;
        const current = html.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        document.getElementById('theme-icon').textContent = next === 'dark' ? '☀️' : '🌙';
        document.getElementById('theme-label').textContent = next === 'dark' ? 'Light' : 'Dark';
    }

    // Load saved theme
    const saved = localStorage.getItem('theme') || 'dark';
    document.documentElement.setAttribute('data-theme', saved);
    if (saved === 'light') {
        document.getElementById('theme-icon').textContent = '🌙';
        document.getElementById('theme-label').textContent = 'Dark';
    }

    // Auto hide toast
    setTimeout(() => {
        const t = document.getElementById('toast');
        if (t) t.style.opacity = '0';
    }, 3500);

    // Delete modal
    function confirmDelete(url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteModal').classList.add('active');
    }
    function closeModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }
</script>

@yield('scripts')
</body>
</html>