@extends('layouts.encoder')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Add Patient</h2>
  <form action="{{ route('encoder.patients.store') }}" method="POST">
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
      <textarea name="address" rows="2" class="form-control"></textarea>
    </div>
    <button class="btn btn-success">Save Patient</button>
  </form>
</div>
@endsection
