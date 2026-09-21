=== ASSIE IV — Presensi Booth ===
Versi: 1.0.0
Requires WordPress: 5.8+
Requires PHP: 7.4+

== CARA INSTALASI ==

1. Upload folder `assie4-presensi` ke:
   /wp-content/plugins/assie4-presensi/

   Pastikan struktur folder seperti ini:
   wp-content/
   └── plugins/
       └── assie4-presensi/
           ├── assie4-presensi.php        ← Plugin utama
           ├── README.txt                 ← File ini
           └── templates/
               └── assie4-presensi-template.php   ← Template halaman

2. Login ke WordPress Admin → Plugins → Aktifkan "ASSIE IV — Presensi Booth"

3. Saat aktivasi, plugin akan otomatis:
   ✅ Membuat tabel database `wp_assie4_presensi`
   ✅ Membuat halaman WordPress bernama "Presensi Booth — ASSIE IV 2026"
      di URL: /presensi-booth-assie4/

4. Buka halaman tersebut → sistem presensi siap digunakan!

== HALAMAN ADMIN ==

Dashboard WordPress → Menu "ASSIE IV Presensi":
  • Melihat total pengunjung & statistik
  • Melihat 50 data presensi terbaru
  • Export semua data ke CSV (untuk Excel)
  • Tombol buka halaman presensi langsung

== FITUR ==

  ✅ 120 booth pameran
  ✅ Simpan ke database WordPress (bukan localStorage)
  ✅ Validasi nomor telepon
  ✅ Pencegahan duplikasi (1 nomor telp per booth per hari)
  ✅ Halaman full-page tanpa header/footer tema
  ✅ Daftar 5 presensi terakhir per booth (real-time dari DB)
  ✅ Admin panel dengan statistik
  ✅ Export CSV dengan BOM UTF-8 (aman untuk Excel)
  ✅ REST API: GET & POST /wp-json/assie4/v1/presensi

== CATATAN KEAMANAN ==

  • Semua input disanitasi sebelum disimpan ke DB
  • Query menggunakan wpdb->prepare() untuk mencegah SQL injection
  • Nonce WP REST digunakan untuk verifikasi request

== UNINSTALL ==

  Data di database TIDAK otomatis terhapus saat plugin dihapus.
  Untuk menghapus data: jalankan query SQL berikut di phpMyAdmin:
    DROP TABLE IF EXISTS `wp_assie4_presensi`;
  (Ganti `wp_` sesuai prefix tabel WordPress Anda)
