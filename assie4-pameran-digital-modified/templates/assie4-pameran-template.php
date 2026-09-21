<?php
/**
 * Template konten — ASSIE IV Pameran Digital v2.6.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<!-- NAV -->
<nav class="a4-nav" id="a4Nav">
  <div class="a4-nav-logo">ASSIE <span>IV</span></div>
  <div class="a4-nav-menu">
    <button class="a4-nb on" onclick="a4GoTo('home')">Beranda</button>
    <button class="a4-nb" onclick="a4GoTo('rundown')">Rundown</button>
    <button class="a4-nb" onclick="a4GoTo('denah')">Denah</button>
    <button class="a4-nb" onclick="a4GoTo('berita')">Berita</button>
    <button class="a4-nb" onclick="a4GoTo('presensi')">Presensi</button>
    <button class="a4-nb a4-nb-tokoua" onclick="a4OpenTokoUA()">🛒 TokoUA</button>
  </div>
  <div class="a4-live-pill"><span class="a4-pulse"></span><span id="a4Clock">Live</span></div>
</nav>

<!-- HERO SLIDER (mendukung gambar upload) -->
<section id="home" class="a4-hero">
  <div class="a4-sl-wrap" id="a4SlWrap"></div>
  <div class="a4-sl-dots" id="a4SlDots"></div>
  <div class="a4-sl-arrows">
    <button class="a4-arr" onclick="a4SlMove(-1)">‹</button>
    <button class="a4-arr" onclick="a4SlMove(1)">›</button>
  </div>
</section>

<!-- TICKER -->
<div class="a4-ticker"><div class="a4-ticker-inner" id="a4Ticker"></div></div>

<!-- INFO STRIP -->
<div class="a4-istrip">
  <div class="a4-iitem"><span class="a4-iico">📅</span><div><div class="a4-ilbl">Tanggal</div><div class="a4-ival" id="a4iDate">—</div></div></div>
  <div class="a4-iitem"><span class="a4-iico">📍</span><div><div class="a4-ilbl">Lokasi</div><div class="a4-ival" id="a4iLoc">—</div></div></div>
  <div class="a4-iitem"><span class="a4-iico">🏛️</span><div><div class="a4-ilbl">Penyelenggara</div><div class="a4-ival" id="a4iOrg">—</div></div></div>
  <div class="a4-iitem"><span class="a4-iico">🕐</span><div><div class="a4-ilbl">Jam Operasional</div><div class="a4-ival" id="a4iTime">—</div></div></div>
</div>

<!-- STATS -->
<div class="a4-sec" style="padding-bottom:0">
  <div class="a4-stats">
    <div class="a4-st"><span class="a4-st-n" id="a4stTotal">0</span><span class="a4-st-l">Total Booth</span></div>
    <div class="a4-st"><span class="a4-st-n" id="a4stTenant">0</span><span class="a4-st-l">Tenant Aktif</span></div>
    <div class="a4-st"><span class="a4-st-n" id="a4stToday">0</span><span class="a4-st-l">Pengunjung Hari Ini</span></div>
    <div class="a4-st"><span class="a4-st-n" id="a4stAll">0</span><span class="a4-st-l">Total Pengunjung</span></div>
  </div>
</div>

<!-- RUNDOWN -->
<section id="rundown" class="a4-sec-bg">
  <div class="a4-sec">
    <span class="a4-sec-tag">Agenda</span>
    <h2 class="a4-sec-h">Rundown Acara</h2>
    <p class="a4-sec-sub">Jadwal lengkap kegiatan selama 3 hari pameran berlangsung.</p>
    <div class="a4-day-tabs" id="a4DayTabs"></div>
    <div class="a4-timeline" id="a4Timeline"></div>
  </div>
</section>


<!-- DENAH — Layout per area + SVG interaktif -->
<section id="denah" class="a4-sec-bg">
  <div class="a4-sec">
    <span class="a4-sec-tag">Denah</span>
    <h2 class="a4-sec-h">Layout Booth Pameran</h2>
    <p class="a4-sec-sub">Pilih klaster untuk melihat booth. Klik booth untuk detail tenant, klik Main Stage untuk jadwal acara.</p>

    <!-- Filter klaster denah. Filter Area A-E pada daftar tenant tetap terpisah. -->
    <div class="a4-denah-filters" id="a4DenahFilters"></div>

    <!-- Denah venue asli + overlay SVG interaktif -->
    <div class="a4-map-container">
      <div class="a4-map-controls">
        <div class="a4-map-zoom">
          <button class="a4-mz-btn" onclick="a4ZoomMap(1.25)">+</button>
          <button class="a4-mz-btn" onclick="a4ZoomMap(0.8)">−</button>
          <button class="a4-mz-btn" onclick="a4ResetZoom()">⊙</button>
        </div>
        <div class="a4-map-legend" id="a4MapLegend"></div>
      </div>
      <div class="a4-map-svg-wrap" id="a4MapWrap" aria-label="Denah booth pameran interaktif">
        <div class="a4-map-stage" id="a4MapStage">
          <img id="a4FloorMapImage" src="" alt="Denah venue ASSIE IV di Grand City Convention Hall">
          <svg id="a4FloorMap" viewBox="0 0 1820 1024" xmlns="http://www.w3.org/2000/svg" role="group" aria-label="Hotspot booth dan Main Stage"></svg>
        </div>
      </div>
      <div class="a4-mobile-booth-list" id="a4MobileBoothList" aria-live="polite"></div>
    </div>
    <button type="button" class="a4-denah-pasinbis" onclick="a4BoothClickPasinbis()">🏛️ PASINBIS UNAIR <span>• Info penyelenggara</span></button>

    <!-- Gambar denah upload (jika ada) -->
    <div class="a4-denah-imgs" id="a4DenahImgs" style="display:none">
      <h3 class="a4-denah-imgs-title">📸 Foto Denah</h3>
      <div class="a4-denah-gallery" id="a4DenahGallery"></div>
    </div>

    <!-- DAFTAR TENANT / BOOTH — dipindah dari section Tenant -->
    <div class="a4-tenant-section" style="margin-top:40px">
      <div class="a4-tenant-section-head">
        <h3 class="a4-tenant-section-title">Daftar Booth &amp; Tenant</h3>
        <p class="a4-tenant-section-sub">Filter per area lalu klik kartu untuk melihat detail booth.</p>
      </div>
      <div class="a4-ss-banner">
        <span class="a4-ss-text">🛒 Beli produk tenant secara online melalui <strong>TokoUA Universitas Airlangga</strong></span>
        <a href="https://tokoua.unair.ac.id/" target="_blank" class="a4-btn-gold">Kunjungi TokoUA →</a>
      </div>
      <div class="a4-area-filters" id="a4AreaFilters"></div>
      <div class="a4-tenant-grid" id="a4TenantGrid"></div>
    </div>
  </div>
</section>

<!-- BERITA -->
<section id="berita" class="a4-sec">
  <span class="a4-sec-tag">Berita</span>
  <h2 class="a4-sec-h">Berita ASSIE IV 2026</h2>
  <p class="a4-sec-sub">Liputan dan informasi terbaru seputar Airlangga Startup Summit & Innovation Expo 2026.</p>
  <div class="a4-news-grid" id="a4NewsGrid">
    <div class="a4-news-loading">⏳ Memuat berita…</div>
  </div>
  <div style="text-align:center;margin-top:28px">
    <a href="https://pasinbis.unair.ac.id/category/assie-4-tahun-2026/" target="_blank" class="a4-btn-out">Lihat Semua Berita →</a>
  </div>
</section>

<!-- PRESENSI -->
<section id="presensi" class="a4-sec">
  <span class="a4-sec-tag">Presensi</span>
  <h2 class="a4-sec-h">Presensi Pengunjung</h2>
  <p class="a4-sec-sub">Catat kehadiran Anda di setiap booth. Tersedia di dalam area Grand City Surabaya.</p>
  <div class="a4-pres-box">
    <div class="a4-pres-left">
      <h3>Daftar Presensi Sekarang</h3>
      <p>Scan atau klik tombol di bawah untuk mencatat kehadiran di booth favorit Anda.</p>
      <a href="<?php echo esc_url( home_url('/presensi-booth-assie4/') ); ?>" class="a4-btn-gold">Buka Form Presensi →</a>
      <a href="#denah" onclick="a4GoTo('denah')" class="a4-btn-out">Lihat Denah Booth</a>
    </div>
    <div class="a4-pres-right">
      <h3>Top Booth Hari Ini</h3>
      <div class="a4-lb-grid" id="a4LbGrid"><p class="a4-muted-note">Memuat data…</p></div>
    </div>
  </div>
</section>

<!-- TOKOUA POPUP MODAL -->
<div class="a4-modal a4-tokoua-modal" id="a4TokoUAModal" onclick="if(event.target===this)a4CloseTokoUA()">
  <div class="a4-tku-box">

    <!-- Header -->
    <div class="a4-tku-head">
      <div class="a4-tku-brand">
        <span class="a4-tku-logo">🛒</span>
        <div>
          <div class="a4-tku-title">TokoUA</div>
          <div class="a4-tku-sub">Universitas Airlangga Official Store</div>
        </div>
      </div>
      <button class="a4-tku-close" onclick="a4CloseTokoUA()" aria-label="Tutup">✕</button>
    </div>

    <!-- Body -->
    <div class="a4-tku-body">

      <!-- Visual card -->
      <div class="a4-tku-visual">
        <div class="a4-tku-visual-inner">
          <div class="a4-tku-domain">🌐 tokoua.unair.ac.id</div>
          <div class="a4-tku-tagline">Platform Belanja Resmi<br><strong>Universitas Airlangga</strong></div>
          <div class="a4-tku-url-bar">
            <span class="a4-tku-lock">🔒</span>
            <span>https://tokoua.unair.ac.id</span>
          </div>
        </div>
      </div>

      <!-- Info -->
      <div class="a4-tku-info">
        <p class="a4-tku-desc">TokoUA adalah platform belanja resmi Universitas Airlangga — temukan produk inovatif dari tenant &amp; startup peserta pameran ASSIE IV 2026 dan dukung ekosistem wirausaha Airlangga.</p>
        <div class="a4-tku-badges">
          <div class="a4-tku-badge">✅ Platform Resmi UNAIR</div>
          <div class="a4-tku-badge">🚀 Produk Startup Lokal</div>
          <div class="a4-tku-badge">🎓 Karya Mahasiswa</div>
          <div class="a4-tku-badge">🔒 Transaksi Aman</div>
        </div>
      </div>
    </div>

    <!-- Footer CTA -->
    <div class="a4-tku-footer">
      <a href="https://tokoua.unair.ac.id/" target="_blank" rel="noopener noreferrer"
         class="a4-btn-gold a4-tku-cta" onclick="a4CloseTokoUA()">
        Buka TokoUA ↗
      </a>
      <button onclick="a4CloseTokoUA()" class="a4-btn-out">Tutup</button>
    </div>

  </div>
</div>


<!-- TOOLTIP -->
<div id="a4Tooltip" class="a4-tooltip"></div>

<!-- BOOTH / STAGE MODAL -->
<div class="a4-modal" id="a4Modal" onclick="if(event.target===this)a4CloseModal()">
  <div class="a4-mbox">
    <div class="a4-mbox-head" id="a4ModalHead"></div>
    <div class="a4-mbox-body" id="a4ModalBody"></div>
  </div>
</div>

<!-- LIGHTBOX (untuk gambar denah) -->
<div class="a4-lightbox" id="a4Lightbox" onclick="a4CloseLightbox()">
  <button class="a4-lb-close" onclick="a4CloseLightbox()">✕</button>
  <button class="a4-lb-prev" id="a4LbPrev" onclick="event.stopPropagation();a4LbNav(-1)">‹</button>
  <button class="a4-lb-next" id="a4LbNext" onclick="event.stopPropagation();a4LbNav(1)">›</button>
  <div class="a4-lb-wrap" onclick="event.stopPropagation()">
    <img id="a4LbImg" src="" alt="">
    <div class="a4-lb-caption" id="a4LbCaption"></div>
  </div>
</div>

<!-- FOOTER -->
<footer class="a4-footer">
  <p>© 2026 <strong>PASINBIS Universitas Airlangga</strong> · ASSIE IV 2026</p>
  <p class="a4-footer-sub">Airlangga Startup Summit &amp; Innovation Expo · Grand City Convention Hall, Surabaya</p>
</footer>
