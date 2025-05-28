{{-- resources/views/opd_forms/high_risk/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
  <h1 class="h3">Submission #{{ $submission->id }} – High Risk</h1>
</div>

<div class="card mb-4 shadow-sm">
  <div class="card-body">
    <h5>Patient:</h5>
    <p>{{ optional($submission->patient)->name ?? '— unassigned' }}</p>
    <h5>Answers (raw JSON):</h5>
    <pre class="border p-3 bg-light">{{ json_encode($submission->answers, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) }}</pre>
  </div>
  <div class="card-footer bg-white text-end">
    <a href="{{ route('high-risk-opd-forms.index') }}" class="btn btn-secondary">
      ← Back to list
    </a>
    <a href="{{ route('high-risk-opd-forms.edit', $submission) }}" class="btn btn-info">
      Edit
    </a>
  </div>
</div>
@endsection
