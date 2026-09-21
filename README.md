# Plugin PSB — ASSIE IV

Kumpulan plugin WordPress untuk project pameran digital ASSIE IV 2026.

Repository ini berisi dua plugin:

- **ASSIE IV — Pameran Digital** (`v2.8.7`)
- **ASSIE IV — Presensi Booth** (`v1.0.0`)

## Fitur utama

### Pameran Digital

- Hero slider dan ticker informasi
- Informasi acara dan rundown
- Daftar tenant/booth dengan filter area
- Denah interaktif dan detail booth
- Integrasi link presensi
- Dashboard admin untuk mengelola konten pameran
- Export/import konfigurasi pameran

Shortcode utama:

```text
[assie4_pameran]
[assie4_berita jumlah="9" kolom="3"]
```

Halaman default: `/pameran-assie4/`

### Presensi Booth

- Form presensi pengunjung
- Validasi nomor telepon dan lokasi venue
- Pencegahan presensi ganda pada booth yang sama
- Statistik dan leaderboard booth
- Dashboard admin dan export CSV
- REST API untuk menyimpan dan membaca data presensi

Halaman default: `/presensi-booth-assie4/`

Endpoint REST:

```text
POST /wp-json/assie4/v1/presensi
GET  /wp-json/assie4/v1/presensi?booth=1
GET  /wp-json/assie4/v1/leaderboard
GET  /wp-json/assie4/v1/summary
```

## Struktur source

```text
assie4-pameran-digital-v2_8_7-updated/
└── assie4-pameran-digital-modified/

assie4-presensi plg/
└── assie4-presensi/
```

File utama setiap plugin adalah file PHP dengan nama plugin masing-masing.

## Instalasi manual

Salin folder plugin ke:

```text
wp-content/plugins/
```

Struktur akhirnya harus seperti ini:

```text
wp-content/plugins/assie4-pameran-digital-modified/assie4-pameran-digital.php
wp-content/plugins/assie4-presensi/assie4-presensi.php
```

Kemudian buka **WordPress Admin → Plugins** dan aktifkan kedua plugin. Aktifkan
plugin presensi terlebih dahulu agar tabel database dan halaman presensi dibuat.

## Pengembangan lokal dengan LocalWP

1. Jalankan site WordPress melalui Local.
2. Salin plugin ke folder `wp-content/plugins/` site tersebut.
3. Aktifkan plugin dari dashboard WordPress.
4. Uji halaman pameran dan presensi.

Project presensi menyimpan data pada tabel WordPress:

```text
wp_assie4_presensi
```

## Catatan keamanan

- Jangan commit `wp-config.php`, database dump, log, atau kredensial.
- Script pembuatan akun demo tidak disertakan dalam repository karena berisi
  password demo tetap.
- Sebelum deployment production, lakukan review terhadap endpoint REST,
  validasi lokasi, privasi data presensi, dan rate limiting.

## Kontribusi

Gunakan branch terpisah untuk setiap perubahan, misalnya:

```text
feature/perbaikan-presensi
fix/validasi-tenant
```

Buat commit yang jelas, push branch ke GitHub, lalu ajukan Pull Request untuk
direview sebelum digabung ke branch utama.
