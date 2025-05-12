@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2>Add Schedule</h2>
  <form action="{{ route('schedules.store') }}" method="POST">
    @csrf
    @include('schedules._form')
    <button class="btn btn-success mt-3">Save</button>
    <a href="{{ route('schedules.index') }}" class="btn btn-secondary mt-3">Cancel</a>
  </form>
</div>
@endsection
