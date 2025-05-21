@extends('layouts.admin')

@section('content')
<div class="container col-lg-8">
  <div class="page-header mb-3"
       style="background:#00b467;color:#fff;
              padding:1rem 1.5rem;border-radius:.25rem;
              display:flex;justify-content:space-between;
              align-items:center;">
    <h2 class="m-0">OPD Form</h2>
    <img src="{{ asset('images/fabella-logo.png') }}" width="60" alt="Fabella Logo">
  </div>

  <h5 class="bg-dark text-white p-2 rounded">{{ $opd_form->name }}</h5>

  <table class="table">
    <tr><th>Form No.</th><td>{{ $opd_form->form_no }}</td></tr>
    <tr><th>Department</th><td>{{ $opd_form->department }}</td></tr>
    <tr><th>Created</th><td>{{ $opd_form->created_at->format('Y-m-d H:i') }}</td></tr>
  </table>

  <div class="d-flex gap-2">
    <a href="{{ route('opd_forms.edit', $opd_form) }}" class="btn btn-info">
      <i class="bi bi-pencil-fill"></i> Edit
    </a>
    <a href="{{ route('opd_forms.export.pdf', $opd_form) }}" class="btn btn-outline-danger">
      <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
    </a>
    <a href="{{ route('opd_forms.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left-circle"></i> Back
    </a>
  </div>
</div>
@endsection
