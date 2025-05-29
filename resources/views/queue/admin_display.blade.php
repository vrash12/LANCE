{{-- resources/views/queue/admin_display.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Queue – {{ $department->short_name }} (Admin)</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --primary: #00b467;
      --primary-dark: #008a4f;
      --bg: #0a1a1a;
      --surface: #1a2a2a;
      --surface-light: #2a3a3a;
      --accent: #00ff7f;
      --text: #ffffff;
      --text-muted: #b0b0b0;
      --border: rgba(255, 255, 255, 0.1);
      --glow: 0 0 20px rgba(0, 180, 103, 0.3);
      --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background: linear-gradient(135deg, var(--bg) 0%, #051015 100%);
      color: var(--text);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow: hidden;
    }

    /* Animated background pattern */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 50%, rgba(0, 180, 103, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(0, 255, 127, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(0, 180, 103, 0.08) 0%, transparent 50%);
      animation: float 20s ease-in-out infinite;
      z-index: -1;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(1deg); }
    }

    .topbar {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: var(--shadow);
      border-bottom: 2px solid var(--accent);
      position: relative;
      overflow: hidden;
    }

    .topbar::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
      0% { left: -100%; }
      100% { left: 100%; }
    }

    .topbar-left {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .btn {
      border: none;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn-back {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      backdrop-filter: blur(10px);
      padding: 0.5rem 1rem;
    }

    .btn-back:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateX(-2px);
    }

    .btn-serve {
      background: linear-gradient(135deg, var(--accent) 0%, #00cc66 100%);
      color: var(--bg);
      padding: 0.8rem 2rem;
      font-size: 1.2rem;
      box-shadow: var(--glow);
    }

    .btn-serve:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 30px rgba(0, 255, 127, 0.5);
    }

    .logo {
      height: 60px;
      filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
      transition: transform 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.05);
    }

    .layout {
      display: grid;
      grid-template-columns: 300px 1fr;
      height: calc(100vh - 104px);
      gap: 2px;
    }

    .queue-list {
      background: var(--surface);
      border-radius: 0 20px 0 0;
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
      box-shadow: var(--shadow);
      border-right: 3px solid var(--accent);
    }

    .queue-header {
      text-align: center;
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--accent);
      margin-bottom: 1rem;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .queue-slot {
      background: linear-gradient(135deg, var(--surface-light) 0%, var(--surface) 100%);
      border-radius: 16px;
      padding: 1.5rem;
      display: grid;
      grid-template-columns: 60px 1fr;
      align-items: center;
      gap: 1rem;
      transition: all 0.3s ease;
      border: 1px solid var(--border);
      position: relative;
      overflow: hidden;
    }

    .queue-slot::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, transparent 0%, rgba(0, 255, 127, 0.1) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .queue-slot:hover::before {
      opacity: 1;
    }

    .queue-slot:hover {
      transform: translateX(8px);
      border-color: var(--accent);
      box-shadow: 0 8px 25px rgba(0, 180, 103, 0.2);
    }

    .queue-number {
      background: linear-gradient(135deg, var(--accent) 0%, #00cc66 100%);
      color: var(--bg);
      border-radius: 50%;
      width: 45px;
      height: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 1.2rem;
    }

    .queue-code {
      font-size: 2rem;
      font-weight: 700;
      letter-spacing: 1px;
    }

    .right-pane {
      background: var(--surface);
      border-radius: 20px 0 0 0;
      display: grid;
      grid-template-rows: auto auto 1fr;
      box-shadow: var(--shadow);
    }

    .dept-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      padding: 2rem;
      text-align: center;
      font-size: 3.5rem;
      font-weight: 700;
      border-radius: 20px 0 0 0;
      position: relative;
      overflow: hidden;
    }

    .dept-header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--accent) 0%, transparent 50%, var(--accent) 100%);
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 0.5; }
      50% { opacity: 1; }
    }

    .timestamp {
      background: var(--surface-light);
      padding: 1.5rem;
      text-align: center;
      font-size: 1.4rem;
      font-weight: 600;
      color: var(--text-muted);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
    }

    .status-indicator {
      width: 12px;
      height: 12px;
      background: var(--accent);
      border-radius: 50%;
      animation: blink 2s infinite;
    }

    @keyframes blink {
      0%, 50% { opacity: 1; }
      51%, 100% { opacity: 0.3; }
    }

    .now-serving {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      gap: 2rem;
      padding: 3rem;
      background: radial-gradient(circle at center, rgba(0, 255, 127, 0.1) 0%, transparent 70%);
    }

    .serving-label {
      font-size: 2rem;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 3px;
    }

    .serving-code {
      font-size: 8rem;
      font-weight: 900;
      letter-spacing: 4px;
      color: var(--accent);
      text-shadow: 0 0 30px rgba(0, 255, 127, 0.5);
      animation: glow 3s ease-in-out infinite;
      position: relative;
    }

    @keyframes glow {
      0%, 100% { 
        text-shadow: 0 0 30px rgba(0, 255, 127, 0.5);
        transform: scale(1);
      }
      50% { 
        text-shadow: 0 0 50px rgba(0, 255, 127, 0.8);
        transform: scale(1.02);
      }
    }

    .serving-code::before {
      content: '';
      position: absolute;
      top: -20px;
      left: -20px;
      right: -20px;
      bottom: -20px;
      border: 2px solid var(--accent);
      border-radius: 20px;
      opacity: 0.3;
      animation: borderPulse 4s infinite;
    }

    @keyframes borderPulse {
      0%, 100% { 
        opacity: 0.3;
        transform: scale(1);
      }
      50% { 
        opacity: 0.6;
        transform: scale(1.1);
      }
    }

    /* Loading animation */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(10, 26, 26, 0.9);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .loading-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .spinner {
      width: 60px;
      height: 60px;
      border: 4px solid var(--surface);
      border-top: 4px solid var(--accent);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .layout {
        grid-template-columns: 1fr;
        grid-template-rows: auto 1fr;
      }
      
      .queue-list {
        border-radius: 0;
        border-right: none;
        border-bottom: 3px solid var(--accent);
      }
      
      .right-pane {
        border-radius: 0;
      }
      
      .dept-header {
        border-radius: 0;
        font-size: 2.5rem;
      }
      
      .serving-code {
        font-size: 4rem;
      }
    }
  </style>
