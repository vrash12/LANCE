@extends('layouts.admin')

@section('content')
<div class="container">
  <h1 class="mb-4">Reports</h1>

  {{-- 7.4 Filter --}}
  <form class="row g-2 mb-3" method="GET" action="{{ route('reports.index') }}">
     <div class="col-auto">
       <label class="form-label mb-0">From</label>
       <input type="date" name="from" value="{{ $dateFrom }}" class="form-control">
     </div>
     <div class="col-auto">
       <label class="form-label mb-0">To</label>
       <input type="date" name="to" value="{{ $dateTo }}" class="form-control">
     </div>
     <div class="col-auto align-self-end">
       <button class="btn btn-primary">Apply</button>
     </div>
  </form>

  {{-- 7.2 View Report --}}
  <div class="card shadow-sm">
    <div class="card-header bg-white"><strong>Daily Patient Visits</strong></div>
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead><tr><th>Date</th><th>Total</th></tr></thead>
        <tbody>
          @foreach($visits as $v)
            <tr><td>{{ $v->day }}</td><td>{{ $v->total }}</td></tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between">
      <div>
        <a href="{{ route('reports.generate') }}" 
           class="btn btn-sm btn-secondary">Generate Report</a>
      </div>
      <div>
        <a href="{{ route('reports.excel',['from'=>$dateFrom,'to'=>$dateTo]) }}" 
           class="btn btn-sm btn-success me-2">
           <i class="bi bi-file-earmark-spreadsheet"></i> Excel
        </a>
        <a href="{{ route('reports.pdf',['from'=>$dateFrom,'to'=>$dateTo]) }}" 
           class="btn btn-sm btn-danger">
           <i class="bi bi-file-earmark-pdf"></i> PDF
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
