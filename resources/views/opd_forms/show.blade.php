@extends('layouts.admin')
@section('content')
<div class="container col-lg-8">
  <div class="page-header mb-3" style="background:#00b467;color:#fff;padding:1rem 1.5rem;border-radius:.25rem;display:flex;justify-content:space-between;align-items:center;">
    <h2 class="m-0">OPD Form</h2>
    <img src="{{ asset('images/fabella-logo.png') }}" width="60">
  </div>
  <h5 class="bg-dark text-white p-2 rounded">{{ $opd_form->name }}</h5>
  <table class="table">
    <tr><th>Form No.</th><td>{{ $opd_form->form_no }}</td></tr>
    <tr><th>Department</th><td>{{ $opd_form->department }}</td></tr>
    <tr><th>Created</th><td>{{ $opd_form->created_at->format('Y-m-d H:i') }}</td></tr>
  </table>
  <a href="{{ route('opd_forms.edit',$opd_form) }}" class="btn btn-info">Edit</a>
  <a href="{{ route('opd_forms.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
