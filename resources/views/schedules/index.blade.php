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
      <td>{{ \Carbon\Carbon::parse($sched->shift_start)->format('h:i A') }}
          – {{ \Carbon\Carbon::parse($sched->shift_end)->format('h:i A') }}</td>
      <td>{{ $sched->department }}</td>
      <td>
        <a href="{{ route('schedules.edit', $sched) }}" class="btn btn-sm btn-info">Edit</a>
        <form action="{{ route('schedules.destroy',$sched) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Delete this schedule?');">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="mt-3">
  {{ $schedules->links() }}
</div>
@endsection
