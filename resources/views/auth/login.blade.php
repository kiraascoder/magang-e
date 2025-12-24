<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login • Sistem Pemagangan</title>

  <style>
    :root{
      --bg1:#0ea5e9; /* sky */
      --bg2:#6366f1; /* indigo */
      --text:#0f172a;
      --muted:#64748b;
      --card:rgba(255,255,255,.78);
      --border:rgba(148,163,184,.45);
      --shadow:0 18px 50px rgba(2,6,23,.18);
      --radius:18px;
    }

    *{ box-sizing:border-box; }
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Arial;
      color:var(--text);
      min-height:100vh;
      display:grid;
      place-items:center;
      padding:28px 16px;
      background:
        radial-gradient(1000px 600px at 10% 10%, rgba(14,165,233,.35), transparent 60%),
        radial-gradient(900px 600px at 90% 20%, rgba(99,102,241,.35), transparent 60%),
        radial-gradient(900px 700px at 50% 100%, rgba(34,197,94,.14), transparent 60%),
        linear-gradient(135deg, #f8fafc, #eef2ff);
    }

    .wrap{
      width:100%;
      max-width:980px;
      display:grid;
      grid-template-columns: 1.1fr .9fr;
      gap:18px;
      align-items:stretch;
    }

    /* panel kiri (branding) */
    .hero{
      border-radius: var(--radius);
      padding:26px;
      background: linear-gradient(135deg, rgba(14,165,233,.12), rgba(99,102,241,.12));
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      position:relative;
      overflow:hidden;
    }
    .hero:before{
      content:"";
      position:absolute; inset:-40px;
      background:
        radial-gradient(220px 220px at 20% 20%, rgba(14,165,233,.35), transparent 60%),
        radial-gradient(260px 260px at 70% 30%, rgba(99,102,241,.35), transparent 60%),
        radial-gradient(280px 280px at 55% 90%, rgba(34,197,94,.18), transparent 65%);
      filter: blur(2px);
      opacity:.9;
    }
    .hero > *{ position:relative; }
    .badge{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:8px 12px;
      border-radius:999px;
      border:1px solid var(--border);
      background: rgba(255,255,255,.55);
      font-size:13px;
      color:var(--muted);
      width:max-content;
    }
    .dot{
      width:10px; height:10px; border-radius:999px;
      background: linear-gradient(135deg, var(--bg1), var(--bg2));
      box-shadow: 0 6px 18px rgba(14,165,233,.25);
    }
    .hero h1{
      margin:14px 0 8px;
      font-size:28px;
      line-height:1.15;
      letter-spacing:-.02em;
    }
    .hero p{
      margin:0;
      color:var(--muted);
      max-width:52ch;
      line-height:1.55;
    }
    .list{
      margin-top:18px;
      display:grid;
      gap:10px;
    }
    .li{
      display:flex;
      gap:10px;
      align-items:flex-start;
      padding:10px 12px;
      border-radius:14px;
      background: rgba(255,255,255,.45);
      border:1px solid var(--border);
    }
    .ico{
      width:36px; height:36px;
      border-radius:12px;
      background: linear-gradient(135deg, rgba(14,165,233,.18), rgba(99,102,241,.18));
      display:grid;
      place-items:center;
      flex: 0 0 auto;
    }
    .li b{ display:block; font-size:14px; margin-bottom:2px; }
    .li small{ color:var(--muted); font-size:12.5px; line-height:1.35; }

    /* panel kanan (form) */
    .card{
      border-radius: var(--radius);
      background: var(--card);
      border:1px solid var(--border);
      box-shadow: var(--shadow);
      padding:24px;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .title{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      margin-bottom:14px;
    }
    .title h2{ margin:0; font-size:20px; letter-spacing:-.01em; }
    .subtitle{
      margin:0 0 18px;
      color:var(--muted);
      font-size:13.5px;
      line-height:1.5;
    }

    .err{
      background: rgba(239,68,68,.10);
      border: 1px solid rgba(239,68,68,.30);
      color:#991b1b;
      padding:12px 14px;
      border-radius:14px;
      margin-bottom:14px;
      font-size:14px;
    }
    .err ul{ margin:0; padding-left:18px; }

    .row{ margin-bottom:14px; }
    label{
      display:block;
      font-size:13px;
      font-weight:600;
      margin-bottom:7px;
      color:#0f172a;
    }

    .field{
      position:relative;
    }
    .field svg{
      position:absolute;
      left:12px;
      top:50%;
      transform:translateY(-50%);
      width:18px;
      height:18px;
      opacity:.6;
    }
    input{
      width:100%;
      padding:11px 12px 11px 40px;
      border:1px solid rgba(148,163,184,.55);
      border-radius:14px;
      outline:none;
      background: rgba(255,255,255,.85);
      transition: .18s ease;
      font-size:14px;
    }
    input:focus{
      border-color: rgba(14,165,233,.75);
      box-shadow: 0 0 0 4px rgba(14,165,233,.16);
    }

    .hint{
      font-size:12px;
      color:var(--muted);
      margin-top:7px;
      line-height:1.35;
    }

    .actions{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      margin: 6px 0 14px;
    }
    .remember{
      display:flex;
      align-items:center;
      gap:10px;
      color:var(--muted);
      font-size:13px;
      user-select:none;
    }
    .remember input{
      width:18px;
      height:18px;
      padding:0;
      border-radius:6px;
      border:1px solid rgba(148,163,184,.7);
      accent-color: #2563eb;
    }

    button{
      width:100%;
      padding:11px 12px;
      border:0;
      border-radius:14px;
      cursor:pointer;
      font-weight:700;
      letter-spacing:.01em;
      color:white;
      background: linear-gradient(135deg, #0ea5e9, #6366f1);
      box-shadow: 0 14px 30px rgba(14,165,233,.25);
      transition: transform .12s ease, filter .12s ease;
    }
    button:hover{ filter: brightness(1.03); transform: translateY(-1px); }
    button:active{ transform: translateY(0px); }

    .foot{
      margin-top:12px;
      color:var(--muted);
      font-size:12px;
      text-align:center;
    }

    /* responsive */
    @media (max-width: 860px){
      .wrap{ grid-template-columns: 1fr; }
      .hero{ display:none; } /* biar fokus form di hp */
    }
  </style>
</head>

<body>
  <div class="wrap">

    <section class="hero" aria-hidden="true">
      <span class="badge"><span class="dot"></span> Portal Sistem Pemagangan</span>
      <h1>Masuk untuk kelola magang dengan rapi.</h1>
      <p>Gunakan akun sesuai peran: Admin (Email), Dosen (NBM), atau Mahasiswa (NIM). Pastikan password benar.</p>

      <div class="list">
        <div class="li">
          <div class="ico">🎓</div>
          <div>
            <b>Mahasiswa</b>
            <small>Input jurnal, upload laporan akhir, pantau progres penempatan.</small>
          </div>
        </div>
        <div class="li">
          <div class="ico">🧑‍🏫</div>
          <div>
            <b>Dosen</b>
            <small>Verifikasi jurnal, review laporan akhir, berikan penilaian.</small>
          </div>
        </div>
        <div class="li">
          <div class="ico">🛡️</div>
          <div>
            <b>Admin</b>
            <small>Kelola data master, akun, penempatan, dan monitoring keseluruhan.</small>
          </div>
        </div>
      </div>
    </section>

    <main class="card">
      <div class="title">
        <h2>Login</h2>
        <span class="badge" title="Aman & terenkripsi"><span class="dot"></span> Secure</span>
      </div>
      <p class="subtitle">Masukkan <b>Email (Admin)</b> / <b>NBM (Dosen)</b> / <b>NIM (Mahasiswa)</b>.</p>

      @if ($errors->any())
        <div class="err">
          <ul>
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="row">
          <label for="identifier">Akun</label>
          <div class="field">
            <!-- user icon -->
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21a8 8 0 0 0-16 0"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <input id="identifier" name="identifier" value="{{ old('identifier') }}"
                   placeholder="Email / NBM / NIM" autocomplete="username">
          </div>
          <div class="hint">Contoh: admin@mail.com / NBM00123 / 202312345</div>
        </div>

        <div class="row">
          <label for="password">Password</label>
          <div class="field">
            <!-- lock icon -->
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="11" width="18" height="11" rx="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <input id="password" name="password" type="password"
                   placeholder="Masukkan Password" autocomplete="current-password">
          </div>
        </div>

        <div class="actions">
          <label class="remember" for="remember">
            <input type="checkbox" name="remember" id="remember">
            Remember me
          </label>
        </div>

        <button type="submit">Masuk</button>

        <div class="foot">
          © {{ date('Y') }} Sistem Pemagangan • Universitas/Instansi
        </div>
      </form>
    </main>

  </div>
</body>
</html>
