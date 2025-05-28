{{-- resources/views/encoder/opd/show.blade.php --}}
@extends('layouts.encoder')

@section('content')
<div class="container">
  <h1 class="mb-3">OB Profile for {{ $profile->patient->name }}</h1>

  <p><strong>Date recorded:</strong> {{ $profile->date_recorded ?? $profile->created_at->toDateString() }}</p>

  {{-- Just dump JSON for now; format nicely later --}}
  <pre>{{ json_encode($profile->only([
        'sex','religion','gravida','parity_t','lmp','edc','diagnosis'
      ]), JSON_PRETTY_PRINT) }}</pre>

  <a href="{{ route('encoder.opd.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
