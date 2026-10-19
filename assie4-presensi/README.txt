=== ASSIE IV — Presensi Booth ===
Versi: 1.2.0
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
           ├── uninstall.php              ← Script uninstall bersih
           ├── README.txt                 ← File dokumentasi ini
           └── templates/
               └── assie4-presensi-template.php   ← Template halaman

2. Login ke WordPress Admin → Plugins → Aktifkan "ASSIE IV — Presensi Booth"

3. Saat aktivasi, plugin akan otomatis:
   ✅ Membuat tabel database `wp_assie4_presensi`
   ✅ Membuat halaman WordPress bernama "Presensi Booth — IM ASSIE IV 2026"
      di URL: /presensi-booth-assie4/

4. Buka halaman tersebut → sistem presensi siap digunakan!

== HALAMAN ADMIN & PENGELOLAAN DATABASE ==

Dashboard WordPress → Menu "ASSIE IV Presensi":
  • Melihat statistik total pengunjung, per hari, dan per area booth
  • Pencarian data presensi berdasarkan Nama, Instansi, atau No. Telepon
  • Filter data presensi berdasarkan booth spesifik
  • Pagination data presensi rapi (50 baris per halaman)
  • Hapus 1 baris data presensi satuan (dengan konfirmasi keamanan)
  • Hapus massal data presensi dengan centang checklist (Bulk Delete)
  • Pembersihan data presensi berdasarkan tanggal tertentu (uji coba)
  • Reset / Kosongkan seluruh database presensi (TRUNCATE) dengan proteksi kata kunci "RESET"
  • Unduh file cadangan CSV (Export Backup) sebelum melakukan reset
  • Export CSV dengan BOM UTF-8 (lengkap dengan ID, Kode Booth, Nama Tenant)

== FITUR LENGKAP ==

  ✅ 120 booth pameran sesuai denah resmi
  ✅ Simpan ke database WordPress (tabel `wp_assie4_presensi`)
  ✅ Validasi nomor telepon
  ✅ Pencegahan duplikasi (1 nomor telepon per booth per hari; hari event berbeda tetap dihitung)
  ✅ Halaman full-page responsif tanpa header/footer tema
  ✅ Daftar 5 presensi terakhir per booth (real-time dari DB)
  ✅ Admin panel lengkap dengan statistik & grafik interaktif
  ✅ Fitur hapus data & reset database aman untuk staging/testing sebelum hari H
  ✅ Export CSV dengan BOM UTF-8 (aman dan rapi untuk Microsoft Excel)
  ✅ REST API: GET & POST /wp-json/assie4/v1/presensi
  ✅ Skrip `uninstall.php` standar WordPress untuk menghapus tabel dan opsi saat di-uninstall

== CATATAN KEAMANAN ==

  • Hak akses hapus & reset hanya untuk user berlevel Administrator (`manage_options`)
  • Proteksi Nonce WordPress pada setiap aksi hapus tunggal, hapus massal, dan reset tabel
  • Konfirmasi ganda via JavaScript modal/dialog untuk mencegah penghapusan tidak disengaja
  • Validasi teks ketik konfirmasi `RESET` untuk pengosongan seluruh database
  • Semua input disanitasi sebelum disimpan ke DB
  • Query menggunakan $wpdb->prepare() untuk mencegah SQL injection
