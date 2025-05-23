@extends('layouts.admin')

@section('content')
<div class="container">

  {{-- PATIENT BASIC INFO --}}
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-white">
      <strong><i class="bi bi-person-lines-fill"></i> Patient Information</strong>
    </div>
    <div class="card-body">
      <table class="table table-borderless mb-0">
        <tr><th class="w-25">Name</th><td>{{ $patient->name }}</td></tr>
        <tr><th>Email</th><td>{{ $patient->user->email }}</td></tr>
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

  {{-- EXTENDED PROFILE --}}
  @if($patient->profile)
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-white">
      <strong><i class="bi bi-file-earmark-medical"></i> Profile Details</strong>
    </div>
    <div class="card-body">
      <table class="table table-borderless mb-0">

        <tr><th class="w-25">Sex</th><td>{{ ucfirst($patient->profile->sex ?? '—') }}</td></tr>
        <tr><th>Religion</th><td>{{ $patient->profile->religion ?? '—' }}</td></tr>
        <tr><th>Date Recorded</th><td>{{ $patient->profile->date_recorded ?? '—' }}</td></tr>

        <tr><th>Father’s Name</th><td>{{ $patient->profile->father_name ?? '—' }}</td></tr>
        <tr><th>Father’s Occupation</th><td>{{ $patient->profile->father_occupation ?? '—' }}</td></tr>
        <tr><th>Mother’s Name</th><td>{{ $patient->profile->mother_name ?? '—' }}</td></tr>
        <tr><th>Mother’s Occupation</th><td>{{ $patient->profile->mother_occupation ?? '—' }}</td></tr>

        <tr><th>Place of Marriage</th><td>{{ $patient->profile->place_of_marriage ?? '—' }}</td></tr>
        <tr><th>Date of Marriage</th><td>{{ $patient->profile->date_of_marriage ?? '—' }}</td></tr>

        <tr><th>Blood Type</th><td>{{ $patient->profile->blood_type ?? '—' }}</td></tr>
        <tr><th>Delivery Type</th><td>{{ $patient->profile->delivery_type ?? '—' }}</td></tr>
        <tr><th>Birth Weight (kg)</th><td>{{ $patient->profile->birth_weight ?? '—' }}</td></tr>
        <tr><th>Birth Length (cm)</th><td>{{ $patient->profile->birth_length ?? '—' }}</td></tr>

        <tr><th colspan="2" class="pt-4"><strong>APGAR Scores</strong></th></tr>
        <tr><td>Appearance</td><td>{{ $patient->profile->apgar_appearance ?? '—' }}</td></tr>
        <tr><td>Pulse</td><td>{{ $patient->profile->apgar_pulse ?? '—' }}</td></tr>
        <tr><td>Grimace</td><td>{{ $patient->profile->apgar_grimace ?? '—' }}</td></tr>
        <tr><td>Activity</td><td>{{ $patient->profile->apgar_activity ?? '—' }}</td></tr>
        <tr><td>Respiration</td><td>{{ $patient->profile->apgar_respiration ?? '—' }}</td></tr>

      </table>
    </div>
  </div>
  @endif

  {{-- VISIT HISTORY --}}
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
