{{-- resources/views/patients/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container">

  {{-- Patient Details --}}
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-white">
      <strong><i class="bi bi-person-lines-fill"></i> Patient Details</strong>
    </div>
    <div class="card-body">
      <table class="table table-borderless mb-0">
        <tr><th class="w-25">Name</th><td>{{ $patient->name }}</td></tr>
        <tr><th>Birth Date</th><td>{{ $patient->birth_date ?? '—' }}</td></tr>
        <tr><th>Contact No.</th><td>{{ $patient->contact_no ?? '—' }}</td></tr>
        <tr><th>Address</th><td>{{ $patient->address ?? '—' }}</td></tr>
        <tr><th>Created At</th><td>{{ $patient->created_at->format('Y-m-d H:i') }}</td></tr>
      </table>
    </div>
    <div class="card-footer bg-white text-end">
      <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-info me-2">
        <i class="bi bi-pencil-square"></i> Edit
      </a>
      <a href="{{ route('patients.index') }}" class="btn btn-sm btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
      </a>
    </div>
  </div>

  {{-- Visit History --}}
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-white">
      <strong><i class="bi bi-clock-history"></i> Visit History</strong>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped mb-0">
          <thead class="table-light">
            <tr>
              <th>Date</th>
              <th>Notes</th>
            </tr>
          </thead>
          <tbody>
            @forelse($patient->visits as $visit)
              <tr>
                <td>{{ \Carbon\Carbon::parse($visit->visited_at)->format('M j, Y H:i') }}</td>
                <td>{{ $visit->notes }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center text-muted py-3">No visits yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between">
      <div>
        <a href="{{ route('patients.export.excel', $patient) }}" class="btn btn-sm btn-success me-2">
          <i class="bi bi-file-earmark-spreadsheet-fill"></i> Export Excel
        </a>
        <a href="{{ route('patients.export.pdf', $patient) }}" class="btn btn-sm btn-danger">
          <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
        </a>
      </div>
    </div>
  </div>

</div>
@endsection
