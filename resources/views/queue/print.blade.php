<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Queue Ticket – {{ $token->code }}</title>
  <style>
    body { font-family: Arial, sans-serif; margin:0; padding:0; }
    .ticket {
      width: 280px;   /* 80 mm thermal width ≈ 280 px */
      padding: 12px;
      text-align: center;
    }
    h1 { margin:8px 0 4px; font-size: 54px; }
    small { display:block; margin-bottom:4px; font-size:12px; }
    hr { border:none; border-top:1px dashed #000; margin:12px 0; }
  </style>
</head>
<body onload="window.print()">
  <div class="ticket">
    <small>Fabella Cares Hospital</small>
    <h1>{{ $token->code }}</h1>
    <div>OB&nbsp;Department</div>
    <hr>
    <small>Issued: {{ $token->created_at->format('d M Y H:i') }}</small>
    <small>Patient: {{ optional($token->patient)->name }}</small>
  </div>
</body>
</html>
