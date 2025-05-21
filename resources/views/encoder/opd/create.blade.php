@extends('layouts.encoder')

@section('content')
<div class="container col-lg-6">
  <h2 class="mb-4">Submit OPD Form</h2>

  <form action="{{ route('encoder.opd.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label class="form-label">Which Form?</label>
      <select name="form_id" class="form-select" required>
        <option value="">-- select form --</option>
        @foreach($forms as $f)
          <option value="{{ $f->id }}">{{ $f->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Patient</label>
      <select name="patient_id" class="form-select" required>
        <option value="">-- select patient --</option>
        @foreach($patients as $p)
          <option value="{{ $p->id }}">{{ $p->name }}</option>
        @endforeach
      </select>
    </div>

    {{-- Example question/answer inputs; adapt to your form schema --}}
    <div class="mb-3">
      <label class="form-label">Visit Reason</label>
      <input type="text" name="answers[reason]" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Height (cm)</label>
      <input type="number" name="answers[height]" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Weight (kg)</label>
      <input type="number" name="answers[weight]" class="form-control">
    </div>

    <button class="btn btn-primary">Submit</button>
    <a href="{{ route('encoder.opd.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
