<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Queue – {{ $department->short_name }}</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
 <style>
    :root {
      --header:#00b467;
      --bg:#0d4640;
      --line:#ffffff;
      --text:#ffffff;
    }
    body {
      margin:0;
      background:var(--bg);
      color:var(--text);
      font-family:Arial,Helvetica,sans-serif;
    }
    .topbar {
      background:var(--header);
      padding:.35rem .75rem;
      display:flex;
      align-items:center;
      justify-content:space-between;
      font-size:3rem;
      font-weight:700;
    }
    .topbar img { height:60px; }
    .layout {
      display:grid;
      grid-template-columns:220px 1fr;
      grid-template-rows:auto 1fr;
      height:calc(100vh - 84px);
    }
    .queue-list {
      display:grid;
      grid-template-rows:repeat(5,1fr);
      border-right:8px solid var(--line);
    }
    .queue-slot {
      display:grid;
      grid-template-columns:60px 1fr;
      align-items:center;
      font-size:2.8rem;
      font-weight:700;
      border-bottom:8px solid var(--line);
    }
    .queue-slot:last-child { border-bottom:none; }
    .queue-slot div { text-align:center; }
    .right-pane {
      display:grid;
      grid-template-rows:92px 60px 1fr;
    }
    .dept {
      display:flex;
      align-items:center;
      justify-content:center;
      font-size:4rem;
      font-weight:700;
      border-bottom:8px solid var(--line);
    }
    .timestamp {
      display:flex;
      align-items:center;
      justify-content:center;
      font-size:1.6rem;
      font-weight:600;
      border-bottom:8px solid var(--line);
    }
    .now-serving {
      display:flex;
      align-items:center;
      justify-content:center;
    }
    .now-serving span {
      font-size:11rem;
      font-weight:700;
      letter-spacing:3px;
    }
  </style>
</head>
<body>

  {{-- HEADER --}}
   <div class="topbar d-flex justify-content-between align-items-center">
    <div>
      <a href="{{ auth()->user()->role==='patient'
                    ? route('patient.dashboard')
                    : route('queue.index') }}"
         class="btn btn-light btn-sm me-3">
        ← Back
      </a>
      <span>Queueing</span>
    </div>
    <img src="{{ asset('images/fabella-logo.png') }}" alt="Logo">
  </div>

  {{-- PATIENT TOKEN BANNERS --}}
  @if($patientToken)
    <div
      id="tokenBanner"
      class="alert alert-info text-center m-0 p-2"
    >
      Your token: <strong>{{ $patientToken }}</strong>
    </div>

    <div
      id="positionBanner"
      class="alert alert-secondary text-center m-0 p-2"
    >
      You are number <strong>#{{ $position }}</strong> in the queue.
    </div>

    <div
      id="turnBanner"
      class="alert alert-success text-center m-0 p-2"
      style="display: {{ $patientToken=== $currentServing ? 'block':'none' }}"
    >
      🎉 It’s your turn now!
    </div>
  @endif

  {{-- MAIN GRID --}}
  <div class="layout">
    <div class="queue-list">
      @foreach($tokens as $idx => $t)
        <div class="queue-slot">
          <div>{{ $idx + 1 }}</div>
          <div>{{ $t->code }}</div>
        </div>
      @endforeach
      @for($i = $tokens->count(); $i < 5; $i++)
        <div class="queue-slot">
          <div>{{ $i + 1 }}</div>
          <div>&nbsp;</div>
        </div>
      @endfor
    </div>

    <div class="right-pane">
      <div class="dept">{{ $department->short_name }}</div>
      <div class="timestamp" id="tsLine">
        {{ $currentTime }} | Now Serving
      </div>
      <div class="now-serving">
        <span id="nowCode">{{ $currentServing }}</span>
      </div>
    </div>
  </div>

  {{-- LIVE POLL --}}
  <script>
    // expose patientToken to JS (or null)
    window.patientToken = @json($patientToken);

    const deptUrl = "{{ route('queue.status', $department) }}";

    async function refresh() {
      const resp     = await fetch(deptUrl);
      const data     = await resp.json();
      const pending5 = data.pending;      // first 5
      const allCodes = data.all_codes;    // full queue

      // 1) rebuild the slot grid
      const list = document.querySelector('.queue-list');
      list.innerHTML = '';
      for (let i = 0; i < 5; i++) {
        const code = pending5[i]?.code ?? '&nbsp;';
        list.insertAdjacentHTML('beforeend', `
          <div class="queue-slot">
            <div>${i+1}</div><div>${code}</div>
          </div>
        `);
      }

      // 2) update “Now Serving”
      const now = allCodes[0] ?? '—';
      document.getElementById('nowCode').innerText = now;

      // 3) update timestamp
      document.getElementById('tsLine').firstChild.nodeValue =
        new Date().toLocaleString(undefined, {
          day:    '2-digit',
          month:  'long',
          year:   'numeric',
          hour:   '2-digit',
          minute: '2-digit',
          second: '2-digit'
        }) + ' | Now Serving';

      // 4) if patientToken is set, recompute their position & turn-banner
      if (window.patientToken) {
        const pos    = allCodes.indexOf(window.patientToken);
        const posDiv = document.getElementById('positionBanner');
        if (pos >= 0) {
          posDiv.innerHTML = `You are number <strong>#${pos+1}</strong> in the queue.`;
          posDiv.style.display = 'block';
        } else {
          posDiv.style.display = 'none';
        }

        const turnDiv = document.getElementById('turnBanner');
        if (allCodes[0] === window.patientToken) {
          turnDiv.style.display = 'block';
        } else {
          turnDiv.style.display = 'none';
        }
      }
    }

    // kick it off every 4s
    setInterval(refresh, 4000);
  </script>
</body>
</html>
