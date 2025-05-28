@extends('layouts.encoder')

@section('content')
<h2>Patient Details</h2>
<table class="table">
  <tr><th>Name</th><td>{{ $patient->name }}</td></tr>
  <tr><th>Birth Date</th><td>{{ $patient->birth_date }}</td></tr>
  <tr><th>Contact No.</th><td>{{ $patient->contact_no }}</td></tr>
  <tr><th>Address</th><td>{{ $patient->address }}</td></tr>
</table>
<a href="{{ route('encoder.patients.edit', $patient) }}" class="btn btn-warning">Edit</a>
@endsection