</head>
<body>
  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
  </div>

  {{-- HEADER --}}
  <div class="topbar">
    <div class="topbar-left">
      <a href="{{ route('queue.index') }}" class="btn btn-back">
        <i class="bi bi-arrow-left"></i> Back
      </a>

      {{-- Serve-Next button --}}
      <form action="{{ route('queue.serveNext.admin',$department) }}" method="POST"
            onsubmit="return confirm('Serve next token?');"
            class="d-inline">
        @csrf @method('PATCH')
        <button class="btn btn-serve" type="submit">
          <i class="bi bi-play-fill"></i> Serve Next
        </button>
      </form>
    </div>

    <img src="{{ asset('images/fabella-logo.png') }}" alt="Logo" class="logo">
  </div>

  {{-- MAIN GRID --}}
  <div class="layout">

    {{-- LEFT – next five --}}
    <div class="queue-list">
      <div class="queue-header">
        <i class="bi bi-list-ol"></i> Queue
      </div>
      <div id="queueList">
        @foreach($tokens as $idx=>$t)
          <div class="queue-slot">
            <div class="queue-number">{{ $idx+1 }}</div>
            <div class="queue-code">{{ $t->code }}</div>
          </div>
        @endforeach
        @for($i=$tokens->count(); $i<5; $i++)
          <div class="queue-slot">
            <div class="queue-number">{{ $i+1 }}</div>
            <div class="queue-code" style="opacity: 0.3;">—</div>
          </div>
        @endfor
      </div>
    </div>

    {{-- RIGHT --}}
    <div class="right-pane">
      <div class="dept-header">
        {{ $department->short_name }}
      </div>
      
      <div class="timestamp" id="tsLine">
        <div class="status-indicator"></div>
        <span>{{ $currentTime }} | Now Serving</span>
      </div>
      
      <div class="now-serving">
        <div class="serving-label">Now Serving</div>
        <div class="serving-code" id="nowCode">{{ $currentServing ?: '—' }}</div>
      </div>
    </div>
  </div>

  {{-- Enhanced polling with loading states --}}
  <script>
    const url = "{{ route('queue.status',$department) }}";
    const loadingOverlay = document.getElementById('loadingOverlay');
    let isRefreshing = false;

    async function refresh() {
      if (isRefreshing) return;
      isRefreshing = true;

      try {
        const response = await fetch(url);
        const data = await response.json();
        
        const list = document.getElementById('queueList');
        list.innerHTML = '';
        
        const pending = data.pending.slice(0, 5);
        
        for (let i = 0; i < 5; i++) {
          const token = pending[i];
          const code = token?.code || '—';
          const opacity = token ? '1' : '0.3';
          
          list.insertAdjacentHTML('beforeend', `
            <div class="queue-slot">
              <div class="queue-number">${i + 1}</div>
              <div class="queue-code" style="opacity: ${opacity};">${code}</div>
            </div>
          `);
        }
        
        // Update current serving
        const currentServing = pending.length > 0 ? pending[0].code : '—';
        document.getElementById('nowCode').textContent = currentServing;
        
        // Update timestamp
        const now = new Date();
        const timeString = now.toLocaleString(undefined, {
          day: '2-digit',
          month: 'long',
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit'
        });
        
        document.querySelector('#tsLine span').textContent = `${timeString} | Now Serving`;
        
      } catch (error) {
        console.error('Failed to refresh queue:', error);
      } finally {
        isRefreshing = false;
      }
    }

    // Show loading overlay on form submit
    document.querySelector('form').addEventListener('submit', function() {
      loadingOverlay.classList.add('active');
      
      // Hide loading overlay after a delay (in case redirect is slow)
      setTimeout(() => {
        loadingOverlay.classList.remove('active');
      }, 3000);
    });

    // Initial load
    setTimeout(refresh, 1000);
    
    // Poll every 4 seconds
    setInterval(refresh, 4000);

    // Add smooth transitions when elements change
    const observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        mutation.addedNodes.forEach(function(node) {
          if (node.nodeType === 1 && node.classList.contains('queue-slot')) {
            node.style.opacity = '0';
            node.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
              node.style.transition = 'all 0.5s ease';
              node.style.opacity = '1';
              node.style.transform = 'translateX(0)';
            }, 50);
          }
        });
      });
    });

    observer.observe(document.getElementById('queueList'), {childList: true});
  </script>
</body>
</html>