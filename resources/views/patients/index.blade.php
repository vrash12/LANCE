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
    <h1>OB OPD Patients</h1>
    <div>
      <!-- you could remove “Add Patient” if patients now come only from submissions -->
    </div>
  </div>

  <table id="patients-table" class="table table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Name</th>

        <th class="text-center" style="width:260px;">Action</th>
      </tr>
    </thead>
    <tbody>
@foreach($patients as $patient)
  @continue(!$patient)   {{-- skip if null --}}

  <tr>
      <td>{{ $patient->name }}</td>
  
    <td class="text-center align-middle">
      @if($patient->user)
        <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-view">View</a>
        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-info">Edit</a>
        <form action="{{ route('patients.destroy', $patient) }}"
              method="POST" class="d-inline" onsubmit="return confirm('Delete this patient?');">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      @else
        <span class="text-muted">no user assigned</span>
      @endif
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
