<!-- resources/views/layouts/patient.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>FabellaCares – Patient</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --fc-green: #0e4749;
      --fc-green-light: #16a085;
      --fc-text: #ffffff;
    }
    body {
      overflow-x: hidden;
    }
    .sidebar {
      width: 260px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background: var(--fc-green);
      color: var(--fc-text);
      display: flex;
      flex-direction: column;
    }
    .sidebar .brand {
      font-size: 1.5rem;
      font-weight: 700;
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
      display: flex;
      align-items: center;
      gap: .75rem;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: var(--fc-green-light);
      color: #fff;
    }
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
      <small>Patient</small>
    </div>

    <ul class="nav flex-column mt-2 mb-auto">
      <li class="nav-item">
        <a href="{{ route('patient.dashboard') }}"
           class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
          <i class="bi bi-speedometer2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('patient.queue') }}"
           class="nav-link {{ request()->routeIs('patient.queue') ? 'active' : '' }}">
          <i class="bi bi-people-fill"></i> Queueing
        </a>
      </li>
      @if(auth()->user()->patient)
      <li class="nav-item">
        <a href="{{ route('patients.show', auth()->user()->patient) }}"
           class="nav-link {{ request()->is('patients/*') ? 'active' : '' }}">
          <i class="bi bi-clock-history"></i> Visit History
        </a>
      </li>
      @endif
    </ul>

    <ul class="nav flex-column mt-auto mb-4">
      <li class="nav-item">
        <a href="{{ route('password.change') }}"
           class="nav-link {{ request()->is('password/change') ? 'active' : '' }}">
          <i class="bi bi-key-fill"></i> Change Password
        </a>
      </li>
      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="nav-link btn btn-link text-start w-100"
                  style="color: var(--fc-text); padding:.75rem 1.5rem;">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </form>
      </li>
   <li class="nav-item">
  <a href="{{ route('queue.display.select') }}"  {{-- ✅ no variable needed --}}
     class="nav-link {{ request()->routeIs('queue.display.select') ? 'active' : '' }}">
    <i class="bi bi-tv-fill"></i> Display Queue
  </a>
</li>


    </ul>
  </nav>

  <main>
      {{-- FLASH MESSAGES --}}
  <main class="container py-4">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

   {{-- FLASH MESSAGES --}}
  <main class="container py-4">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @yield('content')
  </main>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
