@extends('layouts.encoder')

@section('content')
<div class="page-header">
  <h1>Patient Records</h1>
  <a href="{{ route('encoder.patients.create') }}" class="btn btn-success">Add New Patient</a>
</div>
<table class="table">
  <thead>
    <tr>
      <th>Name</th>
      <th>Contact</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($patients as $patient)
      <tr>
        <td>{{ $patient->name }}</td>
        <td>{{ $patient->contact_no }}</td>
        <td>
          <a href="{{ route('encoder.patients.show', $patient) }}" class="btn btn-info">View</a>
          <a href="{{ route('encoder.patients.edit', $patient) }}" class="btn btn-warning">Edit</a>
          <form action="{{ route('encoder.patients.destroy', $patient) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button class="btn btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
