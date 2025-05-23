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
  <div class="row gy-4 mt-5">

    {{-- Age Range Bar Chart --}}
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header">Age Range of Patients</div>
        <div class="card-body">
          <canvas id="ageChart" style="height:300px"></canvas>
        </div>
      </div>
    </div>

    {{-- Gender Pie Chart --}}
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header">Gender Distribution</div>
        <div class="card-body">
          <canvas id="genderChart" style="height:300px"></canvas>
        </div>
      </div>
    </div>

    {{-- Blood Type Pie Chart --}}
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header">Blood Type Breakdown</div>
        <div class="card-body">
          <canvas id="bloodChart" style="height:300px"></canvas>
        </div>
      </div>
    </div>

    {{-- Delivery Type Pie Chart --}}
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header">Delivery Type Breakdown</div>
        <div class="card-body">
          <canvas id="deliveryChart" style="height:300px"></canvas>
        </div>
      </div>
    </div>

  </div>

</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
  const extract = (coll, labelKey, dataKey) => ({
    labels: coll.map(r => r[labelKey]),
    data:   coll.map(r => r[dataKey])
  });

  // 1) Age Range → Bar
  (() => {
    const stats = @json($ageStats);
    const { labels, data } = extract(stats, 'age_range','total');
    new Chart(document.getElementById('ageChart'), {
      type: 'bar',
      data: { labels, datasets:[{ label:'Patients', data }] },
      options: {
        scales: { y: { beginAtZero:true, ticks:{precision:0} } }
      }
    });
  })();

  // 2) Gender → Pie
  (() => {
    const stats = @json($genderStats);
    const { labels, data } = extract(stats, 'sex','total');
    new Chart(document.getElementById('genderChart'), {
      type: 'pie',
      data: { labels, datasets:[{ data }] }
    });
  })();

  // 3) Blood Type → Pie
  (() => {
    const stats = @json($bloodStats);
    const { labels, data } = extract(stats, 'blood_type','total');
    new Chart(document.getElementById('bloodChart'), {
      type: 'pie',
      data: { labels, datasets:[{ data }] }
    });
  })();

  // 4) Delivery Type → Pie
  (() => {
    const stats = @json($deliveryStats);
    const { labels, data } = extract(stats, 'delivery_type','total');
    new Chart(document.getElementById('deliveryChart'), {
      type: 'pie',
      data: { labels, datasets:[{ data }] }
    });
  })();
</script>
@endpush
