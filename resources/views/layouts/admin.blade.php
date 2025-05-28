<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FabellaCares – Admin</title>

    {{-- Bootstrap 5.3 & Icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Inter font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --fc-primary:#0e4749;
            --fc-secondary:#16a085;
            --fc-accent:#00b467;
            --fc-light:#f8fafc;
            --fc-dark:#1e293b;
            --fc-text:#ffffff;
            --fc-text-muted:rgba(255,255,255,.7);
            --fc-border:rgba(255,255,255,.1);
            --fc-hover:rgba(255,255,255,.05);
            --fc-gradient:linear-gradient(135deg,#0e4749 0%,#16a085 50%,#00b467 100%);
            --fc-shadow:0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -1px rgba(0,0,0,.06);
            --fc-shadow-lg:0 10px 15px -3px rgba(0,0,0,.1),0 4px 6px -2px rgba(0,0,0,.05);
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;
            background:var(--fc-light);
            overflow-x:hidden;
            line-height:1.6;
            color:var(--fc-dark);
        }

        /* === SIDEBAR === */
        .sidebar{
            width:280px;height:100vh;position:fixed;top:0;left:0;
            background:var(--fc-gradient);color:var(--fc-text);
            display:flex;flex-direction:column;z-index:1000;
            backdrop-filter:blur(20px);box-shadow:var(--fc-shadow-lg);
            transition:all .3s cubic-bezier(.4,0,.2,1);
        }
        .sidebar::before{
            content:'';position:absolute;inset:0;
            background:url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity:.3;pointer-events:none;
        }

        /* Brand */
        .brand{
            position:relative;z-index:2;
            font-size:1.75rem;font-weight:800;
            padding:2rem 2rem 1.5rem;
            border-bottom:1px solid var(--fc-border);
            background:rgba(255,255,255,.05);
            backdrop-filter:blur(10px);
            display:flex;align-items:center;gap:.75rem;
        }
        .brand-icon{
            width:40px;height:40px;
            background:rgba(255,255,255,.15);border-radius:12px;
            display:flex;align-items:center;justify-content:center;
            font-size:1.25rem;animation:pulse 3s ease-in-out infinite;
        }
        @keyframes pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.05)}}

        /* User */
        .user-info{
            position:relative;z-index:2;padding:1.5rem 2rem;
            border-bottom:1px solid var(--fc-border);
            background:rgba(255,255,255,.05);
            backdrop-filter:blur(10px);
        }
        .user-avatar{
            width:50px;height:50px;margin-bottom:.75rem;
            background:var(--fc-accent);border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            font-size:1.25rem;font-weight:600;
            box-shadow:0 4px 12px rgba(0,0,0,.15);position:relative;
        }
        .user-avatar::after{
            content:'';position:absolute;top:-2px;right:-2px;
            width:14px;height:14px;border:2px solid #fff;
            background:#10b981;border-radius:50%;animation:blink 2s ease-in-out infinite;
        }
        @keyframes blink{0%,50%,100%{opacity:1}25%,75%{opacity:.5}}
        .user-name{font-weight:600;font-size:1.1rem;margin-bottom:.25rem;}
        .user-role{color:var(--fc-text-muted);font-size:.875rem;font-weight:500;text-transform:uppercase;letter-spacing:.5px;}

        /* Nav */
        .sidebar-nav{position:relative;z-index:2;flex:1;padding:1rem 0;overflow-y:auto;}
        .sidebar-nav::-webkit-scrollbar{width:4px;}
        .sidebar-nav::-webkit-scrollbar-thumb{background:rgba(255,255,255,.2);border-radius:2px;}

        .nav-section-title{
            color:var(--fc-text-muted);font-size:.75rem;font-weight:600;
            text-transform:uppercase;letter-spacing:1px;
            padding:.5rem 2rem .75rem;margin-bottom:.5rem;
        }
        .nav-link{
            color:var(--fc-text);font-weight:500;
            padding:.875rem 2rem;display:flex;align-items:center;gap:1rem;
            transition:all .3s cubic-bezier(.4,0,.2,1);
            position:relative;text-decoration:none;border:none;background:none;width:100%;text-align:left;margin:.125rem 0;
        }
        .nav-link::before{
            content:'';position:absolute;left:0;top:50%;width:0;height:0;
            background:var(--fc-accent);transform:translateY(-50%);
            transition:all .3s cubic-bezier(.4,0,.2,1);border-radius:0 4px 4px 0;
        }
        .nav-link:hover,.nav-link.active{background:rgba(255,255,255,.1);color:#fff;transform:translateX(8px);}
        .nav-link:hover::before,.nav-link.active::before{width:4px;height:32px;}
        .nav-link i{font-size:1.1rem;width:20px;text-align:center;transition:transform .3s ease;}
        .nav-link:hover i{transform:scale(1.1);}
        .nav-link-badge{
            background:var(--fc-accent);color:#fff;font-size:.75rem;font-weight:600;
            padding:.25rem .5rem;border-radius:12px;margin-left:auto;min-width:20px;text-align:center;
        }

        /* Footer */
        .sidebar-footer{
            position:relative;z-index:2;padding:1rem 0 2rem;
            border-top:1px solid var(--fc-border);background:rgba(0,0,0,.1);
        }

        /* === MAIN === */
        main{margin-left:280px;min-height:100vh;background:var(--fc-light);transition:all .3s cubic-bezier(.4,0,.2,1);}
        .main-header{
            background:rgba(255,255,255,.95);padding:1.5rem 2.5rem;
            border-bottom:1px solid #e2e8f0;box-shadow:var(--fc-shadow);
            position:sticky;top:0;z-index:100;backdrop-filter:blur(20px);
        }
        .main-content{padding:2rem 2.5rem;}

        /* Alerts */
        .alert{border:none;border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;backdrop-filter:blur(10px);animation:slideDown .5s ease-out;}
        @keyframes slideDown{from{opacity:0;transform:translateY(-20px)}to{opacity:1;transform:translateY(0)}}
        .alert-success{background:linear-gradient(135deg,rgba(16,185,129,.1) 0%,rgba(16,185,129,.05) 100%);border-left:4px solid #10b981;color:#065f46;}
        .alert-danger{background:linear-gradient(135deg,rgba(239,68,68,.1) 0%,rgba(239,68,68,.05) 100%);border-left:4px solid #ef4444;color:#991b1b;}

        /* Mobile */
        @media(max-width:768px){
            .sidebar{transform:translateX(-100%);width:100%;max-width:320px;}
            .sidebar.mobile-open{transform:translateX(0);}
            main{margin-left:0;}
            .main-header{padding:1rem 1.5rem;}
            .main-content{padding:1.5rem;}
            .mobile-menu-btn{display:block;background:var(--fc-primary);color:#fff;border:none;padding:.5rem;border-radius:8px;font-size:1.25rem;}
        }
        .mobile-menu-btn{display:none;}

        /* Misc */
        html{scroll-behavior:smooth;}
        .loading{position:relative;overflow:hidden;}
        .loading::after{
            content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;
            background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);
            animation:loading 1.5s infinite;
        }
        @keyframes loading{0%{left:-100%}100%{left:100%}}
        .interactive:hover{transform:translateY(-2px);box-shadow:var(--fc-shadow-lg);transition:all .3s cubic-bezier(.4,0,.2,1);}
        main::-webkit-scrollbar{width:8px;}main::-webkit-scrollbar-track{background:#f1f5f9;}main::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px;}main::-webkit-scrollbar-thumb:hover{background:#94a3b8;}
    </style>

   @stack('styles')
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
</head>
<body>
    <!-- Mobile menu button -->
    <button class="mobile-menu-btn position-fixed" style="top:1rem;left:1rem;z-index:1001;" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- SIDEBAR -->
    <nav class="sidebar" id="sidebar">
        <!-- Brand -->
        <div class="brand">
            <div class="brand-icon"><i class="bi bi-hospital"></i></div>
            <span>FabellaCares</span>
        </div>

        <!-- User -->
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(Str::substr(auth()->user()->name,0,2)) }}
            </div>
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
        </div>

        <!-- Navigation -->
        <div class="sidebar-nav">
            {{-- MAIN --}}
            <div class="nav-section">
                <div class="nav-section-title">Main Menu</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i><span>User Account</span>
                        </a>
                    </li>
                <li class="nav-item">
    <a href="{{ route('queue.index') }}"
       class="nav-link {{ request()->is('queue*') ? 'active' : '' }}">
       <i class="bi bi-clock-history"></i>
       <span>Queueing</span>
    </a>
</li>

                    <li class="nav-item">
                        <a href="{{ route('patients.index') }}" class="nav-link {{ request()->is('patients*') ? 'active' : '' }}">
                            <i class="bi bi-folder2-open"></i><span>Patient Record</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('opd_forms.index') }}" class="nav-link {{ request()->is('opd_forms*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text"></i><span>OPD Forms</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- MANAGEMENT --}}
            <div class="nav-section">
                <div class="nav-section-title">Management</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('schedules.index') }}" class="nav-link {{ request()->is('schedules*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-event"></i><span>Work Schedule</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                            <i class="bi bi-bar-chart-line-fill"></i><span>Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('trends.index') }}" class="nav-link {{ request()->is('trends*') ? 'active' : '' }}">
                            <i class="bi bi-graph-up-arrow"></i><span>Trend Forecasting</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- SETTINGS --}}
            <div class="nav-section">
                <div class="nav-section-title">Settings</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('password.change') }}" class="nav-link {{ request()->is('password/change') ? 'active' : '' }}">
                            <i class="bi bi-key-fill"></i><span>Change Password</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="sidebar-footer">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-start w-100">
                            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- MAIN -->
    <main>
        <!-- Header -->
        <div class="main-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 fw-bold">Dashboard</h1>
                    <p class="text-muted mb-0">Welcome back! Here's what's happening today.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end">
                        <div class="text-sm text-muted">Today</div>
                        <div class="fw-bold" id="currentDate"></div>
                    </div>
                 <div class="position-relative">
    <button class="btn btn-outline-secondary position-relative">
        <i class="bi bi-bell"></i>
        {{-- remove the badge span for now --}}
    </button>
