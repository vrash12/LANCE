@extends('layouts.app')

@section('content')
<style>
  :root {
    --fc-primary: #0e4749;
    --fc-accent: #00b467;
    --fc-light: #f8fafc;
    --fc-shadow: rgba(14, 71, 73, 0.1);
    --fc-gradient: linear-gradient(135deg, #0e4749 0%, #1a5f61 100%);
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  html, body {
    height: 100%;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .login-container {
    min-height: 100vh;
    display: flex;
    position: relative;
    overflow: hidden;
  }

  /* Animated background */
  .login-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--fc-gradient);
    z-index: 1;
  }

  .login-container::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: float 20s ease-in-out infinite;
    z-index: 2;
  }

  @keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(30px, -30px) rotate(120deg); }
    66% { transform: translate(-20px, 20px) rotate(240deg); }
  }

  /* Left side - Medical illustration */
  .login-image {
    flex: 1;
    position: relative;
    z-index: 3;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
  }

  .medical-illustration {
    width: 100%;
    max-width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    border: 2px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(20px);
    animation: pulse 3s ease-in-out infinite;
  }

  @keyframes pulse {
    0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); }
    50% { transform: scale(1.02); box-shadow: 0 0 0 20px rgba(255, 255, 255, 0); }
  }

  .medical-icon {
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 1rem;
    animation: heartbeat 2s ease-in-out infinite;
  }

  @keyframes heartbeat {
    0%, 50%, 100% { transform: scale(1); }
    25% { transform: scale(1.1); }
  }

  .medical-text {
    color: rgba(255, 255, 255, 0.8);
    text-align: center;
    font-size: 1.1rem;
    font-weight: 300;
  }

  /* Right side - Login form */
  .login-form-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    position: relative;
    z-index: 3;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
  }

  .login-card {
    width: 100%;
    max-width: 420px;
    background: #ffffff;
    border-radius: 24px;
    padding: 3rem 2.5rem;
    box-shadow: 
      0 20px 40px rgba(14, 71, 73, 0.1),
      0 8px 16px rgba(14, 71, 73, 0.05),
      inset 0 1px 0 rgba(255, 255, 255, 0.9);
    animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
  }

  .login-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--fc-accent), var(--fc-primary));
    border-radius: 24px 24px 0 0;
  }

  @keyframes slideUp {
    from {
      opacity: 0;
      transform: translateY(40px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Logo and header */
  .logo-container {
    text-align: center;
    margin-bottom: 2.5rem;
  }

  .logo {
    width: 80px;
    height: 80px;
    background: var(--fc-gradient);
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 8px 24px rgba(14, 71, 73, 0.2);
  }

  .logo i {
    font-size: 2rem;
    color: white;
  }

  .login-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--fc-primary);
    margin-bottom: 0.5rem;
    letter-spacing: -0.025em;
  }

  .login-subtitle {
    color: #64748b;
    font-size: 0.95rem;
    font-weight: 400;
  }

  /* Form styling */
  .form-group {
    margin-bottom: 1.5rem;
    position: relative;
  }

  .input-group {
    position: relative;
    display: flex;
    align-items: center;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
  }

  .input-group:focus-within {
    border-color: var(--fc-accent);
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(0, 180, 103, 0.1);
    transform: translateY(-2px);
  }

  .input-group-text {
    background: transparent;
    border: none;
    color: #64748b;
    padding: 1rem 1.25rem;
    font-size: 1.1rem;
    transition: color 0.2s ease;
  }

  .input-group:focus-within .input-group-text {
    color: var(--fc-accent);
  }

  .form-control {
    background: transparent;
    border: none;
    padding: 1rem 1.25rem 1rem 0;
    font-size: 1rem;
    color: #1e293b;
    flex: 1;
  }

  .form-control:focus {
    outline: none;
    box-shadow: none;
  }

  .form-control::placeholder {
    color: #94a3b8;
    font-weight: 400;
  }

  /* Error states */
  .input-group.is-invalid {
    border-color: #ef4444;
    background: #fef2f2;
  }

  .invalid-feedback {
    display: block;
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    margin-left: 0.75rem;
  }

  /* Forgot password link */
  .forgot-container {
    text-align: right;
    margin-bottom: 2rem;
  }

  .forgot-link {
    color: #64748b;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    position: relative;
  }

  .forgot-link:hover {
    color: var(--fc-accent);
  }

  .forgot-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--fc-accent);
    transition: width 0.3s ease;
  }

  .forgot-link:hover::after {
    width: 100%;
  }

  /* Login button */
  .btn-login {
    width: 100%;
    background: var(--fc-gradient);
    border: none;
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    color: white;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(14, 71, 73, 0.3);
  }

  .btn-login::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: all 0.6s ease;
  }

  .btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(14, 71, 73, 0.4);
  }

  .btn-login:hover::before {
    width: 300px;
    height: 300px;
  }

  .btn-login:active {
    transform: translateY(0);
  }

  /* Responsive design */
  @media (max-width: 768px) {
    .login-image {
      display: none;
    }
    
    .login-form-wrapper {
      flex: 1;
      background: var(--fc-gradient);
    }
    
    .login-card {
      margin: 1rem;
      padding: 2rem 1.5rem;
    }
    
    .login-title {
      font-size: 1.5rem;
    }
  }

  @media (max-width: 480px) {
    .login-card {
      padding: 2rem 1.25rem;
    }
    
    .logo {
      width: 60px;
      height: 60px;
    }
    
    .logo i {
      font-size: 1.5rem;
    }
  }

  /* Loading animation */
  .btn-login.loading {
    pointer-events: none;
    opacity: 0.8;
  }

  .btn-login.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

