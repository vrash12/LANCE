{{-- resources/views/opd_forms/create.blade.php --}}
@extends('layouts.admin')

@section('content')
  <div class="container-fluid">
    <h1 class="mb-4">
      @switch($type)
        @case('high_risk') Add Identification-of-High-Risk Form @break
        @case('follow_up') Add Follow-Up Records Form @break
        @default           Add OPD-OB Form
      @endswitch
    </h1>

    @php
      $partial = match($type) {
        'high_risk' => 'high_risk',
        'follow_up' => 'follow_up',
        default     => 'opdb',
      };
    @endphp

    @include("opd_forms.$partial._form", [
      'opd_form'  => null,
      'postRoute' => route('opd_forms.store'),
      'showButtons' => true,
      'type'      => $type,            {{-- add this! --}}
    ])
  </div>
@endsection
