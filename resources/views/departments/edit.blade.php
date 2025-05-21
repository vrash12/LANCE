{{-- resources/views/departments/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Edit Department</h2>
  <form action="{{ route('departments.update', $department) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="mb-3">
      <label for="short_name" class="form-label">Short Name</label>
      <input type="text"
             id="short_name"
             name="short_name"
             class="form-control @error('short_name') is-invalid @enderror"
             value="{{ old('short_name', $department->short_name) }}"
             required>
      @error('short_name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="name" class="form-label">Department Name</label>
      <input type="text"
             id="name"
             name="name"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name', $department->name) }}"
             required>
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-info">Save Changes</button>
    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
