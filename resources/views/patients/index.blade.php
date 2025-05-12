{{-- resources/views/patients/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<style>
    /* ==== Patient Record page styles ==== */
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

    /* DataTable tweaks */
    #patients-table.table thead {
        background:#e9ecef;
    }
    #patients-table.table tbody tr:nth-child(even) {
        background:#f7f7f7;
    }
    #patients-table.table tbody tr td {
        vertical-align:middle;
    }
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label { font-weight:600; }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding:.25rem .6rem;font-size:.85rem;
    }

    /* View button */
    .btn-view {
        background:#1e90ff;border:none;color:#fff;font-size:.85rem;display:flex;align-items:center;gap:.25rem;
    }
</style>

<div class="page-header">
    <h1>Patient Record</h1>
    <img src="{{ asset('images/fabella-logo.png') }}" width="60" alt="Fabella Logo">
</div>

<table id="patients-table" class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th class="text-center" style="width:120px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patients as $patient)
        <tr>
            <td>{{ $patient->name }}</td>
            <td class="text-center">
                <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-view">
                    <i class="bi bi-file-earmark-text"></i> View
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- DataTables -->
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
