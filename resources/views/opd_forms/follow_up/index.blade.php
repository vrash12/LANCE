@extends('layouts.admin')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
  <h1 class="h3">Follow-Up Records (OPD-F-08)</h1>
  <a href="{{ route('follow-up-opd-forms.create') }}"
     class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Add Follow-Up Record
  </a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
  <div class="table-responsive p-3">
    <table id="fu-table" class="table table-bordered align-middle">
      <thead class="table-light text-center">
        <tr>
          <th>Date Created</th>
          <th>Patient</th>
          <th># Follow-Ups</th>
          <th class="text-center" style="width:160px">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($submissions as $sub)
          <tr>
            <td>{{ $sub->created_at->format('Y-m-d') }}</td>
            <td>{{ optional($sub->patient)->name ?? '—' }}</td>
            <td class="text-center">{{ count($sub->answers['followups'] ?? []) }}</td>
            <td class="text-center">
              <a href="{{ route('follow-up-opd-forms.show', $sub) }}"
                 class="btn btn-sm btn-secondary">
                <i class="bi bi-eye"></i>
              </a>
              <a href="{{ route('follow-up-opd-forms.edit', $sub) }}"
                 class="btn btn-sm btn-info">
                <i class="bi bi-pencil-square"></i>
              </a>
              <form action="{{ route('follow-up-opd-forms.destroy', $sub) }}"
                    method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this record?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted">No records yet</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- DataTables optional --}}
@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $('#fu-table').DataTable({ pageLength:10, lengthChange:false });
</script>
@endpush
@endsection
