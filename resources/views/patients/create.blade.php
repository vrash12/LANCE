{{-- resources/views/patients/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">
    {{ isset($user) ? 'Create Profile for ' . $user->name : 'Add Patient' }}
  </h2>

  <form action="{{ route('patients.store') }}" method="POST">
    @csrf

    @if(isset($user))
      {{-- Linking to an existing User account --}}
      <input type="hidden" name="user_id" value="{{ $user->id }}">

      <div class="mb-3">
        <label class="form-label">Email (username)</label>
        <input type="email"
               class="form-control"
               value="{{ $user->email }}"
               readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}"
               required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    @else
      {{-- New User account + Patient --}}
      <h5 class="mb-3">Login Credentials</h5>

      <div class="mb-3">
        <label class="form-label">Email (username)</label>
        <input type="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}"
               required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3 row">
        <div class="col">
          <label class="form-label">Password</label>
          <input type="password"
                 name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 required>
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col">
          <label class="form-label">Confirm Password</label>
          <input type="password"
                 name="password_confirmation"
                 class="form-control"
                 required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}"
               required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    @endif

    {{-- Patient’s own profile fields --}}
    <h5 class="mt-4 mb-2">Patient Profile</h5>

    <div class="mb-3">
      <label class="form-label">Birth Date</label>
      <input type="date"
             name="birth_date"
             class="form-control @error('birth_date') is-invalid @enderror"
             value="{{ old('birth_date', isset($user) ? optional($user->patient)->birth_date : '') }}">
      @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Contact No.</label>
      <input type="text"
             name="contact_no"
             class="form-control @error('contact_no') is-invalid @enderror"
             value="{{ old('contact_no', isset($user) ? optional($user->patient)->contact_no : '') }}">
      @error('contact_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea name="address"
                rows="2"
                class="form-control @error('address') is-invalid @enderror">{{ old('address', isset($user) ? optional($user->patient)->address : '') }}</textarea>
      @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <button class="btn btn-success">
      {{ isset($user) ? 'Save Profile' : 'Save & Create User' }}
    </button>
    <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
