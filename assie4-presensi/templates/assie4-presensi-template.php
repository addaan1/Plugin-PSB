<?php
/**
 * Template Name: ASSIE IV — Presensi Booth (Full Page)
 * Halaman penuh presensi booth pameran ASSIE IV 2026.
 * Data disimpan ke database WordPress via REST API.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Follow the exhibition page permalink when returning from attendance.
$exhibition_slug = defined( 'ASSIE4_PAMERAN_SLUG' ) ? ASSIE4_PAMERAN_SLUG : 'pameran-assie4';
$exhibition_page = get_page_by_path( $exhibition_slug );
$exhibition_url = $exhibition_page ? get_permalink( $exhibition_page ) : home_url( '/' . $exhibition_slug . '/' );
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Presensi Pengunjung — ASSIE IV 2026</title>
<?php remove_action( 'wp_head', 'wp_site_icon', 99 ); wp_head(); ?>
<?php $unair_icon = 'https://fst.unair.ac.id/wp-content/uploads/2024/03/Logo-Branding-UNAIR-biru-1024x1024.png?ver=presensi-2'; ?>
<link rel="icon" type="image/png" href="<?php echo esc_url( $unair_icon ); ?>">
<link rel="apple-touch-icon" href="<?php echo esc_url( $unair_icon ); ?>">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root { --bg:#080d1b; --surface:#0e1728; --input:#0a1221; --border:#253145; --text:#eef2fb; --muted:#9aaac1; --gold:#d7ad43; --success:#7cdbb3; --error:#ff999c; }
  * { box-sizing:border-box; }
  body { margin:0; background:var(--bg); color:var(--text); font:15px/1.55 'DM Sans',sans-serif; }
  button,input { font:inherit; }
  button,a,input { -webkit-tap-highlight-color:transparent; }
  button,a { touch-action:manipulation; }
  a { color:inherit; }
  [hidden] { display:none!important; }
  button { cursor:pointer; }
  :focus-visible { outline:2px solid var(--gold); outline-offset:4px; }
  .site-header { max-width:1040px; margin:auto; padding:25px 30px; display:flex; align-items:center; justify-content:space-between; gap:20px; border-bottom:1px solid var(--border); }
  .brand { display:flex; align-items:center; gap:12px; text-decoration:none; }
  .brand-word { font:800 20px 'Syne',sans-serif; letter-spacing:-.6px; white-space:nowrap; }
  .brand-year { font-size:11px; color:var(--gold); border-left:1px solid #536071; padding-left:12px; letter-spacing:1px; }
  .back-link { display:flex; align-items:center; gap:9px; min-height:44px; color:var(--muted); font-size:13px; text-decoration:none; transition:color .18s; }
  .back-link:hover { color:var(--gold); }
  .back-link svg { width:17px; height:17px; }
  .hero { max-width:1040px; margin:auto; padding:35px 30px 27px; }
  .hero-tag { color:var(--gold); font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; margin-bottom:9px; }
  .hero h1 { margin:0; font:700 clamp(28px,4vw,38px)/1.15 'Syne',sans-serif; letter-spacing:-1px; }
  .hero-sub { color:var(--muted); font-size:14px; margin:12px 0 0; }
  .container { max-width:1040px; margin:auto; padding:0 30px; display:grid; grid-template-columns:minmax(0,1.3fr) minmax(0,1fr); gap:28px; align-items:start; }
  .registration { padding:26px; border:1px solid var(--border); border-radius:14px; background:var(--surface); min-width:0; }
  .section-label { margin:0 0 16px; color:var(--text); font-size:15px; font-weight:600; }
  .section-label span { color:var(--gold); font-size:11px; margin-right:10px; font-variant-numeric:tabular-nums; }
  .selector-label { display:block; color:var(--muted); font-size:12px; margin-bottom:7px; }
  .selector-wrap { position:relative; }
  .picker-trigger { width:100%; min-height:76px; display:flex; align-items:center; gap:12px; padding:13px; border:1px solid #556076; border-radius:8px; background:var(--input); color:var(--text); text-align:left; transition:border-color .18s, transform .18s; }
  .picker-trigger:hover, .picker-trigger[aria-expanded="true"] { border-color:var(--gold); }
  .picker-trigger:active { transform:scale(.992); }
  .picker-code { flex:none; min-width:43px; height:43px; display:grid; place-items:center; border-radius:5px; background:#29261d; color:var(--gold); font-size:15px; font-weight:700; }
  .picker-summary { min-width:0; display:grid; gap:4px; flex:1; }
  .picker-summary strong { font-size:14px; line-height:1.35; font-weight:500; overflow-wrap:anywhere; }
  .picker-summary small { color:var(--muted); font-size:11px; }
  .picker-chevron { color:var(--muted); flex:none; }
  .picker-panel { position:absolute; z-index:30; top:calc(100% + 6px); left:0; right:0; padding:12px; border:1px solid #556076; border-radius:9px; background:#152034; box-shadow:0 18px 40px #0007; animation:reveal .15s ease; }
  .picker-search { width:100%; min-height:44px; padding:10px; border:1px solid var(--border); border-radius:5px; background:var(--input); color:var(--text); font-size:16px; }
  .picker-options { max-height:min(300px,45dvh); overflow-y:auto; overscroll-behavior:contain; margin-top:7px; }
  .picker-option { width:100%; min-height:52px; display:flex; align-items:center; gap:10px; padding:10px; border:0; border-radius:5px; background:transparent; color:var(--text); text-align:left; }
  .picker-option:hover,.picker-option:focus-visible,.picker-option[aria-current="true"] { background:#2a3545; }
  .picker-option-code { flex:none; color:var(--gold); font-size:12px; font-weight:700; min-width:31px; }
  .picker-option-text { min-width:0; display:grid; gap:3px; }
  .picker-option-text strong { font-size:13px; font-weight:500; line-height:1.35; }
  .picker-option-text small { color:var(--muted); font-size:11px; }
  .picker-empty { color:var(--muted); font-size:13px; padding:12px 2px; }
  .booth-badge { display:flex; justify-content:space-between; align-items:center; gap:15px; padding:11px 0 23px; color:var(--muted); font-size:11px; border-bottom:1px solid var(--border); margin-bottom:23px; }
  .bm-count { color:var(--text); font-weight:500; white-space:nowrap; }
  .form-card h2 { margin-bottom:18px; }
  .field { margin-bottom:17px; }
  .field label { display:block; font-size:12px; font-weight:500; color:#c9d4e5; margin-bottom:7px; }
  .field label span { color:var(--gold); }
  .field input { width:100%; min-height:47px; background:var(--input); border:1px solid var(--border); border-radius:6px; color:var(--text); padding:11px 13px; font-size:16px; transition:border-color .18s; }
  .field input::placeholder { color:#75859c; font-size:13px; }
  .field input:focus { border-color:var(--gold); outline:0; box-shadow:0 0 0 2px #d7ad431c; }
  .field input.invalid { border-color:var(--error); }
  .err-msg { display:none; color:var(--error); font-size:12px; margin-top:5px; }
  .has-error .err-msg { display:block; }
  .btn-submit { width:100%; min-height:49px; display:flex; align-items:center; justify-content:center; gap:10px; border:0; border-radius:7px; background:var(--gold); color:#16140c; font-weight:700; font-size:14px; margin-top:23px; position:relative; overflow:hidden; transition:background .2s, transform .18s, box-shadow .2s; }
  .btn-submit:hover { background:#e7bd55; box-shadow:0 6px 22px #d7ad4333; transform:translateY(-2px); }
  .btn-submit:active { transform:translateY(1px) scale(.985); box-shadow:none; }
  .btn-submit.is-success { background:#7cdbb3; }
  .btn-submit.is-invalid { animation:button-nudge .28s ease; }
  .btn-submit:disabled { opacity:.6; cursor:wait; }
  .btn-submit.is-success:disabled { opacity:1; cursor:default; }
  .form-note { font-size:11px; color:var(--muted); margin:13px 0 0; text-align:center; }
  .toast { display:none; padding:12px; margin-top:14px; border-radius:6px; font-size:13px; }
  .toast.success { display:block; color:var(--success); background:#12372c; }
  .toast.error-toast { display:block; color:var(--error); background:#39222b; }
  .side-column { min-width:0; }
  .leaderboard-section { background:var(--surface); border:1px solid var(--border); border-radius:14px; overflow:hidden; }
  .leaderboard-heading { display:flex; align-items:center; justify-content:space-between; padding:23px 23px 0; gap:12px; }
  .leaderboard-heading h2 { font:600 18px 'Syne',sans-serif; letter-spacing:-.4px; margin:0; }
  .ranking-mark { color:var(--gold); width:23px; height:23px; }
  .leaderboard-date { color:var(--muted); font-size:11px; padding:6px 23px 18px; }
  .daily-summary { margin:0 23px; border-top:1px solid var(--border); padding:17px 0; display:flex; align-items:baseline; gap:9px; }
  .daily-summary strong { font:600 32px/1 'DM Sans',sans-serif; letter-spacing:-1px; font-variant-numeric:tabular-nums; }
  .daily-summary span { font-size:11px; color:var(--muted); }
  .leaderboard-list { padding:0 13px 10px; }
  .rank-row { display:grid; grid-template-columns:24px minmax(0,1fr) auto; gap:10px; align-items:start; padding:16px 10px; border-top:1px solid var(--border); }
  .rank-row:first-child { background:#d7ad430d; border-top:1px solid #d7ad4355; border-radius:6px; }
  .rank-position { font-size:12px; color:#8798ae; padding-top:2px; }
  .rank-row:first-child .rank-position { color:var(--gold); }
  .rank-name { font-size:13px; line-height:1.5; font-weight:500; margin:0; overflow-wrap:anywhere; }
  .rank-code { display:block; font-size:10px; color:var(--muted); margin-top:3px; }
  .rank-count { font-size:19px; line-height:1.2; text-align:right; font-variant-numeric:tabular-nums; }
  .rank-count small { display:block; font-size:9px; color:var(--muted); margin-top:4px; }
  .rank-bar { height:3px; background:#263044; margin-top:11px; border-radius:2px; overflow:hidden; }
  .rank-bar span { display:block; height:100%; background:#798aa4; border-radius:2px; }
  .rank-row:first-child .rank-bar span { background:var(--gold); }
  .recent-section { margin-top:26px; padding:0 2px; }
  .recent-section h3 { font-size:13px; font-weight:600; margin:0; }
  .recent-context { color:var(--muted); font-size:11px; margin:4px 0 13px; }
  .recent-item { display:flex; justify-content:space-between; gap:14px; border-top:1px solid var(--border); padding:12px 0; }
  .ri-name { font-size:12px; font-weight:500; }
  .ri-inst,.ri-time { font-size:10px; color:var(--muted); }
  .ri-time { white-space:nowrap; padding-top:2px; }
  .empty-state { padding:24px 10px; font-size:12px; color:var(--muted); line-height:1.6; }
  .recent-list .empty-state { padding:17px 0; border-top:1px solid var(--border); }
  .footer { max-width:980px; margin:28px auto 0; padding:19px 0 30px; border-top:1px solid var(--border); color:#76869d; font-size:10px; display:flex; justify-content:space-between; gap:15px; }
  .spinner { display:inline-block; width:15px; height:15px; border:2px solid #16140c40; border-top-color:#16140c; border-radius:50%; animation:spin .7s linear infinite; }
  @keyframes spin { to { transform:rotate(360deg); } }
  @keyframes button-nudge { 25% { transform:translateX(-4px); } 75% { transform:translateX(4px); } }
  @keyframes reveal { from { opacity:0; transform:translateY(-4px); } to { opacity:1; transform:translateY(0); } }
  @media(max-width:720px) {
    .site-header { padding:13px 20px; }
    .brand-word { font-size:clamp(12px,3.8vw,17px); }
    .brand-year { display:none; }
    .back-link { font-size:11px; gap:6px; }
    .hero { padding:27px 20px 23px; }
    .hero h1 { font-size:29px; }
    .hero-sub { font-size:13px; max-width:310px; }
    .container { padding:0 16px; grid-template-columns:minmax(0,1fr); gap:25px; max-width:540px; }
    .registration { padding:21px 18px; }
    .picker-summary strong { font-size:13px; }
    .picker-trigger { padding:11px; gap:10px; }
    .footer { margin:27px 20px 0; flex-direction:column; gap:3px; }
  }
  @media(max-width:520px) {
    .site-header { flex-wrap:wrap; gap:1px; }
    .brand { width:100%; min-width:0; }
    .brand-word { font-size:17px; white-space:normal; line-height:1.2; }
    .back-link { margin-left:auto; }
  }
  @media(prefers-reduced-motion:reduce) { *,*::before,*::after { animation:none!important; transition:none!important; } }
</style>
</head>
<body>

<header class="site-header">
  <a class="brand" href="<?php echo esc_url( $exhibition_url ); ?>" aria-label="Industry Matching ASSIE IV — beranda pameran"><span class="brand-word">Industry Matching ASSIE IV</span><span class="brand-year">2026</span></a>
  <a class="back-link" href="<?php echo esc_url( $exhibition_url ); ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="m12 5-7 7 7 7M5 12h15"/></svg>Kembali ke pameran</a>
</header>

<div class="hero">
  <div class="hero-inner">
    <div class="hero-tag">PRESENSI PENGUNJUNG</div>
    <h1>Presensi booth</h1>
    <p class="hero-sub">Catat kunjungan Anda ke booth pilihan di ASSIE IV.</p>
  </div>
</div>

<main class="container">
<section class="registration" aria-label="Formulir presensi">
  <h2 class="section-label"><span>01</span>Booth yang dikunjungi</h2>

  <!-- Pilih Booth -->
  <div class="selector-label" id="pickerLabel">Cari nama tenant atau kode booth</div>
  <div class="selector-wrap" id="boothPicker">
    <button type="button" class="picker-trigger" id="pickerTrigger" aria-expanded="false" aria-controls="pickerPanel" aria-labelledby="pickerLabel pickerName">
      <span class="picker-code" id="pickerCode">A1</span>
      <span class="picker-summary"><strong id="pickerName">Memuat booth…</strong><small id="pickerMeta"></small></span>
      <span class="picker-chevron" aria-hidden="true">⌄</span>
    </button>
    <div class="picker-panel" id="pickerPanel" hidden>
      <label class="selector-label" for="pickerSearch">Cari nomor, kode, atau tenant</label>
      <input class="picker-search" type="search" id="pickerSearch" autocomplete="off" placeholder="Contoh: A11 atau Fakultas Ilmu Budaya">
      <div class="picker-options" id="pickerOptions" role="group" aria-label="Pilihan booth"></div>
      <p class="picker-empty" id="pickerEmpty" hidden>Booth tidak ditemukan.</p>
    </div>
    <select id="boothSelect" hidden aria-hidden="true" tabindex="-1">
      <!-- 106 booth resmi diisi via JavaScript -->
    </select>
  </div>

  <!-- Badge info booth -->
  <div class="booth-badge">
    <span>Total kunjungan booth ini</span>
    <span class="bm-count" id="badgeCount" role="status">Memuat…</span>
  </div>

  <!-- Form Presensi -->
  <form class="form-card" id="attendanceForm" novalidate>
    <h2 class="section-label"><span>02</span>Data pengunjung</h2>

    <div class="field" id="field-nama">
      <label for="nama">Nama lengkap <span>*</span></label>
      <input type="text" id="nama" placeholder="Masukkan nama lengkap Anda" autocomplete="name">
      <div class="err-msg" id="err-nama">Nama tidak boleh kosong.</div>
    </div>

    <div class="field" id="field-instansi">
      <label for="instansi">Instansi / asal <span>*</span></label>
      <input type="text" id="instansi" placeholder="Contoh: Universitas Airlangga" autocomplete="organization">
      <div class="err-msg" id="err-instansi">Instansi tidak boleh kosong.</div>
    </div>

    <div class="field" id="field-telp">
      <label for="telp">Nomor telepon <span>*</span></label>
      <input type="tel" id="telp" placeholder="Contoh: 08123456789" autocomplete="tel">
      <div class="err-msg" id="err-telp">Nomor telepon tidak valid (min. 8 angka).</div>
    </div>

    <button class="btn-submit" id="btnSubmit" type="submit">
      Catat kehadiran <span aria-hidden="true">→</span>
    </button>
    <p class="form-note">Pastikan booth dan data Anda sudah sesuai.</p>
    <div class="toast" id="toast" role="status" aria-live="polite"></div>
  </form>
</section>

<aside class="side-column" aria-label="Aktivitas pameran">
  <section class="leaderboard-section" aria-labelledby="leaderboardTitle">
    <div class="leaderboard-heading"><h2 id="leaderboardTitle">Top booth hari ini</h2><svg class="ranking-mark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M8 3h8v7a4 4 0 0 1-8 0V3ZM8 5H4v3a4 4 0 0 0 4 4m8-7h4v3a4 4 0 0 1-4 4m-4 2v5m-4 2h8m-6-2h4"/></svg></div>
    <div class="leaderboard-date" id="lbDate">Memuat tanggal…</div>
    <div class="daily-summary"><strong id="lbTotalBadge">—</strong><span>kunjungan hari ini · seluruh booth</span></div>
    <div class="leaderboard-list" id="leaderboardList" aria-live="polite"><div class="empty-state">Memuat peringkat booth…</div></div>
  </section>

  <!-- Presensi Terakhir -->
  <div class="recent-section">
    <h3>Kunjungan terbaru</h3>
    <p class="recent-context" id="recentLabel">Booth 001 · A1</p>
    <div class="recent-list" id="recentList">
      <div class="empty-state">Memuat data…</div>
    </div>
  </div>

</aside>
</main>

<footer class="footer"><span>ASSIE IV 2026 · Industry Matching</span><span>PASINBIS Universitas Airlangga</span></footer>

<script>
const NONCE    = <?php echo json_encode( wp_create_nonce('wp_rest') ); ?>;

// Kode dan nama booth diambil dari pemetaan resmi serta data tenant plugin pameran.
const BOOTH_DIRECTORY = <?php echo wp_json_encode( assie4_presensi_booth_directory(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ); ?>;

function boothInfo(number) {
  return BOOTH_DIRECTORY[String(parseInt(number, 10))] || null;
}

function boothLabel(number) {
  const details = boothInfo(number);
  return details ? details.label : `Booth ${String(number).padStart(3, '0')} — belum terdaftar di denah`;
}

function boothShortLabel(number) {
  const padded = String(number).padStart(3, '0');
  const details = boothInfo(number);
  return details ? `Booth ${padded} · ${details.code}` : `Booth ${padded}`;
}


// The WordPress endpoint may use either pretty permalinks or ?rest_route=.
const REST_ENDPOINTS = <?php echo wp_json_encode( [ 'presensi' => rest_url('assie4/v1/presensi'), 'leaderboard' => rest_url('assie4/v1/leaderboard') ] ); ?>;
function apiUrl(endpoint, params = {}) {
  const url = new URL(REST_ENDPOINTS[endpoint], window.location.href);
  Object.entries(params).forEach(([key, value]) => url.searchParams.set(key, value));
  return url.href;
}
const numberFormat = new Intl.NumberFormat('id-ID');
function validCount(value) {
  return value !== null && value !== undefined && value !== '' && Number.isFinite(Number(value)) && Number(value) >= 0;
}
async function fetchLeaderboard() {
  try {
    const res = await fetch(apiUrl('leaderboard', {limit:3}), { headers:{'X-WP-Nonce':NONCE} });
    const data = await res.json();
    if (!res.ok || !Array.isArray(data.leaderboard) || !validCount(data.total_today)) throw new Error('Invalid leaderboard');
    renderLeaderboard(data);
  } catch(e) {
    document.getElementById('lbTotalBadge').textContent = '—';
    document.getElementById('lbDate').textContent = 'Ringkasan harian belum tersedia';
    document.getElementById('leaderboardList').innerHTML = '<div class="empty-state">Data belum dapat dimuat. Coba muat ulang halaman.</div>';
  }
}
function renderLeaderboard(data) {
  const list = document.getElementById('leaderboardList');
  const date = new Date(data.date + 'T00:00:00');
  document.getElementById('lbDate').textContent = Number.isNaN(date.getTime()) ? 'Peringkat kunjungan hari ini' : date.toLocaleDateString('id-ID', {weekday:'long', day:'numeric', month:'long', year:'numeric'});
  document.getElementById('lbTotalBadge').textContent = numberFormat.format(Number(data.total_today));
  const lb = data.leaderboard.filter(item => validCount(item.total) && Number(item.total) > 0).slice(0,3);
  if (!lb.length) {
    list.innerHTML = '<div class="empty-state">Belum ada kunjungan hari ini.<br>Peringkat akan muncul setelah presensi pertama.</div>';
    return;
  }
  const max = Math.max(...lb.map(item => Number(item.total)), 1);
  list.innerHTML = lb.map((item, index) => {
    const details = boothInfo(item.booth);
    const name = details ? details.name : boothShortLabel(item.booth);
    const width = Math.max(2, Math.round(Number(item.total) / max * 100));
    return `<div class="rank-row">
      <span class="rank-position">${String(index + 1).padStart(2,'0')}</span>
      <div><p class="rank-name">${esc(name)}</p><span class="rank-code">${esc(boothShortLabel(item.booth))}</span><div class="rank-bar" aria-hidden="true"><span style="width:${width}%"></span></div></div>
      <div class="rank-count">${numberFormat.format(Number(item.total))}<small>kunjungan</small></div>
    </div>`;
  }).join('');
}

const SELECT = document.getElementById('boothSelect');
const PICKER = document.getElementById('boothPicker');
const PICKER_TRIGGER = document.getElementById('pickerTrigger');
const PICKER_PANEL = document.getElementById('pickerPanel');
const PICKER_SEARCH = document.getElementById('pickerSearch');
const PICKER_OPTIONS = document.getElementById('pickerOptions');
for (let i = 1; i <= 106; i++) {
  const opt = document.createElement('option');
  opt.value = i;
  opt.textContent = boothLabel(i);
  SELECT.appendChild(opt);
}

function renderPickerOptions(query = '') {
  const needle = query.trim().toLocaleLowerCase('id');
  const fragment = document.createDocumentFragment();
  let count = 0;
  for (let i = 1; i <= 106; i++) {
    const details = boothInfo(i);
    if (!details) continue;
    const searchText = `${i} ${String(i).padStart(3, '0')} ${details.code} ${details.area} ${details.name}`.toLocaleLowerCase('id');
    if (needle && !searchText.includes(needle)) continue;
    const option = document.createElement('button');
    option.type = 'button';
    option.className = 'picker-option';
    option.dataset.booth = String(i);
    option.setAttribute('aria-current', String(SELECT.value === String(i)));
    const code = document.createElement('span');
    code.className = 'picker-option-code';
    code.textContent = details.code;
    const content = document.createElement('span');
    content.className = 'picker-option-text';
    const name = document.createElement('strong');
    name.textContent = details.name;
    const meta = document.createElement('small');
    meta.textContent = `Booth ${String(i).padStart(3, '0')} · ${details.area}`;
    content.append(name, meta);
    option.append(code, content);
    fragment.appendChild(option);
    count++;
  }
  PICKER_OPTIONS.replaceChildren(fragment);
  document.getElementById('pickerEmpty').hidden = count !== 0;
}

function closePicker() {
  PICKER_PANEL.hidden = true;
  PICKER_TRIGGER.setAttribute('aria-expanded', 'false');
}

PICKER_TRIGGER.addEventListener('click', () => {
  if (!PICKER_PANEL.hidden) { closePicker(); return; }
  PICKER_SEARCH.value = '';
  renderPickerOptions();
  PICKER_PANEL.hidden = false;
  PICKER_TRIGGER.setAttribute('aria-expanded', 'true');
  PICKER_SEARCH.focus();
});
PICKER_SEARCH.addEventListener('input', () => renderPickerOptions(PICKER_SEARCH.value));
PICKER_SEARCH.addEventListener('keydown', event => {
  if (event.key === 'ArrowDown') {
    event.preventDefault();
    PICKER_OPTIONS.querySelector('button')?.focus();
  }
});
PICKER_OPTIONS.addEventListener('click', event => {
  const option = event.target.closest('button[data-booth]');
  if (!option) return;
  SELECT.value = option.dataset.booth;
  closePicker();
  PICKER_TRIGGER.focus();
  onBoothChange();
});
PICKER_OPTIONS.addEventListener('keydown', event => {
  if (event.key !== 'ArrowDown' && event.key !== 'ArrowUp') return;
  event.preventDefault();
  const options = [...PICKER_OPTIONS.querySelectorAll('button')];
  const current = options.indexOf(document.activeElement);
  options[Math.max(0, Math.min(options.length - 1, current + (event.key === 'ArrowDown' ? 1 : -1)))]?.focus();
});
document.addEventListener('keydown', event => {
  if (event.key === 'Escape' && !PICKER_PANEL.hidden) { closePicker(); PICKER_TRIGGER.focus(); }
});
document.addEventListener('pointerdown', event => {
  if (!PICKER.contains(event.target)) closePicker();
});

// ─── ON BOOTH CHANGE ───
function onBoothChange() {
  const num = parseInt(SELECT.value);
  const details = boothInfo(num);
  document.getElementById('pickerCode').textContent = details ? details.code : String(num).padStart(3, '0');
  document.getElementById('pickerName').textContent = details ? details.name : 'Booth belum terdaftar';
  document.getElementById('pickerMeta').textContent = details ? `Booth ${String(num).padStart(3, '0')} · ${details.area}` : `Booth ${String(num).padStart(3, '0')}`;
  document.getElementById('recentLabel').textContent = boothShortLabel(num);
  document.getElementById('badgeCount').textContent = 'Memuat…';
  document.getElementById('recentList').innerHTML = '<div class="empty-state">Memuat data…</div>';
  clearForm();
  hideToast();
  fetchBoothData(num);
}

// ─── FETCH DATA BOOTH DARI REST API ───
async function fetchBoothData(booth) {
  try {
    const res = await fetch(apiUrl('presensi', {booth, limit:5}), {
      headers: { 'X-WP-Nonce': NONCE }
    });
    const data = await res.json();

    if (!res.ok || !validCount(data.total) || !Array.isArray(data.entries)) throw new Error('Invalid booth response');
    if (Number(SELECT.value) !== booth) return;
    document.getElementById('badgeCount').textContent = numberFormat.format(Number(data.total)) + ' kunjungan';
    renderRecent(data.entries || []);
  } catch(e) {
    if (Number(SELECT.value) !== booth) return;
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
  if (document.getElementById('btnSubmit').disabled) return;
  if (!validate()) {
    const btn = document.getElementById('btnSubmit');
    btn.classList.remove('is-invalid');
    void btn.offsetWidth;
    btn.classList.add('is-invalid');
    document.querySelector('.field input.invalid')?.focus();
    return;
  }

  const btn  = document.getElementById('btnSubmit');
  btn.disabled = true;
  btn.classList.remove('is-invalid', 'is-success');
  btn.innerHTML = '<span class="spinner"></span>Menyimpan…';
  hideToast();
  let saved = false;

  const booth    = parseInt(SELECT.value);
  const nama     = document.getElementById('nama').value.trim();
  const instansi = document.getElementById('instansi').value.trim();
  const telp     = document.getElementById('telp').value.trim();

  try {
    const res = await fetch(apiUrl('presensi'), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': NONCE,
      },
      body: JSON.stringify({ booth, nama, instansi, telp }),
    });

    const data = await res.json();

    if (res.ok && data.success) {
      saved = true;
      showToast('success', '✅ Presensi berhasil dicatat! Selamat menikmati pameran.');
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
    if (saved) {
      btn.classList.add('is-success');
      btn.textContent = 'Berhasil dicatat ✓';
      window.setTimeout(() => {
        btn.classList.remove('is-success');
        btn.textContent = 'Catat kehadiran →';
        btn.disabled = false;
      }, 1700);
    } else {
      btn.disabled = false;
      btn.textContent = 'Catat kehadiran →';
    }
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
document.getElementById('attendanceForm').addEventListener('submit', event => {
  event.preventDefault();
  submitPresensi();
});
onBoothChange();
fetchLeaderboard();
</script>

<?php wp_footer(); ?>
</body>
</html>
