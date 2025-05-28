{{-- resources/views/encoder/opd/opdb/create.blade.php --}}
@extends('layouts.encoder')

@section('content')
<div class="container">
  <h1 class="mb-4">
      Fill {{ strtoupper($type) }} Form &middot; {{ $patient->name }}
  </h1>

  <form method="POST"
        action="{{ route('encoder.patient_profiles.store', $patient) }}">
    @csrf

    @php
        // figure out which partial folder to load
        $partial = match($type) {
            'follow_up' => 'encoder.opd.follow_up._form',
            'high_risk' => 'encoder.opd.high_risk._form',
            default     => 'encoder.opd.opdb._form',
        };
    @endphp

    @include($partial, [
        'forPatient' => true,   // hide template-only metadata
        'patient'    => $patient,
        'opd_form'   => null,   // not editing a template
    ])

    <button class="btn btn-primary mt-3">Save Profile</button>
  </form>
</div>
@endsection
