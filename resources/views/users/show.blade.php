{{-- resources/views/users/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h2 class="mb-0">User Details</h2>
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Account Type:</strong> {{ ucfirst($user->role) }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-info">Edit</a>
    </div>
</div>
@endsection
