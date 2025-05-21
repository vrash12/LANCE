{{-- resources/views/users/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="fc-header">
    <h1>Edit User</h1>
    <img src="{{ asset('images/fabella-logo.png') }}" alt="Fabella Logo" width="60">
</div>

<div class="card shadow-sm">
    <div class="fc-subheader">Update Account</div>
    <div class="p-3">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}"
                    required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}"
                    required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Account Type</label>
                <select 
                    name="role" 
                    id="role" 
                    class="form-select @error('role') is-invalid @enderror"
                    required>
                    <option value="admin"  {{ old('role', $user->role) === 'admin'  ? 'selected' : '' }}>Admin</option>
                    <option value="user"   {{ old('role', $user->role) === 'user'   ? 'selected' : '' }}>User</option>
                    <!-- add other roles as needed -->
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-info">Save Changes</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
