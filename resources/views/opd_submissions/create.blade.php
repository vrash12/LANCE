@extends('layouts.patient')

@section('content')
<div class="container col-md-6">
  <h2 class="mb-4">Fill: {{ $opd_form->name }}</h2>

  <form method="POST" action="{{ route('opd.submit.store',$opd_form) }}">
    @csrf

    <div class="mb-3">
      <label class="form-label">Your Responses</label>
      <textarea name="responses"
                class="form-control @error('responses') is-invalid @enderror"
                rows="6"
                required>{{ old('responses') }}</textarea>
      @error('responses')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-success">Submit Form</button>
    <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
