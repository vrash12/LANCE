@extends('layouts.patient')

@section('content')
<div class="container col-lg-8 py-4">
  <h2>{{ $form->name }} ({{ $form->form_no }})</h2>

  @php
    $partial = match($form->form_no) {
      'OPD-F-09' => 'high_risk',
      'OPD-F-08' => 'follow_up',
      default    => 'opdb',
    };
  @endphp

  @includeIf("opd_forms.{$partial}._form", [
    'opd_form'    => $form,
    'postRoute'   => route('opd_forms.submit', $form),
    'showButtons' => true,
  ])
</div>
@endsection
