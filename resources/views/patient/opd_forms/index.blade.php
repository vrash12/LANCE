

@extends('layouts.patient')

@section('content')
{{-- resources/views/patient/opd_forms/index.blade.php --}}
  <h2 class="mb-4">Available OPD Forms</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="row g-3">
    @forelse($forms as $f)
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $f->name }}</h5>
            <p class="text-muted mb-1">Form #{{ $f->form_no }}</p>
            <p class="small mb-3">Dept: {{ $f->department }}</p>
            <a href="{{ route('patient.opd_forms.show',$f) }}"
               class="btn btn-success mt-auto">
              Fill Out
            </a>
          </div>
        </div>
      </div>
    @empty
      <p>No OPD forms published yet.</p>
    @endforelse
  </div>
@endsection
