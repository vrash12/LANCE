{{-- resources/views/queue/index.blade.php --}}
@extends('layouts.admin')

@section('content')

{{-- ==== Flash message ==== --}}
@if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

<style>
  /* ===== Banner ===== */
  .q-header {
    background: #00b467;
    color: #fff;
    padding: 1.25rem 2rem;
    border-radius: .25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
  }
  .q-header h1 { font-size: 2rem; font-weight: 700; margin: 0; }

  /* ===== Department cards ===== */
  .dept-card {
    width: 155px;
    min-height: 155px;
    background: #0e4749;
    border-radius: .75rem;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: .75rem;
    margin: .5rem;
    font-weight: 600;
    text-align: center;
    transition: .15s;
  }
  .dept-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,.25);
  }
  .dept-card ul {
    margin-top: .75rem;
    list-style: none;
    padding: 0;
  }
  .dept-card ul li {
    margin-bottom: .5rem;
    font-size: .8rem;
    line-height: 1.25rem;
  }
  .dept-card ul li span {
    opacity: .6;
    pointer-events: none;
  }

  /* plus tile */
  .plus-card {
    font-size: 3rem;
    line-height: 1;
    color: #00b467;
  }

  /* ===== Token sidebar ===== */
  .token-panel { background: #d9f5df; border-radius: .75rem; }
  .token-box {
    padding: 1.5rem .5rem;
    text-align: center;
    border-bottom: 1px solid #c1ecc8;
  }
  .token-box:last-child { border-bottom: none; }
  .token-box h2 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #00b467;
  }
  .token-box span {
    display: block;
    font-size: .9rem;
    font-weight: 500;
    color: #0e4749;
  }

  @media (max-width:991px){
    .token-panel { margin-top:1.5rem; }
  }
</style>

<div class="q-header">
  <h1>Queueing</h1>
  <div>
    <a href="{{ route('queue.history') }}" class="btn btn-light btn-sm me-2">
      <i class="bi bi-clock-history"></i> History
    </a>
    <img src="{{ asset('images/fabella-logo.png') }}" width="60" alt="Fabella logo">
  </div>
</div>



<div class="row">
  {{-- === LEFT: departments grid === --}}
  <div class="col-lg-9">
    <h5 class="mb-2">Departments</h5>
    <div class="d-flex flex-wrap">
      @foreach($departments as $dept)
        @php
          // this comes from your Department::nextPendingToken()
          $next = $dept->nextPendingToken;  
        @endphp

 <div class="dept-card">
  {{ $dept->short_name }}
  <ul>
    <li>
      <a href="{{ route('queue.display.admin', $dept) }}"
         class="text-white text-decoration-none">
        Display (Admin)
      </a>
    </li>
    <li>
      <form action="{{ route('queue.store',$dept) }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-link p-0 text-white-50 text-decoration-none">
          Add Token
        </button>
      </form>
    </li>
    <li>
      @if($next)
        <a href="{{ route('queue.tokens.edit',[$dept,$next]) }}"
           class="text-white-50 text-decoration-none">
          Edit Token
        </a>
      @else
        <span>Edit Token</span>
      @endif
    </li>
    {{-- ← INSERT “Display (Admin)” HERE ↓ --}}
  </ul>
</div>

      @endforeach

 {{-- “+” to add a new department --}}
    @can('create', App\Models\Department::class) {{-- or if you’re not using policies, use auth()->user()->is_admin --}}
    <a href="{{ route('departments.create') }}"
       class="dept-card plus-card d-flex justify-content-center align-items-center">
      +
    </a>
    @endcan
    </div>
  </div>

  {{-- === RIGHT: token statistics === --}}
  <div class="col-lg-3">
    <div class="token-panel shadow-sm">
      <div class="token-box">
        <h2>{{ $summary['total'] }}</h2>
        <span>Tokens</span>
      </div>
      <div class="token-box">
        <h2>{{ $summary['pending'] }}</h2>
        <span>Pending</span>
      </div>
      <div class="token-box">
        <h2>{{ $summary['complete'] }}</h2>
        <span>Served</span>
      </div>
    </div>
  </div>
</div>
@endsection
