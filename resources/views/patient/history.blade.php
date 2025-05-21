@extends('layouts.patient')

@section('content')
<div class="container py-4">
  <h2 class="mb-4">My Visit History</h2>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Date</th>
        <th>Notes</th>
      </tr>
    </thead>
    <tbody>
      @forelse(auth()->user()->patient->visits as $visit)
        <tr>
          <td>{{ \Carbon\Carbon::parse($visit->visited_at)->format('Y-m-d H:i') }}</td>
          <td>{{ $visit->notes ?? '—' }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="2" class="text-center">No visits recorded yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
