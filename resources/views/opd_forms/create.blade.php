{{-- resources/views/opd_forms/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2>Add OPD Form</h2>
  <form action="{{ route('opd_forms.store') }}" method="POST">
    @csrf

    @include('opd_forms._form')

    <button type="submit" class="btn btn-success mt-2">Save</button>
    <a href="{{ route('opd_forms.index') }}" class="btn btn-secondary mt-2">Cancel</a>
  </form>
</div>
@endsection
