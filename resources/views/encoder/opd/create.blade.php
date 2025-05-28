{{-- resources/views/encoder/opd/create.blade.php --}}
@extends('layouts.encoder')

@section('content')
<div class="container">
  <h1 class="mb-4">
      OB Form &middot; Fill for {{ $patient->name }}
  </h1>

  {{-- POST answers to patient_profiles --}}
  <form method="POST"
        action="{{ route('encoder.patient_profiles.store', $patient) }}">
    @csrf

    @include('encoder.opd._form', [
        'opd_form'   => null,     // not editing template
        'forPatient' => true,     // tells the partial to hide template fields
        'patient'    => $patient,
    ])
  </form>
</div>
@endsection
