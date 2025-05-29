{{-- resources/views/encoder/opd/index.blade.php --}}
@extends('layouts.encoder')

@section('content')
<div class="container">

  {{-- header with Add button --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Patient Profiles (OB)</h1>
    <a href="{{ route('encoder.opd.create') }}"
       class="btn btn-success">
      <i class="bi bi-plus-lg"></i> Add Profile
    </a>
  </div>

  <table class="table table-bordered align-middle">
    <thead>
      <tr>
        <th>Date&nbsp;Recorded</th>
        <th>Patient</th>
        <th>Gravida / Parity</th>
        <th>Prepared By</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($profiles as $profile)
        <tr>
          <td>
            {{ $profile->date_recorded
                ? $profile->date_recorded->toDateString()
                : '—' }}
          </td>
          <td>{{ optional($profile->patient)->name ?? '— unassigned' }}</td>
          <td>
            {{ $profile->gravida ?? '—' }} /
            {{ $profile->parity_t ?? 0 }}-
            {{ $profile->parity_p ?? 0 }}-
            {{ $profile->parity_a ?? 0 }}-
            {{ $profile->parity_l ?? 0 }}
          </td>
          <td>{{ $profile->prepared_by ?? '—' }}</td>
          <td class="text-center">
            <a href="{{ route('encoder.opd.show', $profile) }}"
               class="btn btn-sm btn-primary">
              <i class="bi bi-eye"></i>
            </a>
            <a href="{{ route('encoder.opd.edit', $profile) }}"
               class="btn btn-sm btn-warning">
              <i class="bi bi-pencil"></i>
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center py-3">No profiles yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
