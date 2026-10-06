<?php
/**
 * Template konten — ASSIE IV Pameran Digital v2.6.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$a4_info_data = get_option( ASSIE4_OPT_INFO, assie4_default_info() );
$a4_info_data = is_array($a4_info_data) ? $a4_info_data : assie4_default_info();
$a4_brand_logo_url = !empty($a4_info_data['logo']) ? $a4_info_data['logo'] : (ASSIE4_PAMERAN_URL . 'assets/logo-assie4.png');
?>

<?php require __DIR__ . '/assie4-icons.php'; ?>

<!-- NAV -->
<nav class="a4-nav" id="a4Nav">
  <div class="a4-nav-logo">
    <a href="#home" onclick="a4GoTo('home')" class="a4-nav-logo-link" title="IM ASSIE IV 2026">
      <img src="<?php echo esc_url( $a4_brand_logo_url ); ?>" alt="IM ASSIE IV 2026" class="a4-nav-logo-img" decoding="async">
    </a>
  </div>
  <button type="button" class="a4-menu-toggle" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="a4NavMenu" onclick="a4ToggleMenu()"><?php echo $a4_ui_icon('menu'); ?></button>
  <div class="a4-nav-menu" id="a4NavMenu">
    <button class="a4-nb on" onclick="a4GoTo('home')">Beranda</button>
    <button class="a4-nb" onclick="a4GoTo('rundown')">Rundown</button>
    <button class="a4-nb" onclick="a4GoTo('denah')">Denah</button>
    <button class="a4-nb" onclick="a4GoTo('berita')">Berita</button>
    <button class="a4-nb" onclick="a4GoTo('presensi')">Presensi</button>
    <a class="a4-nb a4-nb-tokoua" href="https://tokoua.unair.ac.id/" target="_blank" rel="noopener noreferrer"><?php echo $a4_ui_icon('bag'); ?> TokoUA</a>
  </div>
  <div class="a4-nav-edition">INDUSTRY MATCHING <span>2026</span></div>
</nav>

<!-- HERO SLIDER (mendukung gambar upload) -->
<section id="home" class="a4-hero" aria-label="Sorotan pameran" aria-roledescription="carousel">
  <div class="a4-sl-wrap" id="a4SlWrap"></div>
  <div class="a4-hero-caption">Dokumentasi kegiatan ASSIE</div>
  <div class="a4-sl-dots" id="a4SlDots" aria-label="Pilih sorotan"></div>
  <div class="a4-sl-arrows">
    <button class="a4-arr" aria-label="Sorotan sebelumnya" onclick="a4SlMove(-1)">‹</button>
    <button class="a4-arr a4-pause-btn" id="a4SlidePause" aria-label="Jeda pergantian slide" aria-pressed="false" onclick="a4ToggleSlides()"><?php echo $a4_ui_icon('pause'); ?></button>
    <button class="a4-arr" aria-label="Sorotan berikutnya" onclick="a4SlMove(1)">›</button>
  </div>
</section>

<!-- TICKER -->
<div class="a4-ticker"><div class="a4-ticker-inner" id="a4Ticker"></div></div>

<!-- INFO STRIP -->
<div class="a4-istrip">
  <div class="a4-iitem"><span class="a4-iico"><?php echo $a4_ui_icon('calendar'); ?></span><div><div class="a4-ilbl">Tanggal</div><div class="a4-ival" id="a4iDate">—</div></div></div>
  <div class="a4-iitem"><span class="a4-iico"><?php echo $a4_ui_icon('pin'); ?></span><div><div class="a4-ilbl">Lokasi</div><div class="a4-ival" id="a4iLoc">—</div></div></div>
  <div class="a4-iitem"><span class="a4-iico"><?php echo $a4_ui_icon('building'); ?></span><div><div class="a4-ilbl">Penyelenggara</div><div class="a4-ival" id="a4iOrg">—</div></div></div>
  <div class="a4-iitem"><span class="a4-iico"><?php echo $a4_ui_icon('clock'); ?></span><div><div class="a4-ilbl">Jam Operasional</div><div class="a4-ival" id="a4iTime">—</div></div></div>
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
    <div class="a4-day-tabs" id="a4DayTabs" role="group" aria-label="Pilih tanggal rundown"></div>
    <div class="a4-rundown-dayline" id="a4RundownDayIntro" aria-live="polite"></div>
    <div class="a4-timeline" id="a4Timeline"></div>
  </div>
</section>


<!-- DENAH — Layout per area + SVG interaktif -->
<section id="denah" class="a4-sec-bg">
  <div class="a4-sec">
    <span class="a4-sec-tag">Denah</span>
    <h2 class="a4-sec-h">Layout Booth Pameran</h2>
    <p class="a4-sec-sub">Pilih area sesuai kode booth pada denah. Klik booth untuk melihat tenant, atau Main Stage untuk jadwal acara.</p>

    <!-- Area A-H mengikuti sheet Ploting Booth. -->
    <div class="a4-denah-filters" id="a4DenahFilters"></div>

    <!-- Denah venue asli + overlay SVG interaktif -->
    <div class="a4-map-container">
      <div class="a4-map-controls">
        <div class="a4-map-zoom">
          <button class="a4-mz-btn" type="button" aria-label="Perbesar denah" title="Perbesar denah" onclick="a4ZoomMap(1.25)">+</button>
          <button class="a4-mz-btn" type="button" aria-label="Perkecil denah" title="Perkecil denah" onclick="a4ZoomMap(0.8)">−</button>
          <button class="a4-mz-btn" type="button" aria-label="Atur ulang pembesaran" title="Atur ulang pembesaran" onclick="a4ResetZoom()">⊙</button>
          <button class="a4-map-stage-link" type="button" onclick="a4LocateStage()" title="Temukan Main Stage pada denah"><?php echo $a4_ui_icon('pin'); ?> Main Stage</button>
        </div>
        <div class="a4-map-legend" id="a4MapLegend" aria-live="polite"></div>
      </div>
      <div class="a4-map-svg-wrap" id="a4MapWrap" aria-label="Denah booth pameran interaktif">
        <div class="a4-map-stage" id="a4MapStage">
          <img id="a4FloorMapImage" src="" alt="Denah venue IM ASSIE IV 2026 di Grand City Atrium; Main Stage berada di bawah tengah, di samping Area C">
          <svg id="a4FloorMap" viewBox="0 0 1820 1024" xmlns="http://www.w3.org/2000/svg" role="group" aria-label="Hotspot booth dan Main Stage"></svg>
        </div>
      </div>
      <p class="a4-map-note"><strong>Main Stage</strong> berada di bawah tengah, di samping Area C dan menghadap area tempat duduk. Klik penanda emas untuk melihat jadwal acara.</p>
      <div class="a4-mobile-booth-list" id="a4MobileBoothList" aria-live="polite"></div>
    </div>
    <button type="button" class="a4-denah-pasinbis" onclick="a4BoothClickPasinbis()"><?php echo $a4_ui_icon('building'); ?> PASINBIS UNAIR <span>• Info penyelenggara</span></button>

    <!-- Gambar denah upload (jika ada) -->
    <div class="a4-denah-imgs" id="a4DenahImgs" style="display:none">
      <h3 class="a4-denah-imgs-title"><?php echo $a4_ui_icon('camera'); ?> Foto Denah</h3>
      <div class="a4-denah-gallery" id="a4DenahGallery"></div>
    </div>

    <!-- DAFTAR TENANT / BOOTH — dipindah dari section Tenant -->
    <div class="a4-tenant-section" id="tenant-directory" style="margin-top:24px">
      <div class="a4-tenant-section-head">
        <div>
          <span class="a4-tenant-eyebrow">Peserta pameran</span>
          <h3 class="a4-tenant-section-title">Daftar Booth &amp; Tenant</h3>
          <p class="a4-tenant-section-sub">Pilih nama tenant untuk melihat profil dan kontaknya.</p>
        </div>
        <a href="https://tokoua.unair.ac.id/" target="_blank" rel="noopener noreferrer" class="a4-tenant-shop">Belanja di TokoUA <span aria-hidden="true">↗</span></a>
      </div>
      <div class="a4-tenant-tools">
        <div class="a4-area-filters" id="a4AreaFilters"></div>
        <label class="a4-tenant-search"><span class="screen-reader-text">Cari tenant</span><input type="search" placeholder="Cari tenant" oninput="a4SearchTenants(this.value)" autocomplete="off"></label>
      </div>
      <div class="a4-tenant-count" id="a4TenantCount" aria-live="polite"></div>
      <div class="a4-tenant-grid" id="a4TenantGrid"></div>
      <button type="button" class="a4-tenant-more" id="a4TenantMore" onclick="a4ToggleTenants()" hidden></button>
    </div>
  </div>
</section>

<!-- BERITA -->
<section id="berita" class="a4-sec">
  <span class="a4-sec-tag">Berita</span>
  <h2 class="a4-sec-h">Berita IM ASSIE IV 2026</h2>
  <p class="a4-sec-sub">Liputan dan informasi terbaru seputar Airlangga Startup Summit & Innovation Expo 2026.</p>
  <div class="a4-news-grid" id="a4NewsGrid">
    <div class="a4-news-loading">Memuat berita…</div>
  </div>
  <div style="text-align:center;margin-top:28px">
    <a href="https://pasinbis.unair.ac.id/category/assie-4-tahun-2026/" target="_blank" class="a4-btn-out">Lihat Semua Berita →</a>
  </div>
</section>

<!-- PRESENSI -->
<section id="presensi" class="a4-sec">
  <span class="a4-sec-tag">Presensi</span>
  <h2 class="a4-sec-h">Presensi Pengunjung</h2>
  <p class="a4-sec-sub">Temukan booth pilihan Anda, lalu catat kunjungan melalui formulir presensi.</p>
  <div class="a4-pres-box">
    <div class="a4-pres-left">
      <h3>Daftar Presensi Sekarang</h3>
      <p>Pilih tenant yang Anda kunjungi dan isi data untuk mencatat kehadiran.</p>
      <a href="<?php echo esc_url( home_url('/presensi-booth-assie4/') ); ?>" class="a4-btn-gold">Buka Form Presensi →</a>
      <a href="#denah" onclick="a4GoTo('denah')" class="a4-btn-out">Lihat Denah Booth</a>
    </div>
    <div class="a4-pres-right">
      <h3>Top 3 Booth Hari Ini</h3>
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
        <span class="a4-tku-logo"><?php echo $a4_ui_icon('bag'); ?></span>
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
          <div class="a4-tku-domain"><?php echo $a4_ui_icon('globe'); ?> tokoua.unair.ac.id</div>
          <div class="a4-tku-tagline">Platform Belanja Resmi<br><strong>Universitas Airlangga</strong></div>
          <div class="a4-tku-url-bar">
            <span class="a4-tku-lock"><?php echo $a4_ui_icon('lock'); ?></span>
            <span>https://tokoua.unair.ac.id</span>
          </div>
        </div>
      </div>

      <!-- Info -->
      <div class="a4-tku-info">
        <p class="a4-tku-desc">TokoUA adalah platform belanja resmi Universitas Airlangga — temukan produk inovatif dari tenant &amp; startup peserta pameran IM ASSIE IV 2026 dan dukung ekosistem wirausaha Airlangga.</p>
        <div class="a4-tku-badges">
          <div class="a4-tku-badge"><?php echo $a4_ui_icon('check'); ?> Platform Resmi UNAIR</div>
          <div class="a4-tku-badge"><?php echo $a4_ui_icon('spark'); ?> Produk Startup Lokal</div>
          <div class="a4-tku-badge"><?php echo $a4_ui_icon('graduate'); ?> Karya Mahasiswa</div>
          <div class="a4-tku-badge"><?php echo $a4_ui_icon('lock'); ?> Transaksi Aman</div>
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
  <div class="a4-mbox" role="dialog" aria-modal="true" aria-label="Detail booth">
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
  <div class="a4-footer-logo-wrap" style="margin-bottom:16px">
    <img src="<?php echo esc_url( $a4_brand_logo_url ); ?>" alt="IM ASSIE IV 2026" class="a4-footer-logo-img" decoding="async">
  </div>
  <p>© 2026 <strong>PASINBIS Universitas Airlangga</strong> · IM ASSIE IV 2026</p>
  <p class="a4-footer-sub">Airlangga Startup Summit &amp; Innovation Expo · Grand City Atrium, Surabaya</p>
</footer>
