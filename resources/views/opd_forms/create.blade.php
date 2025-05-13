@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Add New OPD Form</h2>

  <form action="{{ route('opd_forms.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label class="form-label">Form Name</label>
      <input type="text"
             name="name"
             value="{{ old('name') }}"
             class="form-control @error('name') is-invalid @enderror"
             required>
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Form No.</label>
      <input type="text"
             name="form_no"
             value="{{ old('form_no') }}"
             class="form-control @error('form_no') is-invalid @enderror"
             required>
      @error('form_no')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Department</label>
      <input type="text"
             name="department"
             value="{{ old('department') }}"
             class="form-control @error('department') is-invalid @enderror"
             required>
      @error('department')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('opd_forms.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
