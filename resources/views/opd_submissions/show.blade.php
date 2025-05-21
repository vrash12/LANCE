@extends('layouts.admin')

@section('content')
<div class="container col-md-8">
  <h2 class="mb-3">Submission Detail</h2>

  <table class="table">
    <tr><th>Patient</th><td>{{ $opd_submission->patient->name }}</td></tr>
    <tr><th>Form</th><td>{{ $opd_submission->form->name }}</td></tr>
    <tr><th>Responses</th><td><pre>{{ json_decode($opd_submission->responses) }}</pre></td></tr>
    <tr><th>Submitted At</th><td>{{ $opd_submission->created_at->format('Y-m-d H:i') }}</td></tr>
  </table>

  <a href="{{ route('opd_submissions.index') }}" class="btn btn-secondary">Back</a>
@endsection
