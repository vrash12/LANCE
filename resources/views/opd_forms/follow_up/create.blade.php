@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
  <h1 class="h3">New Follow-Up Record (OPD-F-08)</h1>
</div>

<form method="POST" action="{{ route('follow-up-opd-forms.store') }}">
  @csrf

  @include('opd_forms.follow_up._form')

  <div class="text-end mt-4">
    <a href="{{ route('follow-up-opd-forms.index') }}" class="btn btn-secondary">
      Cancel
    </a>
    <button type="submit" class="btn btn-primary">
      Save Record
    </button>
  </div>
</form>
@endsection
