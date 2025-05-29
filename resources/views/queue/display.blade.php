<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Queue – {{ $department->short_name }}</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --header:#00b467;--bg:#0d4640;--line:#ffffff;--text:#ffffff;
    }
    body{
      margin:0;background:var(--bg);color:var(--text);
      font-family:Arial,Helvetica,sans-serif;
    }
    .topbar{
      background:var(--header);padding:.4rem .8rem;
      display:flex;align-items:center;justify-content:space-between;
      font-size:2.6rem;font-weight:700;
    }
    .topbar img{height:60px}
    .layout{
      display:grid;grid-template-columns:220px 1fr;
      grid-template-rows:auto 1fr;height:calc(100vh - 84px);
    }
    .queue-list{
      display:grid;grid-template-rows:repeat(5,1fr);
      border-right:8px solid var(--line);
    }
    .queue-slot{
      display:grid;grid-template-columns:60px 1fr;
      align-items:center;font-size:2.8rem;font-weight:700;
      border-bottom:8px solid var(--line);
    }
    .queue-slot:last-child{border-bottom:none}
    .queue-slot div{text-align:center}
    .right-pane{
      display:grid;grid-template-rows:92px 60px 1fr;
    }
    .dept{
      display:flex;align-items:center;justify-content:center;
      font-size:4rem;font-weight:700;border-bottom:8px solid var(--line);
    }
    .timestamp{
      display:flex;align-items:center;justify-content:center;
      font-size:1.6rem;font-weight:600;border-bottom:8px solid var(--line);
    }
    .now-serving{display:flex;align-items:center;justify-content:center}
    .now-serving span{font-size:11rem;font-weight:700;letter-spacing:3px}
  </style>
</head>
<body>

{{-- header --}}
<div class="topbar">
  <a href="{{ route('queue.department_select') }}"
     class="btn btn-light btn-sm me-3 fw-bold">
    ← Back
  </a>
  <span>Queueing</span>
  <img src="{{ asset('images/fabella-logo.png') }}" alt="Logo">
</div>

{{-- main grid --}}
<div class="layout">
  {{-- LEFT – first five --}}
  <div class="queue-list" id="listSlots">
    @for($i=0;$i<5;$i++)
      <div class="queue-slot">
        <div>{{ $i+1 }}</div>
        <div>{{ $tokens[$i]->code ?? '—' }}</div>
      </div>
    @endfor
  </div>

  {{-- RIGHT – dept / time / now serving --}}
  <div class="right-pane">
    <div class="dept">{{ $department->short_name }}</div>
    <div class="timestamp" id="tsLine">{{ $currentTime }} | Now Serving</div>
    <div class="now-serving">
      <span id="nowCode">{{ $currentServing }}</span>
    </div>
  </div>
</div>

{{-- live poll --}}
<script>
const url  = "{{ route('queue.status',$department) }}";
const list = document.getElementById('listSlots');
const nowC = document.getElementById('nowCode');
const tsLn = document.getElementById('tsLine');

async function refresh(){
  const r   = await fetch(url); if(!r.ok) return;
  const j   = await r.json();
  const p5  = j.pending;               // first 5 → array of {code:...}
  /* rebuild left grid */
  list.innerHTML='';
  for(let i=0;i<5;i++){
    const code = p5[i]?.code ?? '—';
    list.insertAdjacentHTML('beforeend',`
      <div class="queue-slot">
        <div>${i+1}</div><div>${code}</div>
      </div>`);
  }
  /* now serving */
  nowC.textContent = j.all_codes[0] ?? '—';
  /* timestamp */
  tsLn.textContent =
    new Date().toLocaleString(undefined,{day:'2-digit',month:'long',year:'numeric',
      hour:'2-digit',minute:'2-digit',second:'2-digit'}) + ' | Now Serving';
}
setInterval(refresh,4000);
</script>
</body>
</html>
