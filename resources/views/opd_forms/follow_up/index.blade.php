@extends('layouts.admin')

@section('content')
<div class="page-header mb-4 d-flex justify-content-between align-items-center">
  <h1 class="h3">Follow‑Up Records (OPD‑F‑08)</h1>
  <a href="{{ route('follow-up-opd-forms.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> New Follow‑Up
  </a>
</div>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>#</th>
          <th>Patient</th>
          <th>Created At</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($submissions as $sub)
          <tr>
            <td>{{ $sub->id }}</td>
            <td>{{ optional($sub->patient)->name ?? '— unassigned' }}</td>
            <td>{{ $sub->created_at->format('Y-m-d H:i') }}</td>
            <td class="text-end">
              <a href="{{ route('follow-up-opd-forms.show', $sub) }}" class="btn btn-sm btn-secondary">View</a>
              <a href="{{ route('follow-up-opd-forms.edit', $sub) }}" class="btn btn-sm btn-info">Edit</a>
              <form action="{{ route('follow-up-opd-forms.destroy', $sub) }}"
                    method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this submission?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center py-4">No follow‑up records yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>