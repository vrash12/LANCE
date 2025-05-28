{{-- resources/views/schedules/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Work Schedule</h2>
  <a href="{{ route('schedules.create') }}" class="btn btn-primary">+ Add Schedule</a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>Staff Name</th>
      <th>Role</th>
      <th>Date</th>
      <th>Shift Time</th>
      <th>Department</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($schedules as $sched)
      <tr>
        <td>{{ $sched->staff_name }}</td>
        <td>{{ $sched->role }}</td>
        <td>{{ $sched->date->format('Y-m-d') }}</td>
        <td>
          @php
            // Find the first active day's shift times to display
            $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            $displayStart = '';
            $displayEnd = '';
            
            foreach ($days as $day) {
              $includeField = "include_$day";
              $startField = "shift_start_$day";
              $endField = "shift_end_$day";
              
              if ($sched->$includeField && $sched->$startField && $sched->$endField) {
                $displayStart = \Carbon\Carbon::parse($sched->$startField)->format('h:i A');
                $displayEnd = \Carbon\Carbon::parse($sched->$endField)->format('h:i A');
                break;
              }
            }
          @endphp
          
          @if($displayStart && $displayEnd)
            {{ $displayStart }} – {{ $displayEnd }}
          @else
            <span class="text-muted">No active shifts</span>
          @endif
        </td>
        <td>{{ $sched->department }}</td>
        <td>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#scheduleModal" onclick="viewSchedule({{ $sched->id }})">
              View
            </button>
            <a href="{{ route('schedules.edit', $sched) }}" class="btn btn-sm btn-info">Edit</a>
            <form action="{{ route('schedules.destroy', $sched) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this schedule?');">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{{-- Custom Pagination using Method 1 --}}
@if ($schedules->hasPages())
<nav aria-label="Page navigation" class="mt-4">
  <ul class="pagination justify-content-center">
    {{-- Previous Page Link --}}
    @if ($schedules->onFirstPage())
      <li class="page-item disabled">
        <span class="page-link">Previous</span>
      </li>
    @else
      <li class="page-item">
        <a class="page-link" href="{{ $schedules->previousPageUrl() }}" rel="prev">Previous</a>
      </li>
    @endif

    {{-- Pagination Elements --}}
    @php
      $start = max(1, $schedules->currentPage() - 2);
      $end = min($schedules->lastPage(), $schedules->currentPage() + 2);
    @endphp
    
    {{-- First page link if we're not showing it --}}
    @if ($start > 1)
      <li class="page-item">
        <a class="page-link" href="{{ $schedules->url(1) }}">1</a>
      </li>
      @if ($start > 2)
        <li class="page-item disabled">
          <span class="page-link">...</span>
        </li>
      @endif
    @endif

    {{-- Page number links --}}
    @for ($page = $start; $page <= $end; $page++)
      @if ($page == $schedules->currentPage())
        <li class="page-item active">
          <span class="page-link">{{ $page }}</span>
        </li>
      @else
        <li class="page-item">
          <a class="page-link" href="{{ $schedules->url($page) }}">{{ $page }}</a>
        </li>
      @endif
    @endfor

    {{-- Last page link if we're not showing it --}}
    @if ($end < $schedules->lastPage())
      @if ($end < $schedules->lastPage() - 1)
        <li class="page-item disabled">
          <span class="page-link">...</span>
        </li>
      @endif
      <li class="page-item">
        <a class="page-link" href="{{ $schedules->url($schedules->lastPage()) }}">{{ $schedules->lastPage() }}</a>
      </li>
    @endif

    {{-- Next Page Link --}}
    @if ($schedules->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ $schedules->nextPageUrl() }}" rel="next">Next</a>
      </li>
    @else
      <li class="page-item disabled">
        <span class="page-link">Next</span>
      </li>
    @endif
  </ul>
</nav>

{{-- Show results info --}}
<div class="d-flex justify-content-between align-items-center mt-3">
  <div class="text-muted">
    Showing {{ $schedules->firstItem() ?? 0 }} to {{ $schedules->lastItem() ?? 0 }} of {{ $schedules->total() }} results
  </div>
  <div class="text-muted">
    Page {{ $schedules->currentPage() }} of {{ $schedules->lastPage() }}
  </div>
</div>
@endif

<!-- Schedule View Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="scheduleModalLabel">Schedule Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="scheduleModalBody">
        <div class="text-center">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
/* Clean pagination styling */
.pagination .page-link {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 40px;
  height: 40px;
  border: 1px solid #dee2e6;
  color: #495057;
  padding: 8px 12px;
  margin: 0 2px;
  border-radius: 6px;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.2s ease;
}

.pagination .page-link:hover {
  background-color: #e9ecef;
  border-color: #adb5bd;
  color: #495057;
  text-decoration: none;
}

.pagination .page-item.active .page-link {
  background-color: #007bff;
  border-color: #007bff;
  color: white;
  font-weight: 600;
}

.pagination .page-item.disabled .page-link {
  color: #6c757d;
  background-color: #fff;
  border-color: #dee2e6;
  cursor: not-allowed;
}

.pagination .page-item.disabled .page-link:hover {
  background-color: #fff;
  border-color: #dee2e6;
}

/* Results info styling */
.text-muted {
  font-size: 14px;
}

/* Ensure proper spacing */
.pagination {
  margin-bottom: 0;
}

/* Remove any default arrow styling */
.pagination .page-link[rel="prev"]::before,
.pagination .page-link[rel="next"]::before {
  display: none;
}

.pagination .page-link[rel="prev"] span,
.pagination .page-link[rel="next"] span {
  display: none;
}
</style>
@endpush

@push('scripts')
<script>
function viewSchedule(scheduleId) {
  // Show loading spinner
  document.getElementById('scheduleModalBody').innerHTML = `
    <div class="text-center">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  `;
  
  // Fetch schedule details via AJAX
  fetch(`/schedules/${scheduleId}/show`, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'text/html',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
    }
  })
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.text();
    })
    .then(data => {
      document.getElementById('scheduleModalBody').innerHTML = data;
    })
    .catch(error => {
      console.error('Error:', error);
      document.getElementById('scheduleModalBody').innerHTML = `
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-triangle me-2"></i>
          Error loading schedule details. Please check the console for more information.
          <br><small class="text-muted">Error: ${error.message}</small>
        </div>
      `;
    });
}
</script>
@endpush