@extends('layouts.app')

@section('content')
<div class="container col-md-6">
  <h2 class="mb-4">Change Password</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('password.change.update') }}">
    @csrf

    {{-- Current password --}}
    <div class="mb-3">
      <label for="current_password" class="form-label">Current Password</label>
      <input id="current_password" name="current_password" type="password"
             class="form-control @error('current_password') is-invalid @enderror" required>
      @error('current_password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- New password --}}
    <div class="mb-3">
      <label for="password" class="form-label">New Password</label>
      <input id="password" name="password" type="password"
             class="form-control @error('password') is-invalid @enderror" required>
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Confirm --}}
    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Confirm New Password</label>
      <input id="password_confirmation" name="password_confirmation" type="password"
             class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Update Password</button>
    <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
