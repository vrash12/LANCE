@extends('layouts.admin')

@section('content')
<div class="container">
  <h1 class="mb-4">Patient Trend Analysis</h1>

  {{-- Filter --}}
  <form class="row g-2 mb-3" method="GET" action="{{ route('trends.index') }}">
     <div class="col-auto">
       <label class="form-label mb-0">From</label>
       <input type="date" name="from" value="{{ $from }}" class="form-control">
     </div>
     <div class="col-auto">
       <label class="form-label mb-0">To</label>
       <input type="date" name="to" value="{{ $to }}" class="form-control">
     </div>
     <div class="col-auto align-self-end">
       <button class="btn btn-primary">Apply</button>
     </div>
     <div class="col-auto align-self-end">
       <button formaction="{{ route('trends.request') }}" formmethod="POST"
               class="btn btn-secondary">
         @csrf Generate New
       </button>
     </div>
  </form>

  @if(!$trend)
    <div class="alert alert-warning">No trend data for selected range.</div>
  @else
    {{-- Display key metrics --}}
    <div class="row">
      @foreach($trend as $metric => $value)
        <div class="col-md-3 mb-3">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h6 class="card-subtitle text-muted">{{ ucwords(str_replace('_',' ',$metric)) }}</h6>
              <h3 class="mb-0">{{ $value }}</h3>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

  <div class="mt-3">
    <a href="{{ route('trends.excel',['from'=>$from,'to'=>$to]) }}" class="btn btn-success me-2">
      <i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel
    </a>
    <a href="{{ route('trends.pdf',['from'=>$from,'to'=>$to]) }}" class="btn btn-danger">
      <i class="bi bi-file-earmark-pdf-fill"></i> PDF
    </a>
  </div>
</div>
@endsection
