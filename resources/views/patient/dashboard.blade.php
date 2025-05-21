@extends('layouts.patient') {{-- or a separate patient layout --}}

@section('content')
<div class="container">
  <h1 class="mb-4">Welcome, {{ auth()->user()->name }}</h1>

  <div class="row g-3">
  

    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <div class="card-body">
          <i class="bi bi-ticket-perforated fs-1 text-primary"></i>
          <h5 class="card-title mt-2">My Queue Token</h5>
          <p class="fs-4 mb-0">{{ session('current_token','—') }}</p>
        </div>
      </div>
    </div>
@php $patient = auth()->user()->patient; @endphp

<div class="col-md-4">
  <div class="card shadow-sm text-center">
    <div class="card-body">
      <i class="bi bi-clock-history fs-1 text-warning"></i>
      <h5 class="card-title mt-2">Visit History</h5>

      @if($patient)
        <a href="{{ route('patients.show', $patient) }}"
           class="stretched-link">View</a>
      @else
        <p class="text-muted">No profile yet.</p>
      @endif
    </div>
  </div>
</div>
@endsection
