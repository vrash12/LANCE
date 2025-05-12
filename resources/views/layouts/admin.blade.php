<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FabellaCares – Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --fc-green: #0e4749;      /* sidebar background */
            --fc-green-light: #16a085;/* sidebar active highlight */
            --fc-text: #ffffff;
        }
        body { overflow-x:hidden; }
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: var(--fc-green);
            color: var(--fc-text);
            display:flex;
            flex-direction:column;
        }
        .sidebar .brand {
            font-size: 1.5rem;
            font-weight:700;
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }
        .sidebar .user-info {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }
        .sidebar .nav-link {
            color: var(--fc-text);
            font-weight: 500;
            padding: .75rem 1.5rem;
            display:flex;align-items:center;gap:.75rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--fc-green-light);
            color: #fff;
        }
        /* content area */
        main {
            margin-left: 260px;
            padding: 2rem 2.5rem;
        }
    </style>
</head>
<body>
    <nav class="sidebar">
        <div class="brand">FabellaCares</div>
        <div class="user-info">
            <div class="fw-bold">{{ auth()->user()->name }}</div>
            <small>{{ ucfirst(auth()->user()->role) }}</small>
        </div>
        <ul class="nav flex-column mt-2 mb-auto">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}"><i class="bi bi-people-fill"></i> User Account</a></li>
            <li class="nav-item"><a href=" {{ route('queue.index') }}" class="nav-link {{ request()->is('queue*') ? 'active' : '' }}"><i class="bi bi-people-fill"></i> Queueing</a></li>
            <li class="nav-item">
  <a href="{{ route('patients.index') }}"
     class="nav-link {{ request()->is('patients*') ? 'active' : '' }}">
     <i class="bi bi-folder2-open"></i> Patient Record
  </a>
</li>

<li class="nav-item">
                <a href="{{ route('opd_forms.index') }}"
                   class="nav-link {{ request()->is('opd_forms*') ? 'active' : '' }}">
                   <i class="bi bi-file-earmark-text"></i> OPD Forms
                </a>
            </li>
            <li class="nav-item">
  <a href="{{ route('schedules.index') }}"
     class="nav-link {{ request()->is('schedules*') ? 'active' : '' }}">
     <i class="bi bi-calendar-event"></i> Work Schedule
  </a>
</li>

            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-graph-up"></i> Reports</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-bar-chart-line"></i> Trend Forecasting</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
