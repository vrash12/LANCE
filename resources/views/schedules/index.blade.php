{{-- resources/views/schedules/index.blade.php --}}
@extends('layouts.admin')

@section('content')

<style>
  :root {
    --primary-blue: #2563eb;
    --primary-dark: #1e40af;
    --secondary-gray: #64748b;
    --light-blue: #eff6ff;
    --accent-blue: #dbeafe;
    --success-green: #059669;
    --warning-orange: #d97706;
    --danger-red: #dc2626;
    --light-gray: #f8fafc;
    --border-color: #e2e8f0;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --hover-shadow: 0 10px 25px rgba(37, 99, 235, 0.15);
    --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* ===== Enhanced Header ===== */
  .page-header {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 2.5rem 2rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
  }
  
  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
  }
  
  .page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite reverse;
  }
  
  @keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(10deg); }
  }
  
  .header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 2;
  }
  
  .header-title {
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  
  .header-title h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .header-icon {
    width: 3rem;
    height: 3rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
  }
  
  .add-schedule-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .add-schedule-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }

  /* ===== Enhanced Alert ===== */
  .alert-enhanced {
    border: none;
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    box-shadow: var(--card-shadow);
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
  }
  
  .alert-enhanced.alert-success {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #15803d;
    border-left: 4px solid var(--success-green);
  }
  
  .alert-enhanced .btn-close {
    background: none;
    opacity: 0.7;
  }

  /* ===== Enhanced Table Container ===== */
  .table-container {
    background: white;
    border-radius: 1rem;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    margin-bottom: 2rem;
  }
  
  .table-header {
    background: linear-gradient(135deg, var(--light-blue) 0%, var(--accent-blue) 100%);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
  }
  
  .table-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  /* ===== Enhanced Table ===== */
  .enhanced-table {
    margin: 0;
    font-size: 0.95rem;
  }
  
  .enhanced-table thead th {
    background: var(--light-gray);
    color: var(--text-primary);
    font-weight: 700;
    padding: 1.25rem 1.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
    border: none;
    position: relative;
  }
  
  .enhanced-table thead th::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-blue), var(--primary-dark));
  }
  
  .enhanced-table tbody td {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid var(--border-color);
    vertical-align: middle;
    transition: var(--transition);
  }
  
  .enhanced-table tbody tr {
    transition: var(--transition);
  }
  
  .enhanced-table tbody tr:hover {
    background: var(--light-blue);
    transform: scale(1.005);
  }

  /* ===== Staff Badge ===== */
  .staff-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }
  
  .staff-avatar {
    width: 2.5rem;
    height: 2.5rem;
    background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
  }
  
  .staff-details h6 {
    margin: 0;
    font-weight: 600;
    color: var(--text-primary);
  }
  
  .staff-details small {
    color: var(--text-secondary);
    font-size: 0.8rem;
  }

  /* ===== Role Badge ===== */
  .role-badge {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .role-doctor {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
  }
  
  .role-nurse {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
  }
  
  .role-admin {
    background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
    color: #7c3aed;
  }
  
  .role-default {
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    color: var(--text-secondary);
  }

  /* ===== Date Badge ===== */
  .date-badge {
    background: linear-gradient(135deg, var(--light-blue), var(--accent-blue));
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    color: var(--primary-dark);
    display: inline-block;
  }

  /* ===== Time Display ===== */
  .time-display {
    background: var(--light-gray);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-weight: 600;
    color: var(--text-primary);
    border-left: 3px solid var(--success-green);
  }
  
  .no-shift {
    color: var(--text-secondary);
    font-style: italic;
    padding: 0.5rem 1rem;
    background: var(--light-gray);
    border-radius: 0.5rem;
    border-left: 3px solid var(--warning-orange);
  }

  /* ===== Action Buttons ===== */
  .action-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }
  
  .action-btn {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
  }
  
  .btn-view {
    background: linear-gradient(135deg, var(--light-blue), var(--accent-blue));
    color: var(--primary-blue);
  }
  
  .btn-view:hover {
    background: linear-gradient(135deg, var(--accent-blue), #bfdbfe);
    color: var(--primary-dark);
    transform: translateY(-1px);
  }
  
  .btn-edit {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: var(--warning-orange);
  }
  
  .btn-edit:hover {
    background: linear-gradient(135deg, #fde68a, #fcd34d);
    color: #92400e;
    transform: translateY(-1px);
  }
  
  .btn-delete {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: var(--danger-red);
  }
  
  .btn-delete:hover {
    background: linear-gradient(135deg, #fecaca, #fca5a5);
    color: #991b1b;
    transform: translateY(-1px);
  }

  /* ===== Enhanced Pagination ===== */
  .pagination-container {
    background: white;
    border-radius: 1rem;
    box-shadow: var(--card-shadow);
    padding: 2rem;
    margin-top: 2rem;
  }
  
  .pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 1.5rem;
  }
  
  .enhanced-pagination {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }
  
  .enhanced-pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
    border: 2px solid var(--border-color);
    color: var(--text-primary);
    background: white;
    border-radius: 0.5rem;
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    font-size: 0.9rem;
  }
  
  .enhanced-pagination .page-link:hover {
    background: var(--light-blue);
    border-color: var(--accent-blue);
    color: var(--primary-blue);
    transform: translateY(-1px);
  }
  
  .enhanced-pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
    border-color: var(--primary-blue);
    color: white;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
  }
  
  .enhanced-pagination .page-item.disabled .page-link {
    color: var(--text-secondary);
    background: var(--light-gray);
    border-color: var(--border-color);
    cursor: not-allowed;
    opacity: 0.6;
  }
  
  .enhanced-pagination .page-item.disabled .page-link:hover {
    background: var(--light-gray);
    border-color: var(--border-color);
    transform: none;
  }

  /* ===== Pagination Info ===== */
  .pagination-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
    font-size: 0.9rem;
    color: var(--text-secondary);
  }
  
  .pagination-info .info-badge {
    background: var(--light-blue);
    color: var(--primary-blue);
    padding: 0.375rem 0.75rem;
    border-radius: 1rem;
    font-weight: 600;
  }

  /* ===== Enhanced Modal ===== */
  .modal-content {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
  }
  
  .modal-header {
    background: linear-gradient(135deg, var(--light-blue), var(--accent-blue));
    border-bottom: 1px solid var(--border-color);
    border-radius: 1rem 1rem 0 0;
    padding: 1.5rem 2rem;
  }
  
  .modal-title {
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .modal-body {
    padding: 2rem;
  }

  /* ===== Loading Spinner ===== */
  .loading-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 3rem;
  }
  
  .custom-spinner {
    width: 3rem;
    height: 3rem;
    border: 3px solid var(--border-color);
    border-top: 3px solid var(--primary-blue);
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* ===== Responsive Design ===== */
  @media (max-width: 768px) {
    .header-content {
      flex-direction: column;
      gap: 1.5rem;
      text-align: center;
    }
    
    .header-title h2 {
      font-size: 2rem;
    }
    
    .action-group {
      flex-direction: column;
      gap: 0.25rem;
    }
    
    .action-btn {
      width: 100%;
      justify-content: center;
    }
    
    .enhanced-table {
      font-size: 0.85rem;
    }
    
    .enhanced-table thead th,
    .enhanced-table tbody td {
      padding: 0.75rem 1rem;
    }
    
    .staff-info {
      flex-direction: column;
      text-align: center;
    }
  }

  /* ===== Animation Enhancements ===== */
  .table-container,
  .pagination-container {
    animation: slideUp 0.6s ease-out;
  }
  
  @keyframes slideUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .enhanced-table tbody tr {
    animation: fadeIn 0.4s ease-out;
    animation-fill-mode: both;
  }
  
  .enhanced-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
  .enhanced-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
  .enhanced-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
  .enhanced-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
  .enhanced-table tbody tr:nth-child(5) { animation-delay: 0.5s; }
  
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateX(-20px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
</style>

<!-- Enhanced Page Header -->
<div class="page-header">
  <div class="header-content">
    <div class="header-title">
      <div class="header-icon">
        <i class="bi bi-calendar-week"></i>
      </div>
      <h2>Work Schedule</h2>
    </div>
    <a href="{{ route('schedules.create') }}" class="add-schedule-btn">
      <i class="bi bi-plus-lg"></i>
      Add New Schedule
    </a>
  </div>
</div>

<!-- Enhanced Success Alert -->
@if(session('success'))
  <div class="alert alert-success alert-enhanced alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Enhanced Table Container -->
<div class="table-container">
  <div class="table-header">
    <h3 class="table-title">
      <i class="bi bi-people-fill"></i>
      Staff Schedules
    </h3>
  </div>
  
  <table class="table enhanced-table">
    <thead>
      <tr>
        <th><i class="bi bi-person me-2"></i>Staff Information</th>
        <th><i class="bi bi-briefcase me-2"></i>Role</th>
        <th><i class="bi bi-calendar me-2"></i>Date</th>
        <th><i class="bi bi-clock me-2"></i>Shift Time</th>
        <th><i class="bi bi-building me-2"></i>Department</th>
        <th><i class="bi bi-gear me-2"></i>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($schedules as $sched)
        <tr>
          <td>
            <div class="staff-info">
              <div class="staff-avatar">
                {{ strtoupper(substr($sched->staff_name, 0, 2)) }}
              </div>
              <div class="staff-details">
                <h6>{{ $sched->staff_name }}</h6>
                <small>Employee ID: #{{ str_pad($sched->id, 4, '0', STR_PAD_LEFT) }}</small>
              </div>
            </div>
          </td>
          <td>
            @php
              $roleClass = match(strtolower($sched->role)) {
                'doctor' => 'role-doctor',
                'nurse' => 'role-nurse',
                'admin' => 'role-admin',
                default => 'role-default'
              };
            @endphp
            <span class="role-badge {{ $roleClass }}">{{ $sched->role }}</span>
          </td>
          <td>
            <div class="date-badge">
              {{ $sched->date->format('M d, Y') }}
            </div>
          </td>
          <td>
            @php
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
              <div class="time-display">
                {{ $displayStart }} – {{ $displayEnd }}
              </div>
            @else
              <div class="no-shift">
                <i class="bi bi-exclamation-triangle me-1"></i>
                No active shifts
              </div>
            @endif
          </td>
          <td>
            <strong>{{ $sched->department }}</strong>
          </td>
          <td>
            <div class="action-group">
              <button type="button" class="action-btn btn-view" data-bs-toggle="modal" data-bs-target="#scheduleModal" onclick="viewSchedule({{ $sched->id }})">
                <i class="bi bi-eye"></i>
                View
              </button>
              <a href="{{ route('schedules.edit', $sched) }}" class="action-btn btn-edit">
                <i class="bi bi-pencil"></i>
                Edit
              </a>
              <form action="{{ route('schedules.destroy', $sched) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                @csrf @method('DELETE')
                <button class="action-btn btn-delete">
                  <i class="bi bi-trash"></i>
                  Delete
                </button>
              </form>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Enhanced Pagination -->
@if ($schedules->hasPages())
<div class="pagination-container">
  <div class="pagination-wrapper">
    <nav aria-label="Page navigation">
      <ul class="enhanced-pagination">
        {{-- Previous Page Link --}}
        @if ($schedules->onFirstPage())
          <li class="page-item disabled">
            <span class="page-link">
              <i class="bi bi-chevron-left"></i>
            </span>
          </li>
        @else
          <li class="page-item">
            <a class="page-link" href="{{ $schedules->previousPageUrl() }}" rel="prev">
              <i class="bi bi-chevron-left"></i>
            </a>
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
            <a class="page-link" href="{{ $schedules->nextPageUrl() }}" rel="next">
              <i class="bi bi-chevron-right"></i>
            </a>
          </li>
        @else
          <li class="page-item disabled">
            <span class="page-link">
              <i class="bi bi-chevron-right"></i>
            </span>
          </li>
        @endif
      </ul>
    </nav>
  </div>

  <!-- Enhanced Results Info -->
  <div class="pagination-info">
    <div>
      <span class="info-badge">
        {{ $schedules->firstItem() ?? 0 }} - {{ $schedules->lastItem() ?? 0 }} of {{ number_format($schedules->total()) }}
      </span>
      <small class="ms-2">results displayed</small>
    </div>
    <div>
      <small>Page {{ $schedules->currentPage() }} of {{ $schedules->lastPage() }}</small>
    </div>
  </div>
</div>
@endif

<!-- Enhanced Schedule View Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="scheduleModalLabel">
          <i class="bi bi-calendar-check"></i>
          Schedule Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="scheduleModalBody">
        <div class="loading-container">
          <div class="custom-spinner"></div>
          <p class="text-muted">Loading schedule details...</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-2"></i>Close
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function viewSchedule(scheduleId) {
  // Show enhanced loading spinner
  document.getElementById('scheduleModalBody').innerHTML = `
    <div class="loading-container">
      <div class="custom-spinner"></div>
      <p class="text-muted">Loading schedule details...</p>
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
        <div class="alert alert-danger d-flex align-items-center">
          <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
          <div>
            <h6 class="mb-1">Error Loading Schedule</h6>
            <small class="text-muted">Unable to load schedule details. Please try again later.</small>
            <br><small class="text-muted">Error: ${error.message}</small>
          </div>
        </div>
      `;
    });
}
  document.addEventListener('DOMContentLoaded', function() {
    const paginationLinks = document.querySelectorAll('.enhanced-pagination .page-link');
    const tableContainer = document.querySelector('.table-container');

    if (!tableContainer) return;

    paginationLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetUrl = this.getAttribute('href');

        // Smooth scroll to the top of the table container
        const offsetTop = tableContainer.getBoundingClientRect().top + window.pageYOffset - 20;
        window.scrollTo({ top: offsetTop, behavior: 'smooth' });

        // After scrolling animation, navigate to the new page
        setTimeout(() => {
          window.location.href = targetUrl;
        }, 400);
      });
    });
  });
</script>
@endpush