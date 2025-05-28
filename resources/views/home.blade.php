@extends('layouts.admin')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row g-4 mb-5">
  <!-- KPI: Today's Visits -->
  <div class="col-md-4">
    <div class="card text-white bg-primary h-100">
      <div class="card-body">
        <h6 class="card-title">Today's Visits</h6>
        <h2>{{ $todayVisits }}</h2>
      </div>
    </div>
  </div>
  <!-- KPI: Avg Wait Time -->
  <div class="col-md-4">
    <div class="card text-white bg-success h-100">
      <div class="card-body">
        <h6 class="card-title">Avg. Wait Time (min)</h6>
        <h2>{{ $avgWait }}</h2>
      </div>
    </div>
  </div>
  <!-- KPI: Current Queue Length -->
  <div class="col-md-4">
    <div class="card text-white bg-warning h-100">
      <div class="card-body">
        <h6 class="card-title">Current Queue Length</h6>
        <h2>{{ $currentQueue }}</h2>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4 col-md-6 mx-auto">
    <div class="card p-4">
      <h5 class="card-title mb-3">Visits by Department (Today)</h5>
      {{-- fixed-height wrapper --}}
      <div style="position: relative; height: 300px; width: 100%;">
        <canvas id="deptChart"></canvas>
      </div>
    </div>
  </div>
</div>

<script>
(() => {
  const stats = @json($deptStats);
  const labels = stats.map(s => s.name);
  const data   = stats.map(s => s.count);
  const ids    = stats.map(s => s.id);

  new Chart(document.getElementById('deptChart'), {
    type: 'doughnut',
    data: {
      labels,
      datasets: [{
        data,
        backgroundColor: [
          'rgba(54,162,235,0.6)',
          'rgba(255,99,132,0.6)',
          'rgba(255,206,86,0.6)',
          'rgba(75,192,192,0.6)',
          'rgba(153,102,255,0.6)',
          'rgba(255,159,64,0.6)',
        ]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,      // allow fixed-height container
      cutout: '60%',                   // bigger hole, thinner ring
      plugins: {
        legend: { position: 'bottom' },
        tooltip: { enabled: true }
      },
      onClick: (evt, items) => {
        if (!items.length) return;
        const idx = items[0].index;
        window.location.href = `/queue/${ids[idx]}`;
      }
    }
  });
})();
</script>
@endsection
