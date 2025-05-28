@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
  <h1 class="h3">Edit Submission #{{ $opd_form->id }} – Follow-Up</h1>
</div>

<form method="POST" action="{{ route('follow-up-opd-forms.update', $opd_form) }}">
  @csrf
  @method('PUT')
  @include('opd_forms.follow_up._form', ['needPut' => true])
</form>
@endsection
