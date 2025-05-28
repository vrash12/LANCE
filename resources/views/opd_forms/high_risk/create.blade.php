{{-- resources/views/opd_forms/high_risk/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="h3">Identification of High-Risk (OPD-F-09)</h1>
</div>

@include('opd_forms.high_risk._form', [
    'opd_form'    => $opd_form,    // will be null on create
    'postRoute'   => $postRoute,   // should be route('high-risk-opd-forms.store')
    'showButtons' => $showButtons, // true
    'needPut'     => false        // create, so no PUT
])
@endsection
