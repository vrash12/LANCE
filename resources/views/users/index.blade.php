@extends('layouts.admin')

@section('content')
<style>
  .fc-header {
    background:#00b467; color:#fff;
    padding:1.25rem 2rem; border-radius:.25rem;
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:1.5rem;
  }
  .fc-header h1 { margin:0; font-size:2rem; font-weight:700; }

  .fc-subheader {
    background:#0e4749; color:#fff;
    padding:.75rem 1.25rem;
    border-top-left-radius:.25rem;
    border-top-right-radius:.25rem;
    font-weight:600;
    margin-bottom:0;
  }

  /* table styling */
  #users-table.table { background:#0e4749; color:#fff; }
  #users-table.table thead { background:#0e4749; color:#fff; }
  #users-table.table tbody tr:nth-child(even) {
    background:rgba(255,255,255,0.04);
  }

  /* buttons */
  .btn-view    { background:#6c757d; color:#fff; border:none; }
  .btn-info    { background:#1e7cff; color:#fff; border:none; }
  .btn-secondary { background:#ffffff; color:#000; border:none; }
  .btn-danger  { background:#dc3545; color:#fff; border:none; }
</style>

<div class="fc-header">
  <h1>Users</h1>
  <img src="{{ asset('images/fabella-logo.png') }}" alt="Fabella Logo" width="60">
</div>

<div class="card shadow-sm">
  <div class="fc-subheader">List of Accounts</div>
  <div class="p-3">
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New Record</a>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="users-table" class="table table-bordered table-striped mb-0" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
<tbody>
  @foreach($users as $user)
    <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ ucfirst($user->role) }}</td>
      <td class="text-center">
        {{-- Edit --}}
        <a href="{{ route('users.edit', $user->id) }}"
           class="btn btn-sm btn-info">
          <i class="bi bi-pencil-square"></i> Edit
        </a>

        {{-- Delete --}}
        <form action="{{ route('users.destroy', $user->id) }}"
              method="POST" class="d-inline"
              onsubmit="return confirm('Delete this account?');">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">
            <i class="bi bi-trash"></i> Delete
          </button>
        </form>
      </td>
    </tr>
  @endforeach
</tbody>

    </table>
  </div>
</div>

<!-- DataTables -->
<link rel="stylesheet"
      href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script
  src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(function(){
    $('#users-table').DataTable({
      pageLength:5,
      lengthChange:false,
      info:false,
      language:{ search:"Search:" }
    });
  });
</script>
@endsection
