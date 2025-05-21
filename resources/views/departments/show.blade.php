{{-- resources/views/departments/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="fc-header">
  <h1>Department Details</h1>
  <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back to List</a>
</div>

<div class="card shadow-sm p-3">
  <p><strong>Short Name:</strong> {{ $department->short_name }}</p>
  <p><strong>Full Name:</strong> {{ $department->name }}</p>
</div>
@endsection
