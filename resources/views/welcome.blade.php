
<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FabellaCares Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #155E63; }
        .vh-100 { height: 100vh; }
        .card { border: none; border-radius: 0.75rem; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row vh-100">
        <!-- Image Side -->
        <div class="col-md-7 d-none d-md-block p-0">
            <img src="{{ asset('images/doctor.jpg') }}" alt="Healthcare" class="img-fluid w-100 h-100" style="object-fit: cover;">
        </div>
        <!-- Login Form Side -->
        <div class="col-md-5 d-flex align-items-center justify-content-center">
            <div class="card shadow-lg w-75">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/fabella-logo.png') }}" alt="Fabella Logo" width="80">
                        <h5 class="mt-2">FabellaCares: OPD Healthcare Management System</h5>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-dark">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3 text-end">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
