@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Add New User</h2>

  <form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label class="form-label">Name</label>
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
      <label class="form-label">Email</label>
      <input type="email"
             name="email"
             value="{{ old('email') }}"
             class="form-control @error('email') is-invalid @enderror"
             required>
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Role</label>
      <select name="role"
              class="form-select @error('role') is-invalid @enderror"
              required>
        <option value="admin"   {{ old('role')=='admin'   ? 'selected':'' }}>Admin</option>
        <option value="encoder" {{ old('role')=='encoder' ? 'selected':'' }}>Encoder</option>
        <option value="patient" {{ old('role')=='patient' ? 'selected':'' }}>Patient</option>
      </select>
      @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Password</label>
        <input type="password"
               name="password"
               class="form-control @error('password') is-invalid @enderror"
               required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password"
               name="password_confirmation"
               class="form-control"
               required>
      </div>
    </div>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
