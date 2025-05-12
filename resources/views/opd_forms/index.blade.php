{{-- resources/views/opd_forms/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<style>
    /* ===== OPD Forms Index styles ===== */
    .page-header {
        background:#00b467;
        color:#fff;
        padding:1rem 1.5rem;
        border-radius:.25rem;
        display:flex;justify-content:space-between;align-items:center;
        margin-bottom:1.25rem;
    }
    .page-header h1 { margin:0;font-size:1.9rem;font-weight:700; }

    .sub-header {
        background:#0e4749;
        color:#fff;
        padding:.6rem 1rem;
        border-top-left-radius:.25rem;
        border-top-right-radius:.25rem;
        font-weight:600;
        display:grid;
        grid-template-columns:2fr 140px 1fr 160px;
    }
    .sub-header div {padding-left:.25rem;}

    .form-row {
        display:grid;
        grid-template-columns:2fr 140px 1fr 160px;
        padding:.6rem 1rem;
        align-items:center;
        border-bottom:1px solid #dfe6e9;
    }
    .form-row:nth-child(even){background:#f7f7f7;}

    .btn-view  {background:#28a745;border:none;color:#fff;font-size:.8rem;padding:.25rem .6rem;}
    .btn-edit  {background:#1e90ff;border:none;color:#fff;font-size:.8rem;padding:.25rem .6rem;}
    .btn-delete{background:#dc3545;border:none;color:#fff;font-size:.8rem;padding:.25rem .6rem;}
</style>

<div class="page-header">
    <h1>OPD Forms</h1>
    <img src="{{ asset('images/fabella-logo.png') }}" width="60" alt="Fabella Logo">
</div>

<a href="{{ route('opd_forms.create') }}" class="btn btn-primary mb-3">+ Add Form</a>

<div class="card shadow-sm">
    <div class="sub-header">
        <div>Form Name</div>
        <div>Form No.</div>
        <div>Department</div>
        <div class="text-center">Actions</div>
    </div>

    @foreach($forms as $form)
        <div class="form-row">
            <div>{{ $form->name }}</div>
            <div>{{ $form->form_no }}</div>
            <div>{{ $form->department }}</div>
            <div class="text-center">
                <a href="{{ route('opd_forms.show', $form) }}" class="btn btn-view">View</a>
                <a href="{{ route('opd_forms.edit', $form) }}" class="btn btn-edit">Edit</a>
                <form action="{{ route('opd_forms.destroy', $form) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this form?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-delete">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
