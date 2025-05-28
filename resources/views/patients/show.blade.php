{{-- resources/views/patients/show.blade.php --}}
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
        <tr>
          <th class="w-25">Name</th>
          <td>{{ $patient->name }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{ optional($patient->user)->email ?? '—' }}</td>
        </tr>
        <tr>
          <th>Birth Date</th>
          <td>{{ $patient->birth_date ?? '—' }}</td>
        </tr>
        <tr>
          <th>Contact No.</th>
          <td>{{ $patient->contact_no ?? '—' }}</td>
        </tr>
        <tr>
          <th>Address</th>
          <td>{{ $patient->address ?? '—' }}</td>
        </tr>
        <tr>
          <th>Created At</th>
          <td>{{ $patient->created_at->format('Y-m-d H:i') }}</td>
        </tr>
      </table>
    </div>
    <div class="card-footer bg-white text-end">
      <a href="{{ route('patients.edit', $patient) }}"
         class="btn btn-sm btn-info me-2">
        <i class="bi bi-pencil-square"></i> Edit
      </a>
      <a href="{{ route('ob-opd-forms.index') }}"
         class="btn btn-sm btn-secondary">
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
          <tr>
            <th class="w-25">Sex</th>
            <td>{{ ucfirst($patient->profile->sex ?? '—') }}</td>
          </tr>
          <tr>
            <th>Religion</th>
            <td>{{ $patient->profile->religion ?? '—' }}</td>
          </tr>
          <tr>
            <th>Date Recorded</th>
            <td>{{ $patient->profile->date_recorded ?? '—' }}</td>
          </tr>
          <tr>
            <th>Place of Marriage</th>
            <td>{{ $patient->profile->place_of_marriage ?? '—' }}</td>
          </tr>
          <tr>
            <th>Date of Marriage</th>
            <td>{{ $patient->profile->date_of_marriage ?? '—' }}</td>
          </tr>
          <tr>
            <th>Family Planning</th>
            <td>{{ $patient->profile->family_planning ?? '—' }}</td>
          </tr>
          <tr>
            <th>Previous PNC</th>
            <td>{{ $patient->profile->prev_pnc ?? '—' }}</td>
          </tr>
          <tr>
            <th>LMP</th>
            <td>{{ $patient->profile->lmp ?? '—' }}</td>
          </tr>
          <tr>
            <th>EDC</th>
            <td>{{ $patient->profile->edc ?? '—' }}</td>
          </tr>
          <tr>
            <th>Gravida</th>
            <td>{{ $patient->profile->gravida ?? '—' }}</td>
          </tr>
          <tr>
            <th>Parity (T/P/A/L)</th>
            <td>
              {{ $patient->profile->parity_t ?? '—' }} /
              {{ $patient->profile->parity_p ?? '—' }} /
              {{ $patient->profile->parity_a ?? '—' }} /
              {{ $patient->profile->parity_l ?? '—' }}
            </td>
          </tr>
          <tr>
            <th>AOG (weeks)</th>
            <td>{{ $patient->profile->aog_weeks ?? '—' }}</td>
          </tr>
          <tr>
            <th>Chief Complaint</th>
            <td>{{ $patient->profile->chief_complaint ?? '—' }}</td>
          </tr>
          <tr>
            <th>HEENT</th>
            <td>{{ $patient->profile->heent ?? '—' }}</td>
          </tr>
          <tr>
            <th>Heart &amp; Lungs</th>
            <td>{{ $patient->profile->heart_lungs ?? '—' }}</td>
          </tr>
          <tr>
            <th>Diagnosis</th>
            <td>{{ $patient->profile->diagnosis ?? '—' }}</td>
          </tr>
          <tr>
            <th>Prepared By</th>
            <td>{{ $patient->profile->prepared_by ?? '—' }}</td>
          </tr>
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
              <th>Date &amp; Time</th>
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
                <td colspan="2" class="text-center text-muted py-3">
                  No visits yet.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer bg-white text-end">
      <a href="{{ route('ob-opd-forms.index') }}" class="btn btn-sm btn-secondary">
        ← Back to Submissions
      </a>
    </div>
  </div>

</div>
@endsection
