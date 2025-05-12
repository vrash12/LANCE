{{-- resources/views/home.blade.php --}}
@extends('layouts.admin')

@section('content')
  <div class="container">
    <h1 class="mb-4">Dashboard</h1>

    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif

    <p>
      You are logged in as 
      <strong>{{ auth()->user()->name }}</strong> 
      (<em>{{ ucfirst(auth()->user()->role) }}</em>).
    </p>
  </div>
@endsection
