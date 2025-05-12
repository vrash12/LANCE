{{-- resources/views/users/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<style>
    /* ===== Users page overrides ===== */
    .fc-header {
        background:#00b467;              /* bright green header */
        color:#fff;
        padding:1.25rem 2rem;
        border-radius:0.25rem;
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:1.5rem;
    }
    .fc-header h1 { font-size:2rem; font-weight:700; margin:0; }
    .fc-subheader {
        background:#0e4749;              /* dark teal */
        color:#fff;
        padding:0.75rem 1.25rem;
        border-top-left-radius:0.25rem;
        border-top-right-radius:0.25rem;
        font-weight:600;
        margin-bottom:0;
    }
    .dataTables_wrapper .dataTables_filter {
        color:#fff !important;
        margin-right:1.25rem;
        margin-top:-42px;                /* align with subheader */
    }
    /* table styling to match mockup */
    #users-table.table {
        background:#0e4749;
        color:#fff;
    }
    #users-table.table thead {
        background:#0e4749;
        color:#fff;
    }
    #users-table.table tbody tr td {
        vertical-align:middle;
    }
    #users-table.table tbody tr:nth-child(even) {
        background:rgba(255,255,255,0.04);
    }
    /* button colours */
    .btn-secondary{background:#ffffff;color:#000;border:none;}
    .btn-info{background:#1e7cff;border:none;}
    .btn-danger{background:#dc3545;border:none;}
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
                    <th>Account Type</th>
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
                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-secondary">View</a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info">Update</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this user?');">
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

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(function(){
    $('#users-table').DataTable({
        pageLength:5,
        lengthChange:false,
        info:false,
        language:{
            search:"Search: "
        }
    });
});
</script>
@endsection
