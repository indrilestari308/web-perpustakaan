<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - LibTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        .w {
            font-family:'Inter',sans-serif;
            display:flex;
            min-height:100vh;
            border-radius:20px;
            overflow:hidden;
        }
        /* KIRI */
        .lf { width:35%; min-width:280px; flex-shrink:0; position:relative; background:#0c1a3e; padding:36px 30px; display:flex; flex-direction:column; overflow:hidden; }
        .lf-ov { position:absolute; inset:0; background:linear-gradient(155deg,rgba(8,18,52,0.88) 0%,rgba(12,26,70,0.72) 55%,rgba(5,12,36,0.94) 100%); }
        .lf-ab { position:absolute; inset:0; overflow:hidden; }
        .lf-ab svg { width:100%; height:100%; }
        .lf-in { position:relative; z-index:2; display:flex; flex-direction:column; height:100%; }
        .brand { font-size:19px; font-weight:800; color:#fff; letter-spacing:1.5px; }
        .brand span { color:#6ea8fe; }
        .brand-s { font-size:10px; color:rgba(255,255,255,0.38); margin-top:2px; letter-spacing:.6px; }
        .lf-mid { flex:1; display:flex; flex-direction:column; justify-content:center; padding:32px 0; }
        .lf-mid h2 { font-size:25px; font-weight:800; color:#fff; line-height:1.35; margin-bottom:10px; }
        .lf-mid p { font-size:13px; color:rgba(200,220,255,0.68); line-height:1.75; margin-bottom:22px; }
        .pills { display:flex; flex-direction:column; gap:8px; }
        .pill { display:flex; align-items:center; gap:10px; background:rgba(255,255,255,0.06); border:0.5px solid rgba(255,255,255,0.12); border-radius:10px; padding:9px 13px; }
        .pdot { width:6px; height:6px; border-radius:50%; background:#6ea8fe; flex-shrink:0; }
        .ptxt { font-size:12px; color:rgba(200,220,255,0.85); }
        .cp { font-size:10px; color:rgba(255,255,255,0.18); }

        /* KANAN */
        .rt {
            width:65%;
            flex:1; position:relative; overflow:hidden;
            background:#eef2fa;
            display:flex; align-items:center; justify-content:center; padding:32px;
        }
        .rt-dots {
            position:absolute; inset:0;
            background-image: radial-gradient(circle, rgba(47,109,246,0.13) 1.5px, transparent 1.5px);
            background-size: 22px 22px;
        }
        .rt-deco { position:absolute; inset:0; overflow:hidden; pointer-events:none; }
        .rt-deco svg { width:100%; height:100%; }

        /* card form */
        .card {
            position:relative; z-index:2;
            width:100%; max-width:360px;
            background:#fff;
            border:0.5px solid #d8e1f0;
            border-radius:5px;
            padding:32px 28px;
            box-shadow: 0 4px 24px rgba(47,109,246,0.07), 0 1px 4px rgba(0,0,0,0.05);
        }
        .tag { font-size:10px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#2f6df6; margin-bottom:5px; }
        .card h3 { font-size:22px; font-weight:800; color:#111827; margin-bottom:3px; }
        .dsub { font-size:13px; color:#6b7280; margin-bottom:22px; }

        /* alert error */
        .alert-err { background:#fee2e2; border:1px solid #fca5a5; border-radius:8px; padding:10px 14px; font-size:12px; color:#991b1b; margin-bottom:16px; }
        .alert-err ul { margin:0; padding-left:16px; }

        .field { margin-bottom:15px; }
        .field label { display:block; font-size:10px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af; margin-bottom:6px; }
        .iw { position:relative; }
        .ii { position:absolute; left:13px; top:50%; transform:translateY(-50%); display:flex; align-items:center; pointer-events:none; }
        .ii svg { width:16px; height:16px; stroke:#9ca3af; transition:stroke .15s; }
        .inp {
            width:100%; background:#f5f8ff; border:1px solid #dde5f5; border-radius:5px;
            padding:11px 13px 11px 40px; font-size:14px; color:#111827;
            outline:none; font-family:'Inter',sans-serif; transition:border-color .15s,box-shadow .15s;
        }
        .inp:focus { border-color:#2f6df6; box-shadow:0 0 0 3px rgba(47,109,246,0.1); background:#fff; }
        .inp.is-invalid { border-color:#dc3545; }
        .invalid-msg { font-size:11px; color:#dc3545; margin-top:4px; }
        .eye { position:absolute; right:13px; top:50%; transform:translateY(-50%); cursor:pointer; display:flex; align-items:center; background:none; border:none; padding:0; }
        .eye svg { width:16px; height:16px; stroke:#9ca3af; }

        /* strength bar */
        .str-bar-wrap { margin-top:6px; }
        .str-track { height:3px; border-radius:2px; background:#e5e7eb; overflow:hidden; }
        .str-fill { height:100%; border-radius:2px; width:0%; transition:width .3s,background .3s; }
        .str-lbl { font-size:11px; color:#9ca3af; margin-top:3px; }

        .btn {
            width:100%; background:#2f6df6; color:#fff; border:none; border-radius:10px; padding:13px;
            font-size:15px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif;
            display:flex; align-items:center; justify-content:center; gap:8px;
            transition:background .2s,transform .1s;
        }
        .btn:hover { background:#1a5ce6; }
        .btn:active { transform:scale(.985); }
        .btn svg { width:16px; height:16px; stroke:#fff; fill:none; }
        .foot { text-align:center; font-size:13px; color:#6b7280; margin-top:16px; }
        .foot a { color:#2f6df6; font-weight:600; text-decoration:none; }
    </style>
</head>
<body>

<div class="w">

  <!-- KIRI -->
  <div class="lf">
    <div class="lf-bg"></div>
    <div class="lf-ov"></div>
    <div class="lf-ab">
      <svg viewBox="0 0 340 640" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
        <circle cx="0" cy="580" r="200" fill="none" stroke="rgba(110,168,254,0.12)" stroke-width="1"/>
        <circle cx="0" cy="580" r="140" fill="none" stroke="rgba(110,168,254,0.08)" stroke-width="1"/>
        <circle cx="340" cy="50" r="180" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="1"/>
        <line x1="30" y1="0" x2="340" y2="450" stroke="rgba(110,168,254,0.07)" stroke-width="0.5"/>
        <circle cx="60" cy="160" r="2" fill="rgba(110,168,254,0.35)"/>
        <circle cx="200" cy="80" r="1.5" fill="rgba(110,168,254,0.25)"/>
        <circle cx="290" cy="310" r="2" fill="rgba(255,255,255,0.18)"/>
        <circle cx="130" cy="520" r="1.5" fill="rgba(110,168,254,0.22)"/>
        <polygon points="310,0 340,0 340,50" fill="rgba(110,168,254,0.1)"/>
        <polygon points="0,590 0,640 60,640" fill="rgba(110,168,254,0.08)"/>
      </svg>
    </div>
    <div class="lf-in">
      <div>
        <div class="brand">Lib<span>Track</span></div>
        <div class="brand-s">SMKN 3 BANJAR</div>
      </div>
      <div class="lf-mid">
        <h2>Bergabung bersama kami</h2>
        <p>Buat akun dan mulai nikmati layanan perpustakaan digital SMKN 3 Banjar.</p>
        <div class="pills">
          <div class="pill"><div class="pdot"></div><div class="ptxt">Daftar gratis, langsung aktif</div></div>
          <div class="pill"><div class="pdot"></div><div class="ptxt">Akses 1.240+ koleksi buku</div></div>
          <div class="pill"><div class="pdot"></div><div class="ptxt">Pantau peminjaman real-time</div></div>
        </div>
      </div>
      <div class="cp">© 2025 LibTrack · SMKN 3 Banjar</div>
    </div>
  </div>

  <!-- KANAN -->
  <div class="rt">
    <div class="rt-dots"></div>
    <div class="rt-deco">
      <svg viewBox="0 0 600 640" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
        <circle cx="580" cy="620" r="260" fill="rgba(47,109,246,0.055)"/>
        <circle cx="580" cy="620" r="190" fill="rgba(47,109,246,0.05)"/>
        <circle cx="30" cy="40" r="120" fill="rgba(47,109,246,0.04)"/>
        <circle cx="30" cy="40" r="70" fill="rgba(47,109,246,0.035)"/>
        <line x1="0" y1="200" x2="600" y2="480" stroke="rgba(47,109,246,0.06)" stroke-width="1"/>
        <line x1="0" y1="340" x2="600" y2="620" stroke="rgba(47,109,246,0.04)" stroke-width="0.5"/>
        <circle cx="80" cy="320" r="3" fill="rgba(47,109,246,0.15)"/>
        <circle cx="520" cy="140" r="4" fill="rgba(47,109,246,0.1)"/>
        <circle cx="460" cy="540" r="3" fill="rgba(47,109,246,0.12)"/>
        <circle cx="150" cy="580" r="2.5" fill="rgba(47,109,246,0.1)"/>
        <polygon points="600,0 600,80 520,0" fill="rgba(47,109,246,0.06)"/>
        <polygon points="0,560 0,640 80,640" fill="rgba(47,109,246,0.06)"/>
        <rect x="420" y="60" width="120" height="6" rx="3" fill="rgba(47,109,246,0.08)"/>
        <rect x="440" y="76" width="80" height="4" rx="2" fill="rgba(47,109,246,0.06)"/>
        <rect x="40" y="490" width="100" height="5" rx="2.5" fill="rgba(47,109,246,0.07)"/>
        <rect x="55" y="503" width="65" height="4" rx="2" fill="rgba(47,109,246,0.05)"/>
      </svg>
    </div>

    <!-- CARD FORM -->
    <div class="card">
      <div class="tag">Buat akun baru</div>
      <h3>Daftar</h3>
      <div class="dsub">Lengkapi data diri kamu untuk mendaftar</div>

      @if($errors->any())
        <div class="alert-err">
          <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div class="field">
          <label>Nama Lengkap</label>
          <div class="iw">
            <input type="text" name="name" id="nm" class="inp {{ $errors->has('name') ? 'is-invalid' : '' }}"
              value="{{ old('name') }}" placeholder="Nama lengkap kamu" required autofocus>
            <span class="ii">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
              </svg>
            </span>
          </div>
          @error('name')<div class="invalid-msg">{{ $message }}</div>@enderror
        </div>

        <!-- Email -->
        <div class="field">
          <label>Email</label>
          <div class="iw">
            <input type="email" name="email" id="em" class="inp {{ $errors->has('email') ? 'is-invalid' : '' }}"
              value="{{ old('email') }}" placeholder="nama@smkn3banjar.sch.id" required>
            <span class="ii">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="3"/>
                <polyline points="2,4 12,13 22,4"/>
              </svg>
            </span>
          </div>
          @error('email')<div class="invalid-msg">{{ $message }}</div>@enderror
        </div>

        <!-- Password -->
        <div class="field">
          <label>Password</label>
          <div class="iw">
            <input type="password" name="password" id="pw" class="inp {{ $errors->has('password') ? 'is-invalid' : '' }}"
              placeholder="Min. 6 karakter" style="padding-right:42px" required oninput="checkStr(this.value)">
            <span class="ii">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="11" width="14" height="10" rx="2"/>
                <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                <circle cx="12" cy="16" r="1.2" fill="#9ca3af" stroke="none"/>
              </svg>
            </span>
            <button class="eye" type="button" onclick="tp('pw','ei1')">
              <svg id="ei1" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          <div id="str-wrap" style="display:none" class="str-bar-wrap">
            <div class="str-track"><div class="str-fill" id="str-fill"></div></div>
            <div class="str-lbl" id="str-lbl"></div>
          </div>
          @error('password')<div class="invalid-msg">{{ $message }}</div>@enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="field">
          <label>Konfirmasi Password</label>
          <div class="iw">
            <input type="password" name="password_confirmation" id="pw2" class="inp"
              placeholder="Ulangi password" style="padding-right:42px" required>
            <span class="ii">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="11" width="14" height="10" rx="2"/>
                <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                <polyline points="9 16 11 18 15 14" stroke-width="1.8"/>
              </svg>
            </span>
            <button class="eye" type="button" onclick="tp('pw2','ei2')">
              <svg id="ei2" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" class="btn">
          <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <line x1="19" y1="8" x2="19" y2="14"/>
            <line x1="22" y1="11" x2="16" y2="11"/>
          </svg>
          Daftar Sekarang
        </button>
      </form>

      <div class="foot">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></div>
    </div>
  </div>

</div>

<script>
/* toggle show/hide password */
function tp(inputId, iconId) {
  var el = document.getElementById(inputId);
  var ic = document.getElementById(iconId);
  var shown = el.type === 'text';
  el.type = shown ? 'password' : 'text';
  ic.innerHTML = shown
    ? '<path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>'
    : '<path d="M17.94 17.94A10.94 10.94 0 0 1 12 19C5 19 1 12 1 12a18.5 18.5 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
}

/* password strength */
function checkStr(val) {
  var wrap  = document.getElementById('str-wrap');
  var fill  = document.getElementById('str-fill');
  var lbl   = document.getElementById('str-lbl');
  if (!val) { wrap.style.display = 'none'; return; }
  wrap.style.display = 'block';
  var score = 0;
  if (val.length >= 6)  score++;
  if (val.length >= 10) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  var lvl = [
    { pct:'20%', bg:'#ef4444', txt:'Sangat lemah' },
    { pct:'40%', bg:'#f97316', txt:'Lemah' },
    { pct:'60%', bg:'#eab308', txt:'Cukup' },
    { pct:'80%', bg:'#22c55e', txt:'Kuat' },
    { pct:'100%',bg:'#16a34a', txt:'Sangat kuat' },
  ][Math.min(score, 4)];
  fill.style.width      = lvl.pct;
  fill.style.background = lvl.bg;
  lbl.textContent       = lvl.txt;
  lbl.style.color       = lvl.bg;
}

/* icon stroke on focus — sama persis seperti login */
['nm','em','pw','pw2'].forEach(function(id) {
  var el = document.getElementById(id);
  if (!el) return;
  el.addEventListener('focus', function() {
    var svg = this.parentNode.querySelector('.ii svg');
    if (svg) svg.style.stroke = '#2f6df6';
  });
  el.addEventListener('blur', function() {
    var svg = this.parentNode.querySelector('.ii svg');
    if (svg) svg.style.stroke = '#9ca3af';
  });
});
</script>

</body>
</html>
