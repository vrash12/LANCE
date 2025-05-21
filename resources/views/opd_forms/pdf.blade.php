<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>OPD Form {{ $opd_form->form_no }}</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    h1 { font-size: 18px; margin-bottom: .5rem; }
    .field { margin-bottom: .75rem; }
    .label { font-weight: bold; }
  </style>
</head>
<body>
  <h1>OPD Form: {{ $opd_form->name }} ({{ $opd_form->form_no }})</h1>
  <p><span class="label">Department:</span> {{ $opd_form->department }}</p>
  <hr>
  {{-- Add here the actual form questions/structure --}}
  <div class="field">
    <p><span class="label">Question 1:</span> ________________________________</p>
  </div>
  <div class="field">
    <p><span class="label">Question 2:</span> ________________________________</p>
  </div>
  {{-- …etc. --}}
</body>
</html>