<!-- Login Container -->
<div class="login-container">
  <!-- Left Side - Medical Illustration -->
  <div class="login-image d-none d-md-flex">
    <div class="medical-illustration">
      <div class="medical-icon">
        <i class="fas fa-heartbeat"></i>
      </div>
      <div class="medical-text">
        <strong>Digital Healthcare</strong><br>
        Advanced Patient Care System
      </div>
    </div>
  </div>

  <!-- Right Side - Login Form -->
  <div class="login-form-wrapper">
    <div class="login-card">
      <!-- Logo and Header -->
      <div class="logo-container">
        <div class="logo">
          <i class="fas fa-hospital-alt"></i>
        </div>
        <h1 class="login-title">FabellaCares</h1>
        <p class="login-subtitle">OPD Management System</p>
      </div>

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <!-- Email Input -->
        <div class="form-group">
          <div class="input-group @error('email') is-invalid @enderror">
            <span class="input-group-text">
              <i class="fas fa-envelope"></i>
            </span>
            <input id="email" 
                   type="email" 
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}" 
                   placeholder="Enter your email address"
                   required 
                   autofocus>
          </div>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Password Input -->
        <div class="form-group">
          <div class="input-group @error('password') is-invalid @enderror">
            <span class="input-group-text">
              <i class="fas fa-lock"></i>
            </span>
            <input id="password" 
                   type="password" 
                   name="password"
                   class="form-control"
                   placeholder="Enter your password"
                   required>
          </div>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Forgot Password Link -->
        @if(Route::has('password.request'))
          <div class="forgot-container">
            <a class="forgot-link" href="{{ route('password.request') }}">
              Forgot your password?
            </a>
          </div>
        @endif

        <!-- Login Button -->
        <button type="submit" class="btn btn-login" id="loginBtn">
          <span>Sign In</span>
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    
    // Add loading state on form submit
    form.addEventListener('submit', function() {
        loginBtn.classList.add('loading');
        loginBtn.innerHTML = '';
    });
    
    // Add floating label effect
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
    
    // Add ripple effect to button
    loginBtn.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});
</script>

<!-- Font Awesome -->
<link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous" 
      referrerpolicy="no-referrer">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@endsection