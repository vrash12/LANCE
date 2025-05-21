<!DOCTYPE html>
<html><head>
  <style>
    body{font-family:sans-serif;font-size:12px}
    table{width:100%;border-collapse:collapse;margin-top:1rem}
    th,td{border:1px solid #ccc;padding:.35rem;text-align:left}
    th{background:#f5f5f5}
  </style>
</head>
<body>
  <h2>Patient Trend Analysis ({{ $from }} → {{ $to }})</h2>
  <table>
    <thead><tr><th>Metric</th><th>Value</th></tr></thead>
    <tbody>
      @foreach($trend as $metric => $value)
        <tr>
          <td>{{ ucwords(str_replace('_',' ',$metric)) }}</td>
          <td>{{ $value }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body></html>
