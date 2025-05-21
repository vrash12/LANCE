{{-- resources/views/departments/index.blade.php --}}

@extends('layouts.admin')

@section('content')
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet"/>

<style>
  .fc-header {
    background: #00b467;
    color: #fff;
    padding: 1.25rem 2rem;
    border-radius: 0.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
  }
  .fc-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
  }

  #departments-table.table {
    background: #0e4749;
    color: #fff;
  }
  #departments-table thead {
    background: #0e4749;
    color: #fff;
  }
  #departments-table tbody tr:nth-child(even) {
    background: rgba(255,255,255,0.04);
  }
  #departments-table td, #departments-table th {
    vertical-align: middle;
  }

  .btn-secondary { background: #ffffff; color: #000; border: none; }
  .btn-info      { background: #1e7cff; border: none; }
  .btn-danger    { background: #dc3545; border: none; }
</style>

<div class="fc-header">
  <h1>Departments</h1>
  <a href="{{ route('departments.create') }}" class="btn btn-primary">Add Department</a>
</div>

<div class="card shadow-sm">
  <div class="p-3">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="departments-table" class="table table-bordered table-striped mb-0" style="width:100%">
      <thead>
        <tr>
          <th>Short Name</th>
          <th>Full Name</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($departments as $department)
          <tr>
            <td>{{ $department->short_name }}</td>
            <td>{{ $department->name }}</td>
            <td class="text-center">
              <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-info">Edit</a>
              <form action="{{ route('departments.destroy', $department) }}" 
                    method="POST" 
                    class="d-inline" 
                    onsubmit="return confirm('Delete this department?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- DataTables scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(function(){
    $('#departments-table').DataTable({
      pageLength: 10,
      lengthChange: false,
      info: false,
      language: { search: "Search: " }
    });
  });
</script>
@endsection
