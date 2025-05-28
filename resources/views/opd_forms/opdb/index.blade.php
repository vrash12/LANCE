{{-- resources/views/opd_forms/opdb/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container">
  <h1 class="mb-4">OB OPD Submissions (Form OPD-F-07)</h1>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Record No.</th>
        <th>Patient</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($submissions as $sub)
        <tr>
          <td>{{ data_get($sub->answers, 'date') }}</td>
          <td>{{ data_get($sub->answers, 'time') }}</td>
          <td>{{ data_get($sub->answers, 'record_no') }}</td>
          <td>
            {{ data_get($sub->answers, 'last_name') }}
            {{ data_get($sub->answers, 'given_name') }}
          </td>
          <td class="text-center">
            <a href="{{ route('ob-opd-forms.show', $sub) }}" class="btn btn-sm btn-primary">
              View
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">No submissions yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
