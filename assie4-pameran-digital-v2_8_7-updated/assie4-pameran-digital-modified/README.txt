===================================================================
  ASSIE IV — PAMERAN DIGITAL
  WordPress Plugin v2.8.1
  PASINBIS Universitas Airlangga
===================================================================

== DESKRIPSI ==

Plugin ini mengubah tampilan pameran digital ASSIE IV 2026 menjadi
halaman WordPress full-featured dengan:

  ✅ Hero slider otomatis dengan background image support
  ✅ Ticker berita berjalan
  ✅ Strip informasi acara lengkap
  ✅ Rundown acara per hari (3 hari)
  ✅ Grid tenant dengan filter area (A–E)
  ✅ Denah interaktif SVG dengan zoom & tooltip
  ✅ Modal detail booth lengkap
  ✅ Gallery gambar denah dengan lightbox
  ✅ Link presensi terintegrasi
  ✅ Booth PASINBIS khusus dengan emas border
  ✅ Responsive mobile-first design
  ✅ Admin dashboard lengkap untuk manage semua konten
  ✅ Export/Import backup data JSON
  ✅ Full-page mode (tanpa header/footer tema)

== STRUKTUR FILE ==

  assie4-pameran-digital/
  ├── assie4-pameran-digital.php     ← Plugin utama
  ├── README.txt                     ← File ini
  ├── admin/
  │   └── assie4-admin-settings.php  ← Admin pages & functionality
  ├── assets/
  │   ├── assie4-pameran.css         ← Frontend styling
  │   ├── assie4-pameran.js          ← Frontend logic & interaktif
  │   └── assie4-admin.css           ← Admin panel styling
  └── templates/
      ├── assie4-pameran-template.php   ← HTML content shortcode
      └── assie4-pameran-fullpage.php   ← Full-page wrapper

== REQUIREMENTS ==

  - WordPress: 5.9 atau lebih tinggi
  - PHP: 7.4 atau lebih tinggi
  - Web Server: Apache 2.4+ / Nginx 1.20+
  - MySQL/MariaDB: 5.7+ / 10.3+

== CARA INSTALASI ==

METODE 1: FTP (Recommended)
1. Download & extract plugin
2. Upload folder assie4-pameran-digital/ ke /wp-content/plugins/
3. WordPress Admin → Plugins → Activate "ASSIE IV — Pameran Digital"

METODE 2: WordPress Admin Upload
1. WordPress Admin → Plugins → Add New
2. Click "Upload Plugin" → Select plugin ZIP file
3. Click "Install Now" → Activate

== SETUP AWAL ==

Setelah aktivasi:
1. Admin Menu → ASSIE IV Pameran → Dashboard
2. Setup konten melalui submenu:
   - Info Acara (tanggal, lokasi, jam)
   - Hero Slider (banner/slide)
   - Ticker (teks berjalan)
   - Rundown (jadwal acara)
   - Kelola Tenant (booth/booth)
   - Denah & Galeri (foto)
   - Booth PASINBIS (info booth)
   - Export/Reset (backup data)

3. Kunjungi /pameran-assie4/ untuk lihat hasilnya

== TROUBLESHOOTING ==

ERROR: "TypeError: $(...).pointer is not a function"
SOLUSI: 
  ✓ Clear browser cache (Ctrl+Shift+Delete)
  ✓ Upload via FTP method instead of WordPress admin
  ✓ Check PHP version (min 7.4)
  ✓ Deactivate other plugins temporarily
  Lihat UPLOAD_GUIDE.md untuk detail lengkap

UPLOAD FAILS:
  ✓ Increase PHP memory limit di wp-config.php:
    define('WP_MEMORY_LIMIT', '256M');
    define('WP_MAX_MEMORY_LIMIT', '512M');
  ✓ Use FTP upload instead
  ✓ Check error log: /wp-content/debug.log

HALAMAN TIDAK MUNCUL:
  ✓ Check plugin status di WordPress Admin → Plugins
  ✓ Verify plugin aktif (bukan deactivated/errors)
  ✓ Check halaman /pameran-assie4/ exist
  ✓ Clear WordPress cache jika ada cache plugin

== SHORTCODES ==

[assie4_pameran]
  → Render full pameran page
  → Otomatis ditambah ke halaman saat plugin activated

[assie4_berita jumlah="9" kolom="3" judul="Berita" cache="15"]
  → Render berita dari PASINBIS
  → jumlah: jumlah berita (1-20)
  → kolom: jumlah kolom (1-4)
  → judul: title berita section
  → cache: cache duration in minutes

== VERSION HISTORY ==

v2.8.7 (2026-06-11)
  - Fix JSON encoding error (pointer is not a function)
  - Fix: enqueue wp-pointer script di plugins.php (TypeError fix)
  - Fix: ganti error_handler workaround dengan admin_notice + transient
  - Fix: pointer is not a function saat aktivasi plugin
  - Improved data sanitization
  - Added error handling
  - Added compatibility checking
  - Better upload error prevention

v2.8.0 (2026-06-10)
  - Production release
  - Full pameran digital interface
  - Admin dashboard
  - Export/import functionality
  - Responsive design

== SUPPORT ==

Untuk bantuan:
1. Check dokumentasi: UPLOAD_GUIDE.md, CHANGELOG.md, QUICK_START.md
2. Enable WP_DEBUG untuk error logging
3. Contact PASINBIS support team

== CREDIT ==

Developer: PASINBIS Universitas Airlangga
Design: PASINBIS UI/UX Team
License: GPL-2.0-or-later

===================================================================
Terbaru: 2026-06-11 | Versi: 2.8.1
===================================================================

== INTEGRASI DENGAN PLUGIN PRESENSI ==

Pasang juga plugin assie4-presensi (dari folder assie4-presensi/).
Plugin pameran digital otomatis:
  • Menampilkan link ke /presensi-booth-assie4/ di setiap booth
  • Memanggil AJAX untuk statistik pengunjung real-time
  • Menampilkan leaderboard booth terpopuler

== CARA PAKAI SHORTCODE MANUAL ==

Jika ingin memasang di halaman lain, gunakan shortcode:
  [assie4_pameran]

== MENGUBAH DATA TENANT / RUNDOWN ==

Edit file: assets/assie4-pameran.js
Cari blok: var DATA = { ... }

  • DATA.tenants     — daftar 120 tenant
  • DATA.rundown     — jadwal rundown 3 hari
  • DATA.slides      — slide hero
  • DATA.ticker      — teks berjalan
  • DATA.info        — info tanggal & lokasi

Tambah logo tenant:
  logo: 'https://domain.com/logo-tenant.png'

== FULL-PAGE MODE ==

Plugin secara default menggunakan template full-page (tanpa
header/footer tema). Jika ingin menggunakan tema normal:

Buka assie4-pameran-digital.php, cari fungsi:
  assie4_pameran_template_override()

Dan hapus atau comment-out dengan /* ... */ seluruh fungsi tersebut.

== ADMIN ==

WordPress Admin → Menu "ASSIE IV Pameran":
  • URL halaman pameran
  • Shortcode
  • Versi plugin

== REQUIREMENTS ==

  • WordPress: 5.8+
  • PHP: 7.4+
  • Plugin presensi: assie4-presensi (opsional, untuk statistik live)

== UNINSTALL ==

Nonaktifkan plugin dari menu Plugins WordPress.
Halaman /pameran-assie4/ TIDAK otomatis terhapus — hapus manual
dari WordPress → Halaman jika diperlukan.
