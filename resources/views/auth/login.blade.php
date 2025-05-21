@extends('layouts.app')

@section('content')
<style>
  :root {
    --fc-green: #0e4749;    /* theme green */
    --fc-accent:#00b467;    /* button / accent green */
  }
  html,body {height:100%;margin:0}
  .login-container {min-height:100vh;display:flex}

  /* LEFT :: doctor image */
  .login-image {
    flex:1;
    background:url('{{ asset("images/doctor.jpg") }}') center/cover no-repeat;
  }

  /* RIGHT :: wrapper & card */
  .login-form-wrapper {
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    background:var(--fc-green);
    padding:2rem;
  }
  .login-card{
    width:100%;
    max-width:380px;
    background:#fff;
    border-radius:.75rem;
    padding:2.5rem 2rem;
    box-shadow:0 10px 24px rgba(0,0,0,.12);
    animation:fadeIn .5s ease;
  }
  @keyframes fadeIn{from{opacity:0;transform:translateY(20px)} to{opacity:1}}

  /* Logo + heading */
  .login-card .logo {width:90px;display:block;margin:0 auto 1rem}
  .login-card h2   {text-align:center;font-size:1.35rem;font-weight:700;color:var(--fc-green);margin-bottom:1.75rem}

  /* Inputs */
  .input-group-text{background:var(--fc-accent);border:none;color:#fff}
  .form-control    {border-radius:.25rem}
  .form-control:focus{box-shadow:0 0 0 .2rem rgba(0,180,103,.25);border-color:var(--fc-accent)}

  /* Button */
  .btn-login{
    background:var(--fc-accent);
    border:none;
    padding:.8rem;
    font-weight:600;
    letter-spacing:.5px;
    text-transform:uppercase;
    transition:background .2s ease;
  }
  .btn-login:hover {background:#009455}

  /* Misc */
  .forgot-link{font-size:.85rem;color:#666}
  .forgot-link:hover{color:var(--fc-accent)}
</style>

<!-- ====== VIEW ====== -->
<div class="login-container">
  <div class="login-image d-none d-md-block"></div>

  <div class="login-form-wrapper">
    <div class="login-card">
      <img src="{{ asset('images/fabella-logo.png') }}" alt="Fabella Logo" class="logo">
      <h2>FabellaCares&nbsp;OPD&nbsp;System</h2>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
          <input id="email" type="email" name="email"
                 class="form-control @error('email') is-invalid @enderror"
                 value="{{ old('email') }}" placeholder="Email" required autofocus>
          @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <!-- Password -->
        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
          <input id="password" type="password" name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 placeholder="Password" required>
          @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <!-- Forgot -->
        @if(Route::has('password.request'))
          <div class="mb-3 text-end">
            <a class="forgot-link text-decoration-none" href="{{ route('password.request') }}">
              Forgot password?
            </a>
          </div>
        @endif

        <!-- Login button -->
        <div class="d-grid">
          <button type="submit" class="btn btn-login btn-lg">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Font-Awesome -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-p8f+Yqf4C6z3sZ4+PsN8/ec8Y5KSJNkxFq0KM+XTRqSBXl0+IRHtdf7qyYNh+1kKEmnA0A6Z1MJP5C9QwbQfKA=="
      crossorigin="anonymous" referrerpolicy="no-referrer">
@endsection
