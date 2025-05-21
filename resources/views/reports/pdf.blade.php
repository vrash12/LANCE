<!DOCTYPE html>
<html>
<head>
  <style>
    body{font-family:sans-serif;font-size:12px}
    h1{text-align:center;margin:0 0 1rem}
    table{width:100%;border-collapse:collapse}
    th,td{border:1px solid #ccc;padding:.35rem;text-align:left}
    th{background:#f5f5f5}
  </style>
</head>
<body>
  <h1>Daily Patient Visits ({{ $from }} – {{ $to }})</h1>
  <table>
    <thead><tr><th>Date</th><th>Total</th></tr></thead>
    <tbody>
      @foreach($visits as $v)
        <tr><td>{{ $v->day }}</td><td>{{ $v->total }}</td></tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
