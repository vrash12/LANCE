{{-- resources/views/opd_forms/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container col-lg-6">
  <h2>Edit OPD Form</h2>
  <form action="{{ route('opd_forms.update', $opd_form) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- this must match the partial’s view name --}}
    @include('opd_forms._form')

    <button type="submit" class="btn btn-info mt-2">Update</button>
    <a href="{{ route('opd_forms.index') }}" class="btn btn-secondary mt-2">Cancel</a>
  </form>
</div>
@endsection
