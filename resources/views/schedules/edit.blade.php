@extends('layouts.admin')


@section('content')
<div class="container col-lg-6">
  <h2>Edit Schedule</h2>
  <form action="{{ route('schedules.update',$schedule) }}" method="POST">
    @csrf @method('PUT')
    @include('schedules._form')
    <button class="btn btn-info mt-3">Update</button>
    <a href="{{ route('schedules.index') }}" class="btn btn-secondary mt-3">Cancel</a>
  </form>
</div>
@endsection
