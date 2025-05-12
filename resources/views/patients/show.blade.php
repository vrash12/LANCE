@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Patient Details</h2>

  <table class="table">
    <tr><th>Name</th><td>{{ $patient->name }}</td></tr>
    <tr><th>Birth Date</th><td>{{ $patient->birth_date ?? '—' }}</td></tr>
    <tr><th>Contact No.</th><td>{{ $patient->contact_no ?? '—' }}</td></tr>
    <tr><th>Address</th><td>{{ $patient->address ?? '—' }}</td></tr>
    <tr><th>Created</th><td>{{ $patient->created_at->format('Y-m-d H:i') }}</td></tr>
  </table>

  <a href="{{ route('patients.edit', $patient) }}" class="btn btn-info">Edit</a>
  <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
