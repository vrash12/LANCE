@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
  <h1 class="h3">New Follow-Up Record (OPD-F-08)</h1>
</div>

<form method="POST" action="{{ route('follow-up-opd-forms.store') }}">
  @csrf
  @include('opd_forms.follow_up._form', ['needPut' => false])
</form>
@endsection
