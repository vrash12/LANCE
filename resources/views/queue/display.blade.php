<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Queue – {{ $department->short_name }}</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{--header:#00b467;--bg:#0d4640;--line:#ffffff;--text:#ffffff;}
    body{margin:0;background:var(--bg);color:var(--text);font-family:Arial,Helvetica,sans-serif}
    .topbar{background:var(--header);padding:.35rem .75rem;display:flex;align-items:center;
            justify-content:space-between;font-size:3rem;font-weight:700}
    .topbar img{height:60px;}
    .layout{display:grid;grid-template-columns:220px 1fr;grid-template-rows:auto 1fr;
            height:calc(100vh - 84px);}
    .queue-list{display:grid;grid-template-rows:repeat(5,1fr);border-right:8px solid var(--line);}
    .queue-slot{display:grid;grid-template-columns:60px 1fr;align-items:center;
                font-size:2.8rem;font-weight:700;border-bottom:8px solid var(--line);}
    .queue-slot:last-child{border-bottom:none;}
    .queue-slot div{text-align:center;}
    .right-pane{display:grid;grid-template-rows:92px 60px 1fr;}
    .dept{display:flex;align-items:center;justify-content:center;font-size:4rem;
          font-weight:700;border-bottom:8px solid var(--line);}
    .timestamp{display:flex;align-items:center;justify-content:center;font-size:1.6rem;
               font-weight:600;border-bottom:8px solid var(--line);}
    .now-serving{display:flex;align-items:center;justify-content:center;}
    .now-serving span{font-size:11rem;font-weight:700;letter-spacing:3px;}
  </style>
</head>
<body>


  {{-- HEADER --}}
  <div class="topbar">
    <span>Queueing</span>
    <img src="{{ asset('images/fabella-logo.png') }}" alt="Logo">
  </div>

  {{-- PATIENT TOKEN BANNERS --}}


  @if($patientToken)
    <div class="alert alert-info text-center m-0 p-2">
      Your token: <strong>{{ $patientToken }}</strong>
    </div>

    @if(isset($position) && $position)
      <div class="alert alert-secondary text-center m-0 p-2">
        You are number <strong>#{{ $position }}</strong> in the queue.
      </div>
    @endif

    @if($patientToken === $currentServing)
      <div class="alert alert-success text-center m-0 p-2">
        🎉 It’s your turn now!
      </div>
    @endif
  @endif


  {{-- MAIN GRID --}}
  <div class="layout">
    {{-- NEXT FIVE --}}
    <div class="queue-list">
      @foreach($tokens as $idx => $t)
        <div class="queue-slot">
          <div>{{ $idx + 1 }}</div>
          <div>{{ $t->code }}</div>
        </div>
      @endforeach
      {{-- pad empty --}}
      @for($i = $tokens->count(); $i < 5; $i++)
        <div class="queue-slot">
          <div>{{ $i + 1 }}</div><div>&nbsp;</div>
        </div>
      @endfor
    </div>

    {{-- RIGHT PANE --}}
    <div class="right-pane">
      <div class="dept">{{ $department->short_name }}</div>
      <div class="timestamp" id="tsLine">
        {{ $currentTime }} &nbsp;|&nbsp; Now Serving
      </div>
      <div class="now-serving">
        <span id="nowCode">{{ $currentServing }}</span>
      </div>
    </div>
  </div>

  {{-- LIVE POLL --}}
  <script>
    const deptUrl = "{{ route('queue.status', $department) }}";
    async function refresh() {
      const r       = await fetch(deptUrl);
      const data    = await r.json();
      const pending = data.pending.slice(0,5);
      const list    = document.querySelector('.queue-list');

      list.innerHTML = '';
      for (let i = 0; i < 5; i++) {
        const code = pending[i]?.code ?? '&nbsp;';
        list.insertAdjacentHTML('beforeend', `
          <div class="queue-slot">
            <div>${i+1}</div><div>${code}</div>
          </div>
        `);
      }

      document.getElementById('nowCode').innerText =
        pending.length ? pending[0].code : '—';

      document.getElementById('tsLine').firstChild.nodeValue =
        new Date().toLocaleString(undefined, {
          day:    '2-digit',
          month:  'long',
          year:   'numeric',
          hour:   '2-digit',
          minute: '2-digit',
          second: '2-digit'
        });
    }
    setInterval(refresh, 4000);
  </script>
</body>
</html>
