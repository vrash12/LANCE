@extends('layouts.admin')

@section('content')
  <h1>Submission #{{ $submission->id }} for {{ $submission->form->name }}</h1>

  <p><strong>Patient:</strong>
     {{ optional($submission->patient)->name ?? '— unassigned' }}</p>

  <h2>Answers</h2>
  <pre>{{ json_encode($submission->answers, JSON_PRETTY_PRINT) }}</pre>

  <a href="{{ route('ob-opd-forms.index') }}">← back to list</a>
@endsection
