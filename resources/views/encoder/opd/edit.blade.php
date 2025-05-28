{{-- resources/views/encoder/opd/edit.blade.php --}}
@extends('layouts.encoder')

@section('content')
<div class="container">
  <h1 class="mb-4">Edit OB Profile – {{ $patient->name }}</h1>

  <form method="POST"
        action="{{ route('encoder.patient_profiles.update', [$patient, $profile]) }}">
    @csrf @method('PUT')

    @include('encoder.opd._form', [
        'opd_form'   => null,
        'forPatient' => true,
        'patient'    => $patient,
        // use $profile as “existing values” for helper f()
        'opd_form'   => $profile,
    ])
  </form>
</div>
@endsection
