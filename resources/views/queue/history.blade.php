@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h4">Queue History Logs</h1>
  <a href="{{ route('queue.index') }}" class="btn btn-secondary">
    ← Back to Departments
  </a>
</div>

{{-- Filter Form --}}
<form method="GET" class="row g-3 mb-4">
  <div class="col-md-3">
    <select name="department" class="form-select">
      <option value="">All Departments</option>
      @foreach($departments as $dept)
        <option value="{{ $dept->id }}"
          {{ request('department') == $dept->id ? 'selected' : '' }}>
          {{ $dept->name }}
        </option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <select name="status" class="form-select">
      <option value="">All Status</option>
      <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>
        Pending
      </option>
      <option value="served" {{ request('status')=='served' ? 'selected' : '' }}>
        Served
      </option>
    </select>
  </div>
  <div class="col-md-3">
    <button type="submit" class="btn btn-primary">Filter</button>
    <a href="{{ route('queue.history') }}" class="btn btn-outline-secondary">Reset</a>
  </div>
</form>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Token</th>
      <th>Department</th>
      <th>Requested At</th>
      <th>Served At</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @forelse($tokens as $t)
      <tr>
        <td>{{ $t->code }}</td>
        <td>{{ $t->department->name }}</td>
        <td>{{ $t->created_at->format('Y-m-d H:i:s') }}</td>
        <td>
          @if($t->served_at)
            {{ $t->served_at->format('Y-m-d H:i:s') }}
          @else
            —
          @endif
        </td>
        <td>
          @if($t->served_at)
            <span class="badge bg-success">Served</span>
          @else
            <span class="badge bg-warning text-dark">Pending</span>
          @endif
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="5" class="text-center">No records found.</td>
      </tr>
    @endforelse
  </tbody>
</table>

{{-- Pagination --}}
<div class="mt-4">
  {{ $tokens->withQueryString()->links() }}
</div>
@endsection
