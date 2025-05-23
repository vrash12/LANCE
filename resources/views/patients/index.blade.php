{{-- resources/views/patients/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<style>
  /* ==== Page header ==== */
  .page-header {
    background:#00b467;
    color:#fff;
    padding:1rem 1.5rem;
    border-radius:.25rem;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:1rem;
  }
  .page-header h1 { margin:0; font-size:1.9rem; font-weight:700; }

  /* ==== “Add Patient” button ==== */
  .btn-add {
    background:#28a745; border:none; color:#fff;
    font-size:.9rem; padding:.5rem 1rem; border-radius:.25rem;
  }
  .btn-add:hover { background:#218838; }

  /* ==== Action buttons ==== */
  .btn-view   { background:#6c757d; color:#fff; border:none; }
  .btn-info   { background:#1e7cff; color:#fff; border:none; }
  .btn-danger { background:#dc3545; color:#fff; border:none; }
  .btn-sm     { margin-right:.3rem; }
</style>

<div class="page-header">
  <h1>Patient Records</h1>
  <div>
    <a href="{{ route('patients.create') }}" class="btn btn-add">
      <i class="bi bi-person-plus-fill"></i> Add Patient
    </a>
    <img src="{{ asset('images/fabella-logo.png') }}" width="60" alt="Fabella Logo">
  </div>
</div>

<table id="patients-table" class="table table-bordered" style="width:100%">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th class="text-center" style="width:260px;">Action</th>
    </tr>
  </thead>
<tbody>
  @foreach($users as $user)
    <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>

      <td class="text-center align-middle">
        {{-- View --}}
        <a href="{{ route('patients.show', $user->patient) }}"
           class="btn btn-sm btn-view">
          <i class="bi bi-file-earmark-text"></i> View
        </a>

        {{-- Edit --}}
        <a href="{{ route('patients.edit', $user->patient) }}"
           class="btn btn-sm btn-info">
          <i class="bi bi-pencil-square"></i> Edit
        </a>

        {{-- Delete --}}
        <form action="{{ route('patients.destroy', $user->patient) }}"
              method="POST" class="d-inline"
              onsubmit="return confirm('Delete this patient?');">
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

<!-- DataTables (optional) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(function(){
    $('#patients-table').DataTable({
      pageLength:7,
      lengthMenu:[7,10,25,50],
      lengthChange:true,
      searching:true,
      info:true,
      language:{
        lengthMenu:"Show _MENU_ entries",
        search:"Search:"
      }
    });
  });
</script>
@endsection
