@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h1>All OPD Submissions</h1>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Patient</th>
      <th>Form</th>
      <th>Submitted At</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($subs as $s)
      <tr>
        <td>{{ $s->patient->name }}</td>
        <td>{{ $s->form->name }}</td>
        <td>{{ $s->created_at->format('Y-m-d H:i') }}</td>
        <td>
          <a href="{{ route('opd_submissions.show',$s) }}" class="btn btn-sm btn-info">View</a>
          <form method="POST" action="{{ route('opd_submissions.destroy',$s) }}"
                class="d-inline" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{{ $subs->links() }}
@endsection
