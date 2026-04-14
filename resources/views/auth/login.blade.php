<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LibTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        .w {
            font-family:'Inter',sans-serif;
            display:flex;
            min-height:100vh; /* ✅ full tinggi layar */
            border-radius:20px;
            overflow:hidden;
        }
        /* KIRI */
        .lf { width:35%; min-width: 280px; flex-shrink:0; position:relative; background:#0c1a3e; padding:36px 30px; display:flex; flex-direction:column; overflow:hidden; }
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

        /* KANAN - background dekoratif */
        .rt {
            width: 65%;
            flex:1; position:relative; overflow:hidden;
            background:#eef2fa;
            display:flex; align-items:center; justify-content:center; padding:32px;
        }

        /* dot pattern overlay */
        .rt-dots {
            position:absolute; inset:0;
            background-image: radial-gradient(circle, rgba(47,109,246,0.13) 1.5px, transparent 1.5px);
            background-size: 22px 22px;
        }

        /* shape dekoratif di background kanan */
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
        .eye { position:absolute; right:13px; top:50%; transform:translateY(-50%); cursor:pointer; display:flex; align-items:center; background:none; border:none; padding:0; }
        .eye svg { width:16px; height:16px; stroke:#9ca3af; }
        .forgot { text-align:right; margin-top:-9px; margin-bottom:14px; }
        .forgot a { font-size:12px; color:#2f6df6; text-decoration:none; }
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

        .register-link {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin: 12px 0 18px; /* kasih jarak atas & bawah */
        }

        .register-link a {
            color: #2f6df6;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        </style>
</head>
<body>

{{-- ── KIRI ── --}}
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
        <h2>Selamat datang kembali</h2>
        <p>Lanjutkan perjalanan membacamu bersama perpustakaan digital kami.</p>
        <div class="pills">
          <div class="pill"><div class="pdot"></div><div class="ptxt">Akses 1.240+ koleksi buku</div></div>
          <div class="pill"><div class="pdot"></div><div class="ptxt">Pantau tenggat pengembalian</div></div>
          <div class="pill"><div class="pdot"></div><div class="ptxt">Riwayat peminjaman lengkap</div></div>
        </div>
      </div>
      <div class="cp">© 2025 LibTrack · SMKN 3 Banjar</div>
    </div>
  </div>

  <!-- KANAN -->
  <div class="rt">

    <!-- dot grid -->
    <div class="rt-dots"></div>

    <!-- shape dekoratif -->
    <div class="rt-deco">
      <svg viewBox="0 0 600 640" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
        <!-- lingkaran besar pojok kanan bawah -->
        <circle cx="580" cy="620" r="260" fill="rgba(47,109,246,0.055)" />
        <circle cx="580" cy="620" r="190" fill="rgba(47,109,246,0.05)" />
        <!-- lingkaran kecil pojok kiri atas -->
        <circle cx="30" cy="40" r="120" fill="rgba(47,109,246,0.04)" />
        <circle cx="30" cy="40" r="70" fill="rgba(47,109,246,0.035)" />
        <!-- garis diagonal -->
        <line x1="0" y1="200" x2="600" y2="480" stroke="rgba(47,109,246,0.06)" stroke-width="1"/>
        <line x1="0" y1="340" x2="600" y2="620" stroke="rgba(47,109,246,0.04)" stroke-width="0.5"/>
        <!-- titik aksen -->
        <circle cx="80" cy="320" r="3" fill="rgba(47,109,246,0.15)"/>
        <circle cx="520" cy="140" r="4" fill="rgba(47,109,246,0.1)"/>
        <circle cx="460" cy="540" r="3" fill="rgba(47,109,246,0.12)"/>
        <circle cx="150" cy="580" r="2.5" fill="rgba(47,109,246,0.1)"/>
        <!-- segitiga pojok -->
        <polygon points="600,0 600,80 520,0" fill="rgba(47,109,246,0.06)"/>
        <polygon points="0,560 0,640 80,640" fill="rgba(47,109,246,0.06)"/>
        <!-- pill dekoratif blur-ish -->
        <rect x="420" y="60" width="120" height="6" rx="3" fill="rgba(47,109,246,0.08)"/>
        <rect x="440" y="76" width="80" height="4" rx="2" fill="rgba(47,109,246,0.06)"/>
        <rect x="40" y="490" width="100" height="5" rx="2.5" fill="rgba(47,109,246,0.07)"/>
        <rect x="55" y="503" width="65" height="4" rx="2" fill="rgba(47,109,246,0.05)"/>
      </svg>
    </div>

    <!-- CARD FORM -->
    <div class="card">
      <div class="tag">Masuk ke akun</div>
      <h3>Login</h3>
      <div class="dsub">Masukkan email dan password kamu</div>

<form method="POST" action="{{ route('login') }}">
  @csrf

  <!-- Email -->
  <div class="field">
    <label>Email</label>
    <div class="iw">
      <input type="email" name="email" class="inp" id="em">
      <span class="ii">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="4" width="20" height="16" rx="3"/>
          <polyline points="2,4 12,13 22,4"/>
        </svg>
      </span>
    </div>
  </div>

  <!-- Password -->
  <div class="field">
    <label>Password</label>
    <div class="iw">
      <input type="password" name="password" class="inp" id="pw"
        placeholder="Min. 6 karakter" style="padding-right:42px" required>
      <span class="ii">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="5" y="11" width="14" height="10" rx="2"/>
          <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
          <circle cx="12" cy="16" r="1.2" fill="#9ca3af" stroke="none"/>
        </svg>
      </span>

      <button class="eye" type="button" onclick="tp()">
        <svg id="ei" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z"/>
          <circle cx="12" cy="12" r="3"/>
        </svg>
      </button>
    </div>
  </div>
    <div class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>

  <button type="submit" class="btn">
    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
      <polyline points="10 17 15 12 10 7"/>
      <line x1="15" y1="12" x2="3" y2="12"/>
    </svg>
    Masuk
  </button>

</form>


</div>

<script>
var ps=false;
function tp(){
  ps=!ps;
  document.getElementById('pw').type=ps?'text':'password';
  document.getElementById('ei').innerHTML=ps
    ?'<path d="M17.94 17.94A10.94 10.94 0 0 1 12 19C5 19 1 12 1 12a18.5 18.5 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
    :'<path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>';
}
['em','pw'].forEach(function(id){
  var el=document.getElementById(id);
  el.addEventListener('focus',function(){ this.parentNode.querySelector('.ii svg').style.stroke='#2f6df6'; });
  el.addEventListener('blur', function(){ this.parentNode.querySelector('.ii svg').style.stroke='#9ca3af'; });
});
</script>

</body>
</html>
