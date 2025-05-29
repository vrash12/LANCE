{{-- resources/views/queue/index.blade.php --}}
@extends('layouts.admin')

@section('content')

{{-- ==== Flash message ==== --}}
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<style>
  :root {
    --primary-green: #00b467;
    --primary-dark: #0e4749;
    --light-green: #d9f5df;
    --accent-green: #c1ecc8;
    --hover-shadow: 0 8px 25px rgba(0,180,103,0.15);
    --card-shadow: 0 4px 15px rgba(0,0,0,0.08);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* ===== Enhanced Banner ===== */
  .q-header {
    background: linear-gradient(135deg, var(--primary-green) 0%, #00a85d 100%);
    color: #fff;
    padding: 2rem 2.5rem;
    border-radius: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
  }
  
  .q-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    transform: translate(30px, -30px);
  }
  
  .q-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 150px;
    height: 150px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    transform: translate(-50px, 50px);
  }
  
  .q-header h1 { 
    font-size: 2.5rem; 
    font-weight: 800; 
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: relative;
    z-index: 2;
  }
  
  .header-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    z-index: 2;
  }
  
  .header-controls .btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    transition: var(--transition);
    border: 2px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
  }
  
  .header-controls .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    border-color: rgba(255,255,255,0.4);
  }

  /* ===== Section Headers ===== */
  .section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f0f0f0;
  }
  
  .section-header h5 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .section-header::before {
    content: '';
    width: 4px;
    height: 2rem;
    background: linear-gradient(to bottom, var(--primary-green), var(--primary-dark));
    border-radius: 2px;
    margin-right: 1rem;
  }

  /* ===== Enhanced Department Cards ===== */
  .departments-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
  }
  
  .dept-card {
    background: linear-gradient(135deg, var(--primary-dark) 0%, #0a3d3f 100%);
    border-radius: 1rem;
    color: #fff;
    padding: 1.5rem;
    font-weight: 600;
    text-align: center;
    transition: var(--transition);
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  
  .dept-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    transition: var(--transition);
  }
  
  .dept-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--hover-shadow);
  }
  
  .dept-card:hover::before {
    transform: scale(1.5);
    opacity: 0.1;
  }
  
  .dept-name {
    font-size: 1.2rem;
    font-weight: 800;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
  }
  
  .dept-actions {
    list-style: none;
    padding: 0;
    margin: 0;
    position: relative;
    z-index: 2;
  }
  
  .dept-actions li {
    margin-bottom: 0.75rem;
  }
  
  .dept-actions li:last-child {
    margin-bottom: 0;
  }
  
  .action-btn, .action-link {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: var(--transition);
    width: 100%;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
  }
  
  .action-btn {
    background: none;
    border: 1px solid rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.9);
  }
  
  .action-link {
    color: rgba(255,255,255,0.9);
  }
  
  .action-btn:hover, .action-link:hover {
    background: rgba(255,255,255,0.2);
    color: #fff;
    transform: translateY(-1px);
  }
  
  .action-disabled {
    color: rgba(255,255,255,0.4);
    cursor: not-allowed;
    border-color: rgba(255,255,255,0.1);
  }
  
  .action-disabled:hover {
    background: none;
    transform: none;
  }

  /* ===== Plus Card Enhancement ===== */
  .plus-card {
    background: linear-gradient(135deg, rgba(0,180,103,0.1) 0%, rgba(0,180,103,0.05) 100%);
    border: 2px dashed var(--primary-green);
    color: var(--primary-green);
    font-size: 3rem;
    font-weight: 300;
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    transition: var(--transition);
    min-height: 200px;
    border-radius: 1rem;
  }
  
  .plus-card:hover {
    background: linear-gradient(135deg, rgba(0,180,103,0.15) 0%, rgba(0,180,103,0.1) 100%);
    border-color: #00a85d;
    color: #00a85d;
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--hover-shadow);
  }

  /* ===== Enhanced Token Panel ===== */
  .token-panel { 
    background: linear-gradient(135deg, var(--light-green) 0%, #e6f9ea 100%);
    border-radius: 1rem; 
    box-shadow: var(--card-shadow);
    overflow: hidden;
    position: sticky;
    top: 2rem;
  }
  
  .token-box {
    padding: 2rem 1.5rem;
    text-align: center;
    border-bottom: 1px solid var(--accent-green);
    transition: var(--transition);
    position: relative;
  }
  
  .token-box:last-child { 
    border-bottom: none; 
  }
  
  .token-box:hover {
    background: rgba(255,255,255,0.5);
    transform: scale(1.02);
  }
  
  .token-box h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem 0;
    color: var(--primary-green);
    text-shadow: 0 2px 4px rgba(0,180,103,0.1);
  }
  
  .token-box span {
    display: block;
    font-size: 1rem;
    font-weight: 600;
    color: var(--primary-dark);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .token-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-green), #00a85d);
    opacity: 0;
    transition: var(--transition);
  }
  
  .token-box:hover::before {
    opacity: 1;
  }

  /* ===== Responsive Design ===== */
  @media (max-width: 991px) {
    .token-panel { 
      margin-top: 2rem;
      position: static;
    }
    
    .q-header {
      padding: 1.5rem;
      flex-direction: column;
      gap: 1rem;
      text-align: center;
    }
    
    .header-controls {
      flex-direction: column;
      width: 100%;
    }
    
    .departments-grid {
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 1rem;
    }
    
    .q-header h1 {
      font-size: 2rem;
    }
  }
  
  @media (max-width: 576px) {
    .departments-grid {
      grid-template-columns: 1fr;
    }
    
    .q-header {
      padding: 1rem;
    }
  }

  /* ===== Animation Enhancements ===== */
  .dept-card, .token-box, .plus-card {
    animation: fadeInUp 0.6s ease-out;
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  /* Stagger animation for cards */
  .dept-card:nth-child(1) { animation-delay: 0.1s; }
  .dept-card:nth-child(2) { animation-delay: 0.2s; }
  .dept-card:nth-child(3) { animation-delay: 0.3s; }
  .dept-card:nth-child(4) { animation-delay: 0.4s; }
  .dept-card:nth-child(5) { animation-delay: 0.5s; }
  .dept-card:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="q-header">
  <h1><i class="bi bi-list-check me-3"></i>Queue Management</h1>
  <div class="header-controls">
    <a href="{{ route('queue.history') }}" class="btn btn-light">
      <i class="bi bi-clock-history me-2"></i>View History
    </a>
    <img src="{{ asset('images/fabella-logo.png') }}" width="50" height="50" alt="Fabella logo" class="rounded-circle shadow-sm">
  </div>
</div>

<div class="row">
  {{-- === LEFT: departments grid === --}}
  <div class="col-lg-9">
    <div class="section-header">
      <h5><i class="bi bi-building"></i>Departments</h5>
    </div>
    
    <div class="departments-grid">
      @foreach($departments as $dept)
        @php
          $next = $dept->nextPendingToken;  
        @endphp
        
        <div class="dept-card">
          <div class="dept-name">{{ $dept->short_name }}</div>
          <ul class="dept-actions">
            <li>
              <a href="{{ route('queue.display.admin', $dept) }}" class="action-link">
                <i class="bi bi-display me-2"></i>Admin Display
              </a>
            </li>
            <li>
              <form action="{{ route('queue.store',$dept) }}" method="POST" class="d-inline w-100">
                @csrf
                <button class="action-btn w-100">
                  <i class="bi bi-plus-circle me-2"></i>Add New Token
                </button>
              </form>
            </li>
            <li>
              @if($next)
                <a href="{{ route('queue.tokens.edit',[$dept,$next]) }}" class="action-link">
                  <i class="bi bi-pencil-square me-2"></i>Edit Next Token
                </a>
              @else
                <span class="action-link action-disabled">
                  <i class="bi bi-pencil-square me-2"></i>No Token to Edit
                </span>
              @endif
            </li>
          </ul>
        </div>
      @endforeach

      {{-- "+" to add a new department --}}
      @can('create', App\Models\Department::class)
        <a href="{{ route('departments.create') }}" class="plus-card">
          <div>
            <i class="bi bi-plus-lg"></i>
            <div style="font-size: 0.9rem; margin-top: 0.5rem; font-weight: 600;">Add Department</div>
          </div>
        </a>
      @endcan
    </div>
  </div>

  {{-- === RIGHT: token statistics === --}}
  <div class="col-lg-3">
    <div class="section-header">
      <h5><i class="bi bi-bar-chart"></i>Statistics</h5>
    </div>
    
    <div class="token-panel">
      <div class="token-box">
        <h2>{{ number_format($summary['total']) }}</h2>
        <span><i class="bi bi-ticket-perforated me-2"></i>Total Tokens</span>
      </div>
      <div class="token-box">
        <h2>{{ number_format($summary['pending']) }}</h2>
        <span><i class="bi bi-hourglass-split me-2"></i>Pending</span>
      </div>
      <div class="token-box">
        <h2>{{ number_format($summary['complete']) }}</h2>
        <span><i class="bi bi-check-circle me-2"></i>Completed</span>
      </div>
    </div>
  </div>
</div>

@endsection