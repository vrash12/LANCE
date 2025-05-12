@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Edit Patient</h2>

  <form action="{{ route('patients.update', $patient) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" value="{{ $patient->name }}" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Birth Date</label>
      <input type="date" name="birth_date" value="{{ $patient->birth_date }}" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Contact No.</label>
      <input type="text" name="contact_no" value="{{ $patient->contact_no }}" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control" rows="2">{{ $patient->address }}</textarea>
    </div>
    <button class="btn btn-info">Update</button>
    <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
