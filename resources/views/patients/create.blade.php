@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Add Patient</h2>

  <form action="{{ route('patients.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Birth Date</label>
      <input type="date" name="birth_date" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Contact No.</label>
      <input type="text" name="contact_no" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control" rows="2"></textarea>
    </div>
    <button class="btn btn-success">Save</button>
    <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
