<?php
/**
 * Template Name: ASSIE IV — Presensi Booth (Full Page)
 * Halaman penuh presensi booth pameran ASSIE IV 2026.
 * Data disimpan ke database WordPress via REST API.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Tentukan base URL REST API WordPress
$rest_base = esc_url( rest_url('assie4/v1') );
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Presensi Pengunjung — ASSIE IV 2026</title>
<?php wp_head(); ?>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #0a0f1e;
    --surface: #111827;
    --card: #162033;
    --border: #1e3a5f;
    --accent: #00c6ff;
    --accent2: #f59e0b;
    --text: #e2e8f0;
    --muted: #64748b;
    --success: #10b981;
    --error: #ef4444;
    --radius: 14px;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 0 60px;
    overflow-x: hidden;
  }

  /* ─── HERO ─── */
  .hero {
    width: 100%;
    background: linear-gradient(135deg, #0a0f1e 0%, #0c1a3a 50%, #081020 100%);
    border-bottom: 1px solid var(--border);
    padding: 36px 24px 28px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(0,198,255,.12), transparent);
    pointer-events: none;
  }
  .hero-tag {
    display: inline-block;
    font-family: 'Syne', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--accent);
    background: rgba(0,198,255,.1);
    border: 1px solid rgba(0,198,255,.25);
    padding: 4px 14px;
    border-radius: 100px;
    margin-bottom: 14px;
  }
  .hero h1 {
    font-family: 'Syne', sans-serif;
    font-size: clamp(28px, 6vw, 52px);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -1px;
    background: linear-gradient(90deg, #fff 30%, #00c6ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .hero-sub {
    margin-top: 8px;
    font-size: 14px;
    color: var(--muted);
    letter-spacing: .5px;
  }
  .grid-lines {
    position: absolute;
    inset: 0;
    background-image:
      linear-gradient(rgba(0,198,255,.04) 1px, transparent 1px),
      linear-gradient(90deg, rgba(0,198,255,.04) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
  }

  /* ─── CONTAINER ─── */
  .container { width: 100%; max-width: 560px; padding: 32px 20px 0; }

  /* ─── BOOTH SELECTOR ─── */
  .selector-label {
    font-family: 'Syne', sans-serif;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 8px;
  }
  .selector-wrap { position: relative; }
  .selector-wrap select {
    width: 100%;
    appearance: none;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    color: var(--text);
    font-family: 'Syne', sans-serif;
    font-size: 18px;
    font-weight: 700;
    padding: 16px 48px 16px 20px;
    cursor: pointer;
    outline: none;
    transition: border-color .2s;
  }
  .selector-wrap select:focus { border-color: var(--accent); }
  .selector-wrap::after {
    content: '▾';
    position: absolute;
    right: 18px; top: 50%;
    transform: translateY(-50%);
    color: var(--accent);
    font-size: 18px;
    pointer-events: none;
  }

  /* ─── BOOTH BADGE ─── */
  .booth-badge {
    margin-top: 20px;
    background: linear-gradient(135deg, var(--card), #1a2a45);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 16px;
  }
  .booth-number {
    font-family: 'Syne', sans-serif;
    font-size: 36px;
    font-weight: 800;
    color: var(--accent);
    line-height: 1;
    min-width: 60px;
    text-align: center;
  }
  .booth-meta { flex: 1; }
  .booth-meta .bm-label { font-size: 11px; color: var(--muted); letter-spacing: 1.5px; text-transform: uppercase; }
  .booth-meta .bm-count {
    font-family: 'Syne', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: var(--accent2);
    margin-top: 2px;
  }

  /* ─── FORM CARD ─── */
  .form-card {
    margin-top: 24px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 28px 24px;
    position: relative;
    overflow: hidden;
  }
  .form-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--accent), var(--accent2));
  }
  .form-card h2 {
    font-family: 'Syne', sans-serif;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 22px;
    color: #fff;
  }

  .field { margin-bottom: 18px; }
  .field label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 6px;
  }
  .field label span { color: var(--error); margin-left: 2px; }
  .field input {
    width: 100%;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    padding: 13px 16px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
  }
  .field input::placeholder { color: #334155; }
  .field input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(0,198,255,.1); }
  .field input.invalid { border-color: var(--error); box-shadow: 0 0 0 3px rgba(239,68,68,.1); }
  .field .err-msg { font-size: 12px; color: var(--error); margin-top: 5px; display: none; }
  .field.has-error .err-msg { display: block; }

  /* ─── LOCATION BANNER ─── */
  .location-banner {
    margin-top: 20px;
    border-radius: var(--radius);
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13px;
    border: 1px solid;
    transition: background .3s, border-color .3s;
  }
  .loc-icon { font-size: 20px; flex-shrink: 0; }
  .loc-text { line-height: 1.4; }

  .loc-idle    { background: rgba(100,116,139,.1); border-color: rgba(100,116,139,.3); color: var(--muted); }
  .loc-loading { background: rgba(0,198,255,.07);  border-color: rgba(0,198,255,.2);  color: var(--accent); }
  .loc-granted { background: rgba(16,185,129,.1);  border-color: rgba(16,185,129,.3); color: var(--success); }
  .loc-denied  { background: rgba(239,68,68,.1);   border-color: rgba(239,68,68,.3);  color: var(--error); }
  .loc-outside { background: rgba(245,158,11,.1);  border-color: rgba(245,158,11,.3); color: var(--accent2); }

  .loc-loading .loc-icon {
    display: inline-block;
    animation: spin .8s linear infinite;
  }

  /* ─── SUBMIT BUTTON ─── */
  .btn-submit {
    width: 100%;
    margin-top: 8px;
    background: linear-gradient(135deg, #00a8d6, #0078a8);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-family: 'Syne', sans-serif;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 15px;
    cursor: pointer;
    transition: opacity .2s, transform .1s;
    position: relative;
    overflow: hidden;
  }
  .btn-submit::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.12), transparent);
  }
  .btn-submit:hover { opacity: .9; }
  .btn-submit:active { transform: scale(.98); }
  .btn-submit:disabled { opacity: .5; cursor: not-allowed; }

  /* ─── TOAST ─── */
  .toast {
    display: none;
    margin-top: 16px;
    border-radius: 10px;
    padding: 14px 18px;
    font-size: 14px;
    text-align: center;
    animation: fadeIn .4s ease;
  }
  .toast.success {
    display: block;
    background: rgba(16,185,129,.1);
    border: 1px solid rgba(16,185,129,.3);
    color: var(--success);
  }
  .toast.error-toast {
    display: block;
    background: rgba(239,68,68,.1);
    border: 1px solid rgba(239,68,68,.3);
    color: var(--error);
  }
  @keyframes fadeIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }

  /* ─── RECENT LIST ─── */
  .recent-section { margin-top: 30px; }
  .recent-section h3 {
    font-family: 'Syne', sans-serif;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 12px;
  }
  .recent-list { display: flex; flex-direction: column; gap: 8px; }
  .recent-item {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    animation: fadeIn .3s ease;
  }
  .ri-name { font-weight: 500; font-size: 14px; }
  .ri-inst { font-size: 12px; color: var(--muted); margin-top: 2px; }
  .ri-time { font-size: 11px; color: var(--muted); white-space: nowrap; }
  .empty-state { text-align: center; color: var(--muted); font-size: 13px; padding: 20px 0; }

  /* ─── LEADERBOARD ─── */
  .leaderboard-section { margin-top: 30px; }
  .leaderboard-section h3 {
    font-family: 'Syne', sans-serif;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 4px;
  }
  .leaderboard-date {
    font-size: 12px;
    color: var(--muted);
    margin-bottom: 12px;
  }
  .leaderboard-list { display: flex; flex-direction: column; gap: 6px; }
  .lb-item {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: fadeIn .3s ease;
  }
  .lb-item.lb-top1 { border-color: rgba(245,158,11,.5); background: rgba(245,158,11,.06); }
  .lb-item.lb-top2 { border-color: rgba(148,163,184,.4); background: rgba(148,163,184,.04); }
  .lb-item.lb-top3 { border-color: rgba(180,120,60,.4);  background: rgba(180,120,60,.04); }
  .lb-rank {
    font-family: 'Syne', sans-serif;
    font-size: 13px;
    font-weight: 800;
    min-width: 28px;
    text-align: center;
    color: var(--muted);
  }
  .lb-top1 .lb-rank { color: #f59e0b; }
  .lb-top2 .lb-rank { color: #94a3b8; }
  .lb-top3 .lb-rank { color: #b47c3c; }
  .lb-booth {
    font-family: 'Syne', sans-serif;
    font-size: 14px;
    font-weight: 700;
    flex: 1;
    color: var(--text);
  }
  .lb-bar-wrap {
    flex: 2;
    background: rgba(255,255,255,.05);
    border-radius: 100px;
    height: 6px;
    overflow: hidden;
  }
  .lb-bar {
    height: 100%;
    border-radius: 100px;
    background: linear-gradient(90deg, var(--accent), var(--accent2));
    transition: width .6s ease;
  }
  .lb-count {
    font-family: 'Syne', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: var(--accent2);
    min-width: 50px;
    text-align: right;
  }
  .lb-total-badge {
    display: inline-block;
    font-size: 12px;
    color: var(--accent);
    background: rgba(0,198,255,.08);
    border: 1px solid rgba(0,198,255,.2);
    border-radius: 100px;
    padding: 3px 12px;
    margin-left: 8px;
  }

  /* ─── FOOTER ─── */
  .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #2d3748; letter-spacing: .5px; }

  /* ─── LOADING SPINNER ─── */
  .spinner {
    display: inline-block;
    width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .6s linear infinite;
    vertical-align: middle;
    margin-right: 8px;
  }
  @keyframes spin { to { transform: rotate(360deg); } }
</style>
</head>
<body>

<div class="hero">
  <div class="grid-lines"></div>
  <div class="hero-tag">Pameran Resmi</div>
  <h1>ASSIE IV — 2026</h1>
  <p class="hero-sub">Sistem Presensi Digital Pengunjung Booth</p>
</div>

<div class="container">

  <!-- Pilih Booth -->
  <div class="selector-label">Pilih Nomor Booth</div>
  <div class="selector-wrap">
    <select id="boothSelect" onchange="onBoothChange()">
      <!-- 120 booth diisi via JS -->
    </select>
  </div>

  <!-- Badge info booth -->
  <div class="booth-badge">
    <div class="booth-number" id="badgeNum">01</div>
    <div class="booth-meta">
      <div class="bm-label">Total Pengunjung Booth Ini</div>
      <div class="bm-count" id="badgeCount">Memuat…</div>
    </div>
  </div>

  <!-- Status Lokasi -->
  <div class="location-banner loc-idle" id="locationBanner" onclick="if(locationStatus==='idle'||locationStatus==='denied'||locationStatus==='outside')requestLocation()">
    <span class="loc-icon">📍</span>
    <span class="loc-text">Ketuk untuk verifikasi lokasi Anda.</span>
  </div>

  <!-- Form Presensi -->
  <div class="form-card">
    <h2>✍️ Form Presensi Pengunjung</h2>

    <div class="field" id="field-nama">
      <label>Nama Lengkap <span>*</span></label>
      <input type="text" id="nama" placeholder="Masukkan nama lengkap Anda" autocomplete="name">
      <div class="err-msg" id="err-nama">Nama tidak boleh kosong.</div>
    </div>

    <div class="field" id="field-instansi">
      <label>Instansi / Asal <span>*</span></label>
      <input type="text" id="instansi" placeholder="Contoh: Universitas Airlangga" autocomplete="organization">
      <div class="err-msg" id="err-instansi">Instansi tidak boleh kosong.</div>
    </div>

    <div class="field" id="field-telp">
      <label>Nomor Telepon <span>*</span></label>
      <input type="tel" id="telp" placeholder="Contoh: 08123456789" autocomplete="tel">
      <div class="err-msg" id="err-telp">Nomor telepon tidak valid (min. 8 angka).</div>
    </div>

    <button class="btn-submit" id="btnSubmit" onclick="submitPresensi()">
      DAFTAR PRESENSI
    </button>

    <div class="toast" id="toast"></div>
  </div>

  <!-- Presensi Terakhir -->
  <div class="recent-section">
    <h3>Presensi Terakhir — Booth <span id="recentLabel">001</span></h3>
    <div class="recent-list" id="recentList">
      <div class="empty-state">Memuat data…</div>
    </div>
  </div>

  <!-- Leaderboard Harian -->
  <div class="leaderboard-section">
    <h3>🏆 Top Booth Hari Ini <span class="lb-total-badge" id="lbTotalBadge">0 pengunjung</span></h3>
    <div class="leaderboard-date" id="lbDate">—</div>
    <div class="leaderboard-list" id="leaderboardList">
      <div class="empty-state">Memuat leaderboard…</div>
    </div>
  </div>

</div>

<div class="footer">ASSIE IV 2026 &bull; Sistem Presensi Digital</div>

<script>
const REST_BASE = <?php echo json_encode( $rest_base ); ?>;
const NONCE    = <?php echo json_encode( wp_create_nonce('wp_rest') ); ?>;

// ─── GPS STATE ───
let userLat = null;
let userLng = null;
let locationStatus = 'idle'; // idle | loading | granted | denied | outside

// Koordinat & radius Grand City Surabaya (Jl. Kusuma Gubeng, Ketabang, Genteng)
const VENUE = { lat: -7.262113648386964, lng: 112.75013597795723, radiusM: 300 };

// ─── HAVERSINE (client-side preview, validasi final di server) ───
function haversineM(lat1, lng1, lat2, lng2) {
  const R = 6371000;
  const dLat = (lat2 - lat1) * Math.PI / 180;
  const dLng = (lng2 - lng1) * Math.PI / 180;
  const a = Math.sin(dLat/2)**2 +
            Math.cos(lat1*Math.PI/180) * Math.cos(lat2*Math.PI/180) *
            Math.sin(dLng/2)**2;
  return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

// ─── REQUEST LOKASI ───
function requestLocation() {
  if (!navigator.geolocation) {
    setLocationBanner('unsupported');
    return;
  }
  setLocationBanner('loading');
  navigator.geolocation.getCurrentPosition(
    pos => {
      userLat = pos.coords.latitude;
      userLng = pos.coords.longitude;
      const dist = haversineM(userLat, userLng, VENUE.lat, VENUE.lng);
      if (dist <= VENUE.radiusM) {
        locationStatus = 'granted';
        setLocationBanner('granted');
      } else {
        locationStatus = 'outside';
        setLocationBanner('outside', Math.round(dist));
      }
    },
    err => {
      locationStatus = 'denied';
      setLocationBanner('denied');
    },
    { enableHighAccuracy: true, timeout: 10000 }
  );
}

// ─── BANNER LOKASI ───
function setLocationBanner(state, dist) {
  const banner = document.getElementById('locationBanner');
  const configs = {
    idle:        { cls: 'loc-idle',     icon: '📍', msg: 'Ketuk untuk verifikasi lokasi Anda.' },
    loading:     { cls: 'loc-loading',  icon: '🔄', msg: 'Mendapatkan lokasi GPS…' },
    granted:     { cls: 'loc-granted',  icon: '✅', msg: 'Lokasi terverifikasi — Anda berada di Grand City Surabaya.' },
    denied:      { cls: 'loc-denied',   icon: '🚫', msg: 'Akses lokasi ditolak. Aktifkan izin lokasi di browser lalu muat ulang halaman.' },
    outside:     { cls: 'loc-outside',  icon: '⚠️', msg: `Anda berada ±${dist}m dari Grand City. Presensi hanya bisa dilakukan di dalam venue.` },
    unsupported: { cls: 'loc-denied',   icon: '❌', msg: 'Browser Anda tidak mendukung GPS. Gunakan browser lain.' },
  };
  const cfg = configs[state] || configs.idle;
  banner.className = 'location-banner ' + cfg.cls;
  banner.innerHTML = `<span class="loc-icon">${cfg.icon}</span><span class="loc-text">${cfg.msg}</span>`;
  if (state === 'idle') banner.style.cursor = 'pointer';
  else banner.style.cursor = 'default';
}


// ─── FETCH & RENDER LEADERBOARD ───
async function fetchLeaderboard() {
  try {
    const res = await fetch(`${REST_BASE}/leaderboard?limit=10`, {
      headers: { 'X-WP-Nonce': NONCE }
    });
    const data = await res.json();
    renderLeaderboard(data);
  } catch(e) {
    document.getElementById('leaderboardList').innerHTML = '<div class="empty-state">Gagal memuat leaderboard.</div>';
  }
}

function renderLeaderboard(data) {
  const list   = document.getElementById('leaderboardList');
  const badge  = document.getElementById('lbTotalBadge');
  const dateEl = document.getElementById('lbDate');

  const d = new Date(data.date + 'T00:00:00');
  dateEl.textContent = d.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
  badge.textContent  = data.total_today + ' pengunjung';

  const lb = data.leaderboard || [];
  if (!lb.length) {
    list.innerHTML = '<div class="empty-state">Belum ada presensi hari ini.</div>';
    return;
  }

  const maxVal = parseInt(lb[0].total) || 1;
  const medals = ['🥇','🥈','🥉'];
  list.innerHTML = lb.map((item, i) => {
    const rankCls   = i < 3 ? `lb-top${i+1}` : '';
    const rankLabel = i < 3 ? medals[i] : `#${i+1}`;
    const pct = Math.round((parseInt(item.total) / maxVal) * 100);
    return `
      <div class="lb-item ${rankCls}">
        <div class="lb-rank">${rankLabel}</div>
        <div class="lb-booth">Booth ${String(item.booth).padStart(3,'0')}</div>
        <div class="lb-bar-wrap"><div class="lb-bar" style="width:${pct}%"></div></div>
        <div class="lb-count">${item.total} org</div>
      </div>`;
  }).join('');
}

const SELECT = document.getElementById('boothSelect');
for (let i = 1; i <= 120; i++) {
  const opt = document.createElement('option');
  opt.value = i;
  opt.textContent = `Booth ${String(i).padStart(3,'0')}`;
  SELECT.appendChild(opt);
}

// ─── ON BOOTH CHANGE ───
function onBoothChange() {
  const num = parseInt(SELECT.value);
  document.getElementById('badgeNum').textContent = String(num).padStart(2,'0');
  document.getElementById('recentLabel').textContent = String(num).padStart(3,'0');
  document.getElementById('badgeCount').textContent = 'Memuat…';
  document.getElementById('recentList').innerHTML = '<div class="empty-state">Memuat data…</div>';
  clearForm();
  hideToast();
  fetchBoothData(num);
}

// ─── FETCH DATA BOOTH DARI REST API ───
async function fetchBoothData(booth) {
  try {
    const res = await fetch(`${REST_BASE}/presensi?booth=${booth}&limit=5`, {
      headers: { 'X-WP-Nonce': NONCE }
    });
    const data = await res.json();

    document.getElementById('badgeCount').textContent = data.total + ' orang';
    renderRecent(data.entries || []);
  } catch(e) {
    document.getElementById('badgeCount').textContent = '–';
    document.getElementById('recentList').innerHTML = '<div class="empty-state">Gagal memuat data.</div>';
  }
}

// ─── RENDER RECENT LIST ───
function renderRecent(entries) {
  const list = document.getElementById('recentList');
  if (!entries.length) {
    list.innerHTML = '<div class="empty-state">Belum ada presensi untuk booth ini.</div>';
    return;
  }
  list.innerHTML = entries.map(e => `
    <div class="recent-item">
      <div>
        <div class="ri-name">${esc(e.nama)}</div>
        <div class="ri-inst">${esc(e.instansi)}</div>
      </div>
      <div class="ri-time">${esc(e.waktu_fmt)}</div>
    </div>
  `).join('');
}

function esc(s) {
  if (!s) return '';
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// ─── VALIDASI ───
function validate() {
  let valid = true;

  const nama = document.getElementById('nama').value.trim();
  setError('nama', !nama, 'Nama tidak boleh kosong.');
  if (!nama) valid = false;

  const instansi = document.getElementById('instansi').value.trim();
  setError('instansi', !instansi, 'Instansi tidak boleh kosong.');
  if (!instansi) valid = false;

  const telp = document.getElementById('telp').value.trim().replace(/\D/g,'');
  setError('telp', telp.length < 8, 'Nomor telepon tidak valid (min. 8 angka).');
  if (telp.length < 8) valid = false;

  return valid;
}

function setError(field, hasError, msg) {
  const fEl  = document.getElementById('field-' + field);
  const iEl  = document.getElementById(field);
  const eEl  = document.getElementById('err-' + field);
  if (hasError) {
    fEl.classList.add('has-error');
    iEl.classList.add('invalid');
    if (eEl && msg) eEl.textContent = msg;
  } else {
    fEl.classList.remove('has-error');
    iEl.classList.remove('invalid');
  }
}

// ─── SUBMIT KE REST API ───
async function submitPresensi() {
  // Cek status lokasi dulu
  if (locationStatus === 'idle') {
    showToast('error-toast', '📍 Ketuk banner lokasi di atas untuk verifikasi posisi Anda terlebih dahulu.');
    return;
  }
  if (locationStatus === 'loading') {
    showToast('error-toast', '🔄 Masih mendapatkan lokasi GPS, mohon tunggu sebentar.');
    return;
  }
  if (locationStatus === 'denied' || locationStatus === 'unsupported') {
    showToast('error-toast', '🚫 Izin lokasi diperlukan. Aktifkan GPS di pengaturan browser Anda.');
    return;
  }
  if (locationStatus === 'outside') {
    showToast('error-toast', '⚠️ Anda tidak berada di area Grand City Surabaya. Presensi tidak dapat dilakukan.');
    return;
  }

  if (!validate()) return;

  const btn  = document.getElementById('btnSubmit');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner"></span>Menyimpan…';
  hideToast();

  const booth    = parseInt(SELECT.value);
  const nama     = document.getElementById('nama').value.trim();
  const instansi = document.getElementById('instansi').value.trim();
  const telp     = document.getElementById('telp').value.trim();

  try {
    const res = await fetch(`${REST_BASE}/presensi`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': NONCE,
      },
      body: JSON.stringify({ booth, nama, instansi, telp, lat: userLat, lng: userLng }),
    });

    const data = await res.json();

    if (res.ok && data.success) {
      showToast('success', '✅ Presensi berhasil dicatat! Selamat menikmati pameran.');
      document.getElementById('badgeCount').textContent = data.total + ' orang';
      clearForm();
      fetchBoothData(booth);
      fetchLeaderboard();
    } else {
      const msg = data.message || 'Gagal menyimpan presensi. Silakan coba lagi.';
      showToast('error-toast', '⚠️ ' + msg);
    }

  } catch(e) {
    showToast('error-toast', '⚠️ Koneksi gagal. Periksa internet Anda dan coba lagi.');
  } finally {
    btn.disabled = false;
    btn.textContent = 'DAFTAR PRESENSI';
  }
}

function showToast(cls, msg) {
  const t = document.getElementById('toast');
  t.className = 'toast ' + cls;
  t.textContent = msg;
  if (cls === 'success') {
    setTimeout(() => t.className = 'toast', 4000);
  }
}
function hideToast() {
  document.getElementById('toast').className = 'toast';
}

function clearForm() {
  ['nama','instansi','telp'].forEach(id => {
    document.getElementById(id).value = '';
    document.getElementById(id).classList.remove('invalid');
  });
  ['field-nama','field-instansi','field-telp'].forEach(id => {
    document.getElementById(id).classList.remove('has-error');
  });
}

// ─── INIT ───
onBoothChange();
fetchLeaderboard();
requestLocation();
</script>

<?php wp_footer(); ?>
</body>
</html>