</div>

                </div>
            </div>
        </div>

        <!-- Global Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
                @if(session('new_token_id'))
  <div class="alert alert-success">
    Token generated!
    <a href="{{ route('queue.tokens.print', session('new_token_id')) }}"
       target="_blank" class="btn btn-sm btn-outline-light ms-2">
       Print&nbsp;Ticket
    </a>
  </div>
@endif
        @endif
    

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Please fix the following:<br><br>
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </main>

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        function toggleSidebar(){
            document.getElementById('sidebar').classList.toggle('mobile-open');
        }
        // Close sidebar when clicking outside (mobile)
        document.addEventListener('click',e=>{
            const sb=document.getElementById('sidebar');
            const btn=document.querySelector('.mobile-menu-btn');
            if(window.innerWidth<=768&&!sb.contains(e.target)&&!btn.contains(e.target)){
                sb.classList.remove('mobile-open');
            }
        });
        // Current date
        function updateDate(){
            const now=new Date();
            document.getElementById('currentDate').textContent=
                now.toLocaleDateString('en-US',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
        }
        // Init
        document.addEventListener('DOMContentLoaded',()=>{
            updateDate();
            // Auto-hide alerts after 5 s
            setTimeout(()=>{
                document.querySelectorAll('.alert').forEach(a=>new bootstrap.Alert(a).close());
            },5000);
            // Make nav links mutually active
            document.querySelectorAll('.nav-link').forEach(l=>{
                l.addEventListener('click',function(){
                    document.querySelectorAll('.nav-link').forEach(x=>x.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            // Loading effect on submit buttons
            document.querySelectorAll('button[type="submit"]').forEach(btn=>{
                btn.addEventListener('click',function(){
                    this.classList.add('loading');
                    setTimeout(()=>this.classList.remove('loading'),2000);
                });
            });
        });
    </script>

    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
