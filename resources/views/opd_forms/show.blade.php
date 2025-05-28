@extends('layouts.admin')

@section('content')
<div class="container col-lg-8">
  <div class="page-header mb-3"
       style="background:#00b467;color:#fff;
              padding:1rem 1.5rem;border-radius:.25rem;
              display:flex;justify-content:space-between;
              align-items:center;">
    <h2 class="m-0">OPD Form – {{ $opd_form->name }}</h2>
    <img src="{{ asset('images/fabella-logo.png') }}" width="60" alt="Fabella Logo">
  </div>

  {{-- Form metadata --}}
  <table class="table mb-4">
    <tr><th>Form No.</th>     <td>{{ $opd_form->form_no }}</td></tr>
    <tr><th>Department</th>   <td>{{ $opd_form->department }}</td></tr>
    <tr><th>Created</th>      <td>{{ $opd_form->created_at->format('Y-m-d H:i') }}</td></tr>
  </table>

  {{-- Admin actions --}}
  <div class="d-flex gap-2 mb-5">
    <a href="{{ route('opd_forms.edit', $opd_form) }}" class="btn btn-info">
      <i class="bi bi-pencil-fill"></i> Edit Form
    </a>
    <a href="{{ route('opd_forms.export.pdf', $opd_form) }}" class="btn btn-outline-danger">
      <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
    </a>
    <a href="{{ route('opd_forms.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left-circle"></i> Back to List
    </a>
  </div>

  {{-- Submitted Records --}}
  @if($opd_form->submissions->isEmpty())
    <p class="text-muted fst-italic">No submissions yet.</p>
  @else
    <h4 class="mb-3">Submitted Records ({{ $opd_form->submissions->count() }})</h4>
    <div class="table-responsive mb-5">
      <table class="table table-sm table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Submitted By</th>
            <th>Date/Time</th>
            <th class="text-center">View</th>
          </tr>
        </thead>
        <tbody>
          @foreach($opd_form->submissions as $idx => $sub)
            <tr>
              <td>{{ $idx + 1 }}</td>
              <td>{{ $sub->user->name ?? '—' }}</td>
              <td>{{ $sub->created_at->format('Y-m-d H:i') }}</td>
              <td class="text-center">
                <a href="{{ route('opd_submissions.show', $sub) }}"
                   class="btn btn-sm btn-outline-primary">
                  View
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  {{-- Patient‐facing submission form --}}
  <form action="{{ route('patient.opd_forms.submit', $opd_form) }}" method="POST">
    @csrf
    <input type="hidden" name="form_id" value="{{ $opd_form->id }}">

    @forelse($opd_form->fields as $i => $q)
      <div class="mb-3">
        <label class="form-label">
          {{ $q['label'] }}
          @if(!empty($q['required'])) <span class="text-danger">*</span>@endif
        </label>

        @switch($q['type'] ?? 'text')
          @case('textarea')
            <textarea
              name="answers[{{ $i }}]"
              class="form-control @error('answers.'.$i) is-invalid @enderror"
              @if(!empty($q['required'])) required @endif
            >{{ old('answers.'.$i) }}</textarea>
            @break

          @case('date')
            <input type="date"
                   name="answers[{{ $i }}]"
                   value="{{ old('answers.'.$i) }}"
                   class="form-control @error('answers.'.$i) is-invalid @enderror"
                   @if(!empty($q['required'])) required @endif
            >
            @break

          @case('number')
            <input type="number"
                   name="answers[{{ $i }}]"
                   value="{{ old('answers.'.$i) }}"
                   class="form-control @error('answers.'.$i) is-invalid @enderror"
                   @if(!empty($q['required'])) required @endif
            >
            @break

          @default
            <input type="text"
                   name="answers[{{ $i }}]"
                   value="{{ old('answers.'.$i) }}"
                   class="form-control @error('answers.'.$i) is-invalid @enderror"
                   @if(!empty($q['required'])) required @endif
            >
        @endswitch

        @error('answers.'.$i)
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    @empty
      <p class="text-muted">No questions have been defined for this form.</p>
    @endforelse

    <div class="mt-4">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-send-fill"></i> Submit Responses
      </button>
      <a href="{{ route('opd_forms.index') }}" class="btn btn-secondary ms-2">
        Cancel
      </a>
    </div>
  </form>
</div>
@endsection
