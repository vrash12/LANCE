@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <h1 class="mb-4">Edit {{ $opd_form->name }}</h1>

  {{-- load the OPD-OB partial and tell it the update route + verb --}}
 @include('opd_forms.opdb._form', [
    'postRoute'   => route('ob-opd-forms.update', $submission), // PUT/PATCH
    'opd_form'    => $submission,   // or however you repopulate
    'needPut'     => true,
    'showButtons' => true
])

</div>
@endsection
