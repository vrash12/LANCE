{{-- resources/views/encoder/opd/opdb/create.blade.php --}}
@extends('layouts.encoder')

@section('content')
<div class="container">
  <h1 class="mb-4">New OB-OPD Form (Window A Assignment)</h1>

  {{-- include the shared OPD-OB form partial, passing in the null model & store route --}}
  @include('opd_forms.opdb._form', [
      'opd_form'    => null,
      'postRoute'   => route('encoder.opd.store'),
      'showButtons' => true,
  ])
</div>
@endsection
