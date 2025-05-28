@extends('layouts.encoder')

@section('content')
<div class="container col-lg-8">
  <h2 class="mb-4">Edit Patient</h2>
  <form action="{{ route('encoder.patients.update', $patient) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" value="{{ $patient->name }}" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Birth Date</label>
      <input type="date" name="birth_date" class="form-control" value="{{ $patient->birth_date }}">
    </div>
    <div class="mb-3">
      <label class="form-label">Contact No.</label>
      <input type="text" name="contact_no" class="form-control" value="{{ $patient->contact_no }}">
    </div>
    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea name="address" rows="2" class="form-control">{{ $patient->address }}</textarea>
    </div>
    <button class="btn btn-info">Update Patient</button>
  </form>
</div>
@endsection
