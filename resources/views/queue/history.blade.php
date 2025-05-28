@extends('layouts.admin')

{{-- Override to keep our back‐arrow icon small --}}
@push('styles')
<style>
.btn i {
  display: inline-block !important;
  width: 1em !important;
  height: 1em !important;
  font-size: 1em !important;
  line-height: 1 !important;
}

/* Hide default pagination arrows completely */
.pagination .page-link::before,
.pagination .page-link::after {
  display: none !important;
}

/* Custom pagination styling without arrows */
.custom-pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin-top: 20px;
}

.custom-pagination .page-btn {
  padding: 8px 12px;
  border: 1px solid #dee2e6;
  background: #fff;
  color: #007bff;
  text-decoration: none;
  border-radius: 4px;
  font-size: 14px;
}

.custom-pagination .page-btn:hover {
  background: #e9ecef;
  text-decoration: none;
}

.custom-pagination .page-btn.active {
  background: #007bff;
  color: #fff;
  border-color: #007bff;
}

.custom-pagination .page-btn.disabled {
  color: #6c757d;
  background: #e9ecef;
  border-color: #dee2e6;
  cursor: not-allowed;
}
</style>
@endpush

@section('content')
  {{-- Header with back button --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Queue History Logs</h2>
    <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left me-2"></i>
      Back to Departments
    </a>
  </div>

  {{-- Filter Form --}}
  <form class="row gy-2 gx-3 align-items-end mb-4">
    <div class="col-auto">
      <label class="form-label">Department</label>
      <select class="form-select" name="department_id">
        <option value="">All Departments</option>
        @foreach($departments as $dept)
          <option 
            value="{{ $dept->id }}" 
            {{ request('department_id') == $dept->id ? 'selected' : '' }}>
            {{ $dept->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-auto">
      <label class="form-label">Status</label>
      <select class="form-select" name="status">
        <option value="">All Status</option>
        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>
          Pending
        </option>
        <option value="served" {{ request('status')=='served' ? 'selected' : '' }}>
          Served
        </option>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('queue.history') }}" class="btn btn-link">Reset</a>
    </div>
  </form>

  {{-- Results Table --}}
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead class="table-light">
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
              <span class="badge {{ $t->served_at ? 'bg-success' : 'bg-warning text-dark' }}">
                {{ $t->served_at ? 'Served' : 'Pending' }}
              </span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-4">No records found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Custom Pagination WITHOUT Arrows --}}
  @if($tokens->hasPages())
    <div class="custom-pagination">
      {{-- Previous Button --}}
      @if($tokens->onFirstPage())
        <span class="page-btn disabled">Previous</span>
      @else
        <a href="{{ $tokens->withQueryString()->previousPageUrl() }}" class="page-btn">Previous</a>
      @endif

      {{-- Page Numbers --}}
      @php
        $start = max(1, $tokens->currentPage() - 2);
        $end = min($tokens->lastPage(), $tokens->currentPage() + 2);
      @endphp

      @if($start > 1)
        <a href="{{ $tokens->withQueryString()->url(1) }}" class="page-btn">1</a>
        @if($start > 2)
          <span class="page-btn disabled">...</span>
        @endif
      @endif

      @for($i = $start; $i <= $end; $i++)
        @if($i == $tokens->currentPage())
          <span class="page-btn active">{{ $i }}</span>
        @else
          <a href="{{ $tokens->withQueryString()->url($i) }}" class="page-btn">{{ $i }}</a>
        @endif
      @endfor

      @if($end < $tokens->lastPage())
        @if($end < $tokens->lastPage() - 1)
          <span class="page-btn disabled">...</span>
        @endif
        <a href="{{ $tokens->withQueryString()->url($tokens->lastPage()) }}" class="page-btn">{{ $tokens->lastPage() }}</a>
      @endif

      {{-- Next Button --}}
      @if($tokens->hasMorePages())
        <a href="{{ $tokens->withQueryString()->nextPageUrl() }}" class="page-btn">Next</a>
      @else
        <span class="page-btn disabled">Next</span>
      @endif
    </div>

    {{-- Pagination Info --}}
    <div class="text-center text-muted mt-2">
      <small>
        Showing {{ $tokens->firstItem() ?? 0 }} to {{ $tokens->lastItem() ?? 0 }} of {{ $tokens->total() }} results
      </small>
    </div>
  @endif
@endsection