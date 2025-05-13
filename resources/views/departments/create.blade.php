@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Add Department</h2>

  <form action="{{ route('departments.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Department Name</label>
      <input type="text"
             name="name"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name') }}"
             required>
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('queue.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
