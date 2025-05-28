{{-- resources/views/patient/opd_forms/show.blade.php --}}
@extends('layouts.patient')

@section('content')
  <div class="container py-4">
    <h2 class="mb-4">OPD Form – {{ $opd_form->name }}</h2>

    <form action="{{ route('patient.opd_forms.submit', $opd_form) }}" method="POST">
      @csrf

      <a href="{{ route('patient.opd_forms.index') }}"
         class="btn btn-secondary mb-4">← Back to forms</a>

      @foreach($questions as $i => $q)
        <div class="mb-3">
          <label class="form-label">
            {{ $q['label'] }}
            @if(!empty($q['required']))<span class="text-danger">*</span>@endif
          </label>
          <input type="text"
                 name="answers[{{ $i }}]"
                 value="{{ old("answers.$i") }}"
                 @if(!empty($q['required'])) required @endif
                 class="form-control @error("answers.$i") is-invalid @enderror">
          @error("answers.$i")
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      @endforeach

      <button type="submit" class="btn btn-success">Submit Form</button>
    </form>
  </div>
@endsection
