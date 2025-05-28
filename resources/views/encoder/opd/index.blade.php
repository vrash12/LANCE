{{-- resources/views/encoder/opd/index.blade.php --}}
@extends('layouts.encoder')

@section('content')
<div class="container">
  <h1 class="mb-4">Patient Profiles (OB)</h1>

  <table class="table table-bordered align-middle">
    <thead>
      <tr>
        <th>Date&nbsp;Recorded</th>
        <th>Patient</th>
        <th>Gravida / Parity</th>
        <th>Prepared By</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
   <tbody>
@foreach ($forms as $form)
  <tr>
    <td>{{ $form->created_at->toDateString() }}</td>
    <td>{{ $form->name }}</td>
    <td>{{ $form->department }}</td>
    <td>—</td>
    <td class="text-center">
      <a href="{{ route('encoder.opd.show',  $form) }}" class="btn btn-sm btn-primary">
        <i class="bi bi-eye"></i>
      </a>
      <a href="{{ route('encoder.opd.edit',  $form) }}" class="btn btn-sm btn-warning">
        <i class="bi bi-pencil"></i>
      </a>
    </td>
  </tr>
@endforeach

</tbody>
  </table>
</div>
@endsection
