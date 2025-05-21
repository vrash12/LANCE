@extends('layouts.app')

@section('content')
<div class="container col-md-6">
  <h3 class="mb-4">Forgot Password</h3>

  @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="mb-3">
          <label class="form-label">Email address</label>
          <input type="email"
                 name="email"
                 class="form-control @error('email') is-invalid @enderror"
                 value="{{ old('email') }}"
                 required autofocus>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <button class="btn btn-primary">Send Reset Link</button>
      <a href="{{ route('login') }}" class="btn btn-link">Back to login</a>
  </form>
</div>
@endsection
