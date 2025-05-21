@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Add Patient</h2>

  <form action="{{ route('patients.store') }}" method="POST">
    @csrf

    {{-- Login credentials --}}
    <div class="mb-3">
      <label class="form-label">Email (username)</label>
      <input type="email" name="email"
             class="form-control @error('email') is-invalid @enderror"
             value="{{ old('email') }}" required>
      @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3 row">
      <div class="col">
        <label class="form-label">Password</label>
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               required>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>
    </div>

    {{-- Profile fields --}}
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
