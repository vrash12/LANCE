{{-- resources/views/auth/passwords/reset.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
  body, html { height:100%; margin:0; }
  .auth-container { min-height:100vh; display:flex; align-items:center; justify-content:center; padding:2rem; }
  .auth-card {
    background: #fff;
    border-radius: .5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    max-width: 400px; width:100%; padding:2rem;
  }
  .auth-card h2 {
    text-align:center; margin-bottom:1.5rem; color:#0e4749;
  }
  .form-control { border-radius:.25rem; }
  .btn-submit { background:#00b467; border:none; width:100%; padding:.75rem; font-weight:600; text-transform:uppercase; }
  .btn-submit:hover { background:#009455; }
  .invalid-feedback { display:block; }
</style>

<div class="auth-container">
  <div class="auth-card">
    <h2>Reset Your Password</h2>

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      {{-- Token (from emailed link) --}}
      <input type="hidden" name="token" value="{{ $token }}">

      {{-- Email --}}
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input id="email" type="email"
               class="form-control @error('email') is-invalid @enderror"
               name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- New Password --}}
      <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input id="password" type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password" required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Confirm Password --}}
      <div class="mb-3">
        <label for="password-confirm" class="form-label">Confirm New Password</label>
        <input id="password-confirm" type="password"
               class="form-control"
               name="password_confirmation" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-submit">Reset Password</button>
      </div>
    </form>
  </div>
</div>
@endsection
