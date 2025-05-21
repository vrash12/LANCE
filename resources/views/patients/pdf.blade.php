<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Patient Record</title>
  <style>
    body { font-family: sans-serif; }
    h1 { text-align: center; }
    table { width:100%; border-collapse:collapse; margin-top:1rem;}
    td,th { border:1px solid #ccc; padding: .5rem; }
    .no-border td { border:none; }
  </style>
</head>
<body>
  <h1>Patient Record</h1>
  <table class="no-border">
    <tr><td><strong>Name</strong></td><td>{{ $patient->name }}</td></tr>
    <tr><td><strong>Birth Date</strong></td><td>{{ $patient->birth_date }}</td></tr>
    <tr><td><strong>Contact</strong></td><td>{{ $patient->contact_no }}</td></tr>
    <tr><td><strong>Address</strong></td><td>{{ $patient->address }}</td></tr>
  </table>

  <h2>Visit History</h2>
  <table>
    <thead>
      <tr><th>Date</th><th>Notes</th></tr>
    </thead>
    <tbody>
      @foreach($patient->visits as $v)
        <tr>
          <td>{{ $v->visited_at->format('Y-m-d H:i') }}</td>
          <td>{{ $v->notes }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
