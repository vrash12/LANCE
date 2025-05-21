@extends('layouts.encoder') {{-- or a dedicated encoder layout --}}

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>My OPD Submissions</h2>
    <a href="{{ route('encoder.opd.create') }}" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> New Submission
    </a>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr><th>Form</th><th>Patient</th><th>Date</th><th>Action</th></tr>
    </thead>
    <tbody>
    @forelse($subs as $s)
      <tr>
        <td>{{ $s->form->name }}</td>
        <td>{{ $s->patient->name }}</td>
        <td>{{ $s->created_at->format('Y-m-d H:i') }}</td>
        <td>
          <a href="{{ route('encoder.opd.show',$s) }}"
             class="btn btn-sm btn-primary">View</a>
        </td>
      </tr>
    @empty
      <tr><td colspan="4">No submissions yet.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
@endsection
