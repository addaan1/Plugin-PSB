<?php
/**
 * Plugin Name: ASSIE IV — Presensi Booth
 * Description: Sistem presensi digital pengunjung booth pameran ASSIE IV 2026. Menyimpan data ke database WordPress dan menampilkan halaman presensi full-page.
 * Version:     1.1.0
 * Author:      ASSIE IV 2026
 * Text Domain: assie4-presensi
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ASSIE4_DIR',     plugin_dir_path( __FILE__ ) );
define( 'ASSIE4_URL',     plugin_dir_url( __FILE__ ) );
define( 'ASSIE4_VERSION', '1.1.0' );
define( 'ASSIE4_TABLE',   'assie4_presensi' );

// ═══════════════════════════════════════════════════
//  AKTIVASI — Buat tabel database
// ═══════════════════════════════════════════════════
register_activation_hook( __FILE__, 'assie4_activate' );
function assie4_activate() {
    global $wpdb;
    $table   = $wpdb->prefix . ASSIE4_TABLE;
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
        id         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        booth      SMALLINT(5) UNSIGNED NOT NULL,
        nama       VARCHAR(255) NOT NULL,
        instansi   VARCHAR(255) NOT NULL,
        telp       VARCHAR(30)  NOT NULL,
        waktu      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
        ip_address VARCHAR(45)  DEFAULT NULL,
        PRIMARY KEY (id),
        KEY idx_booth (booth),
        KEY idx_waktu (waktu)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );

    // Simpan versi DB agar bisa migrasi di masa depan
    update_option( 'assie4_db_version', '1.0' );

    // Buat halaman presensi otomatis
    assie4_create_page();
}

// ═══════════════════════════════════════════════════
//  DEAKTIVASI
// ═══════════════════════════════════════════════════
register_deactivation_hook( __FILE__, 'assie4_deactivate' );
function assie4_deactivate() {
    // Tidak hapus data saat deaktivasi — hanya saat uninstall
}

// ═══════════════════════════════════════════════════
//  BUAT HALAMAN WORDPRESS OTOMATIS
// ═══════════════════════════════════════════════════
function assie4_create_page() {
    $existing = get_page_by_path( 'presensi-booth-assie4' );
    if ( $existing ) return;

    wp_insert_post( [
        'post_title'   => 'Presensi Booth — ASSIE IV 2026',
        'post_name'    => 'presensi-booth-assie4',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
        'page_template'=> 'assie4-presensi-template.php',
        'meta_input'   => [ '_wp_page_template' => 'assie4-presensi-template.php' ],
    ] );
}

// ═══════════════════════════════════════════════════
//  DAFTARKAN TEMPLATE HALAMAN
// ═══════════════════════════════════════════════════
add_filter( 'theme_page_templates', 'assie4_register_template' );
function assie4_register_template( $templates ) {
    $templates['assie4-presensi-template.php'] = 'ASSIE IV — Presensi Booth (Full Page)';
    return $templates;
}

add_filter( 'page_template', 'assie4_load_template' );
function assie4_load_template( $template ) {
    if ( get_page_template_slug() === 'assie4-presensi-template.php' ) {
        $plugin_template = ASSIE4_DIR . 'templates/assie4-presensi-template.php';
        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }
    return $template;
}

// ═══════════════════════════════════════════════════
//  HELPER WAKTU INDONESIA BARAT (WIB / Asia/Jakarta)
// ═══════════════════════════════════════════════════
function assie4_wib_datetime() {
    $tz = new DateTimeZone( 'Asia/Jakarta' );
    $dt = new DateTime( 'now', $tz );
    return $dt->format( 'Y-m-d H:i:s' );
}

function assie4_wib_date() {
    $tz = new DateTimeZone( 'Asia/Jakarta' );
    $dt = new DateTime( 'now', $tz );
    return $dt->format( 'Y-m-d' );
}

// Bypass error rest_cookie_invalid_nonce untuk endpoint publik presensi
add_filter( 'rest_authentication_errors', 'assie4_rest_bypass_cookie_check', 20 );
function assie4_rest_bypass_cookie_check( $result ) {
    if ( is_wp_error( $result ) && $result->get_error_code() === 'rest_cookie_invalid_nonce' ) {
        $uri   = $_SERVER['REQUEST_URI'] ?? '';
        $route = $_GET['rest_route'] ?? '';
        if ( strpos( $uri, 'assie4/v1' ) !== false || strpos( (string) $route, '/assie4/v1' ) !== false ) {
            return true;
        }
    }
    return $result;
}

// ═══════════════════════════════════════════════════
//  REST API ENDPOINTS
// ═══════════════════════════════════════════════════
add_action( 'rest_api_init', 'assie4_register_routes' );
function assie4_register_routes() {
    $ns = 'assie4/v1';

    // POST /wp-json/assie4/v1/presensi — Simpan presensi baru
    register_rest_route( $ns, '/presensi', [
        'methods'             => 'POST',
        'callback'            => 'assie4_save_presensi',
        'permission_callback' => '__return_true',
        'args'                => [
            'booth'    => [ 'required' => true,  'type' => 'integer', 'minimum' => 1, 'maximum' => 106 ],
            'nama'     => [ 'required' => true,  'type' => 'string',  'sanitize_callback' => 'sanitize_text_field' ],
            'instansi' => [ 'required' => true,  'type' => 'string',  'sanitize_callback' => 'sanitize_text_field' ],
            'telp'     => [ 'required' => true,  'type' => 'string',  'sanitize_callback' => 'sanitize_text_field' ],
            'lat'      => [ 'required' => true,  'type' => 'number' ],
            'lng'      => [ 'required' => true,  'type' => 'number' ],
        ],
    ] );

    // GET /wp-json/assie4/v1/presensi?booth=N — Ambil data presensi per booth
    register_rest_route( $ns, '/presensi', [
        'methods'             => 'GET',
        'callback'            => 'assie4_get_presensi',
        'permission_callback' => '__return_true',
        'args'                => [
            'booth' => [ 'required' => true, 'type' => 'integer', 'minimum' => 1, 'maximum' => 120 ],
            'limit' => [ 'required' => false, 'type' => 'integer', 'default' => 5 ],
        ],
    ] );

    // GET /wp-json/assie4/v1/leaderboard — Top booth per hari
    register_rest_route( $ns, '/leaderboard', [
        'methods'             => 'GET',
        'callback'            => 'assie4_get_leaderboard',
        'permission_callback' => '__return_true',
        'args'                => [
            'date'  => [ 'required' => false, 'type' => 'string', 'default' => '' ],
            'limit' => [ 'required' => false, 'type' => 'integer', 'default' => 10 ],
        ],
    ] );

    // GET /wp-json/assie4/v1/summary — Ringkasan semua booth
    register_rest_route( $ns, '/summary', [
        'methods'             => 'GET',
        'callback'            => 'assie4_get_summary',
        'permission_callback' => '__return_true',
    ] );
}

// ─── Validasi Koordinat Grand City Surabaya ───
// Grand City Mall Surabaya: Jl. Kusuma Gubeng, Ketabang, Genteng, Surabaya
// Koordinat: -7.262113648386964, 112.75013597795723
// Radius toleransi: 300 meter (mencakup seluruh kompleks Grand City)
function assie4_is_in_grand_city( $lat, $lng ) {
    $center_lat = -7.262113648386964;
    $center_lng = 112.75013597795723;
    $radius_m   = 300;

    // Haversine formula
    $earth_r = 6371000; // meter
    $d_lat   = deg2rad( $lat - $center_lat );
    $d_lng   = deg2rad( $lng - $center_lng );
    $a       = sin($d_lat/2) * sin($d_lat/2)
             + cos(deg2rad($center_lat)) * cos(deg2rad($lat))
             * sin($d_lng/2) * sin($d_lng/2);
    $distance = $earth_r * 2 * atan2( sqrt($a), sqrt(1-$a) );

    return $distance <= $radius_m;
}


/**
 * Return official booth-number, area-code, and tenant labels for presensi.
 * Numeric booth IDs stay aligned with the published floor plan (1–106).
 */
function assie4_presensi_booth_directory() {
    $ranges = [
        [ 'first' => 1,   'last' => 21,  'prefix' => 'A', 'area' => 'Area A' ],
        [ 'first' => 22,  'last' => 37,  'prefix' => 'D', 'area' => 'Area D' ],
        [ 'first' => 38,  'last' => 44,  'prefix' => 'C', 'area' => 'Area C' ],
        [ 'first' => 45,  'last' => 50,  'prefix' => 'E', 'area' => 'Area E' ],
        [ 'first' => 51,  'last' => 72,  'prefix' => 'F', 'area' => 'Area F' ],
        [ 'first' => 73,  'last' => 80,  'prefix' => 'G', 'area' => 'Area G' ],
        [ 'first' => 81,  'last' => 96,  'prefix' => 'H', 'area' => 'Area H' ],
        [ 'first' => 97,  'last' => 106, 'prefix' => 'B', 'area' => 'Area B' ],
    ];

    $tenant_source = get_option( 'assie4_pameran_tenants', null );
    if ( ! is_array( $tenant_source ) && function_exists( 'assie4_default_tenants' ) ) {
        $tenant_source = assie4_default_tenants();
    }
    if ( ! is_array( $tenant_source ) ) $tenant_source = [];

    $tenants_by_booth = [];
    foreach ( $tenant_source as $tenant ) {
        $booth_no = absint( $tenant['booth_no'] ?? 0 );
        $name     = sanitize_text_field( $tenant['name'] ?? '' );
        if ( $booth_no >= 1 && $booth_no <= 106 && $name !== '' ) {
            $tenants_by_booth[$booth_no] = $name;
        }
    }

    $directory = [];
    foreach ( $ranges as $range ) {
        for ( $booth_no = $range['first']; $booth_no <= $range['last']; $booth_no++ ) {
            $code = $range['prefix'] . ( $booth_no - $range['first'] + 1 );
            $name = $tenants_by_booth[$booth_no] ?? '';
            $status = $name !== '' ? $name : 'Tenant belum terdaftar';
            $directory[$booth_no] = [
                'code'  => $code,
                'area'  => $range['area'],
                'name'  => $status,
                'label' => sprintf( 'Booth %03d — %s · %s (%s)', $booth_no, $code, $status, $range['area'] ),
            ];
        }
    }

    return $directory;
}

/**
 * Mengembalikan kode prefix area (A-H) berdasarkan nomor booth
 */
function assie4_get_booth_area( $b ) {
    $b = (int) $b;
    if ( $b >= 1  && $b <= 21 ) return 'A';
    if ( $b >= 22 && $b <= 37 ) return 'D';
    if ( $b >= 38 && $b <= 44 ) return 'C';
    if ( $b >= 45 && $b <= 50 ) return 'E';
    if ( $b >= 51 && $b <= 72 ) return 'F';
    if ( $b >= 73 && $b <= 80 ) return 'G';
    if ( $b >= 81 && $b <= 96 ) return 'H';
    if ( $b >= 97 && $b <= 106 ) return 'B';
    return 'A';
}

/**
 * Mengembalikan metadata warna dan label untuk setiap Area A-H
 */
function assie4_get_area_meta() {
    return [
        'A' => [ 'label' => 'Area A — UNAIR',        'color' => '#2563eb', 'bg' => '#eff6ff', 'badge' => '#dbeafe', 'border' => '#93c5fd' ],
        'B' => [ 'label' => 'Area B — Riset & Unit',  'color' => '#059669', 'bg' => '#ecfdf5', 'badge' => '#d1fae5', 'border' => '#6ee7b7' ],
        'C' => [ 'label' => 'Area C — Sponsor',       'color' => '#d97706', 'bg' => '#fffbeb', 'badge' => '#fef3c7', 'border' => '#fcd34d' ],
        'D' => [ 'label' => 'Area D — Startup',       'color' => '#7c3aed', 'bg' => '#f5f3ff', 'badge' => '#ede9fe', 'border' => '#c4b5fd' ],
        'E' => [ 'label' => 'Area E — Inkubasi',      'color' => '#0891b2', 'bg' => '#ecfeff', 'badge' => '#cffafe', 'border' => '#67e8f9' ],
        'F' => [ 'label' => 'Area F — Inovasi',       'color' => '#4f46e5', 'bg' => '#eef2ff', 'badge' => '#e0e7ff', 'border' => '#a5b4fc' ],
        'G' => [ 'label' => 'Area G — Kuliner',       'color' => '#e11d48', 'bg' => '#fff1f2', 'badge' => '#ffe4e6', 'border' => '#fda4af' ],
        'H' => [ 'label' => 'Area H — Craft',         'color' => '#ca8a04', 'bg' => '#fefce8', 'badge' => '#fef9c3', 'border' => '#fde047' ],
    ];
}

function assie4_save_presensi( WP_REST_Request $req ) {
    global $wpdb;
    $table = $wpdb->prefix . ASSIE4_TABLE;

    $booth    = (int) $req->get_param('booth');
    $nama     = $req->get_param('nama');
    $instansi = $req->get_param('instansi');
    $telp     = $req->get_param('telp');

    // Validasi nomor telepon: minimal 8 digit angka
    $telp_digits = preg_replace('/\D/', '', $telp);
    if ( strlen($telp_digits) < 8 ) {
        return new WP_Error( 'invalid_telp', 'Nomor telepon tidak valid (min. 8 angka).', [ 'status' => 400 ] );
    }

    // Validasi koordinat GPS — harus berada di dalam area Grand City Surabaya
    $lat = (float) $req->get_param('lat');
    $lng = (float) $req->get_param('lng');
    if ( $lat == 0 && $lng == 0 ) {
        return new WP_Error( 'location_required', 'Izin lokasi diperlukan untuk presensi. Aktifkan GPS dan coba lagi.', [ 'status' => 403 ] );
    }
    if ( ! assie4_is_in_grand_city( $lat, $lng ) ) {
        return new WP_Error( 'outside_venue', 'Presensi hanya dapat dilakukan di dalam area Grand City Surabaya.', [ 'status' => 403 ] );
    }

    // Aturan Presensi:
    // Satu orang (berdasarkan nomor HP) bisa absen di semua booth pada hari yang sama.
    // Namun di booth yang SAMA, hanya bisa absen 1 kali per hari (WIB).
    // Pengunjung baru bisa absen lagi di booth tersebut pada hari berikutnya (besok).
    $visit_date = assie4_wib_date();
    $duplicate = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE booth = %d AND telp = %s AND DATE(waktu) = %s",
        $booth, $telp_digits, $visit_date
    ) );
    if ( $duplicate > 0 ) {
        return new WP_Error(
            'duplicate_today',
            'Nomor telepon ini sudah presensi di booth ini hari ini. Anda baru dapat presensi kembali di booth ini besok. Silakan kunjungi booth lainnya!',
            [ 'status' => 409 ]
        );
    }

    $waktu_wib = assie4_wib_datetime();

    $inserted = $wpdb->insert( $table, [
        'booth'      => $booth,
        'nama'       => sanitize_text_field( $nama ),
        'instansi'   => sanitize_text_field( $instansi ),
        'telp'       => $telp_digits,
        'waktu'      => $waktu_wib,
        'ip_address' => sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' ),
    ], [ '%d', '%s', '%s', '%s', '%s', '%s' ] );

    if ( ! $inserted ) {
        return new WP_Error( 'db_error', 'Gagal menyimpan data. Silakan coba lagi.', [ 'status' => 500 ] );
    }

    // Hitung total pengunjung booth ini
    $total = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE booth = %d", $booth
    ) );

    return rest_ensure_response( [
        'success' => true,
        'message' => 'Presensi berhasil dicatat!',
        'total'   => $total,
        'id'      => $wpdb->insert_id,
    ] );
}

// ─── Ambil Presensi Per Booth ───
function assie4_get_presensi( WP_REST_Request $req ) {
    global $wpdb;
    $table = $wpdb->prefix . ASSIE4_TABLE;
    $booth = (int) $req->get_param('booth');
    $limit = min( (int) $req->get_param('limit'), 20 );

    $rows = $wpdb->get_results( $wpdb->prepare(
        "SELECT nama, DATE_FORMAT(waktu,'%%H:%%i') AS waktu_fmt
         FROM {$table}
         WHERE booth = %d
         ORDER BY waktu DESC
         LIMIT %d",
        $booth, $limit
    ), ARRAY_A );

    $entries = array_map( static function ( $row ) {
        $name = trim( (string) $row['nama'] );
        preg_match_all( '/\X/u', $name, $match );
        $characters = $match[0] ?? [];
        $masked_name = '';
        foreach ( $characters as $index => $character ) {
            $masked_name .= $index === 0 ? $character : ( preg_match( '/^\s+$/u', $character ) ? ' ' : '*' );
        }
        return [
            'nama'      => $masked_name !== '' ? $masked_name : '*',
            'waktu_fmt' => $row['waktu_fmt'],
        ];
    }, $rows ?: [] );

    $total = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE booth = %d", $booth
    ) );

    return rest_ensure_response( [
        'booth'   => $booth,
        'total'   => $total,
        'entries' => $entries,
    ] );
}

// ─── Leaderboard Booth Per Hari ───
function assie4_get_leaderboard( WP_REST_Request $req ) {
    global $wpdb;
    $table = $wpdb->prefix . ASSIE4_TABLE;
    $date  = $req->get_param('date');
    $limit = min( (int) $req->get_param('limit'), 120 );

    // Default ke hari ini (WIB)
    if ( empty($date) ) {
        $date = assie4_wib_date();
    }

    $rows = $wpdb->get_results( $wpdb->prepare(
        "SELECT booth, COUNT(*) AS total
         FROM {$table}
         WHERE DATE(waktu) = %s
         GROUP BY booth
         ORDER BY total DESC, booth ASC
         LIMIT %d",
        $date, $limit
    ), ARRAY_A );

    $total_today = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE DATE(waktu) = %s", $date
    ) );

    return rest_ensure_response( [
        'date'        => $date,
        'total_today' => $total_today,
        'leaderboard' => $rows,
    ] );
}

// ─── Ringkasan Semua Booth ───
function assie4_get_summary( WP_REST_Request $req ) {
    global $wpdb;
    $table = $wpdb->prefix . ASSIE4_TABLE;

    $rows = $wpdb->get_results(
        "SELECT booth, COUNT(*) AS total FROM {$table} GROUP BY booth ORDER BY booth ASC",
        ARRAY_A
    );

    $total_all = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );

    return rest_ensure_response( [
        'total_all' => $total_all,
        'booths'    => $rows,
    ] );
}

// ═══════════════════════════════════════════════════
//  INTEGRASI STATISTIK DENGAN PLUGIN LAIN (PAMERAN DIGITAL)
// ═══════════════════════════════════════════════════
function assie4_presensi_get_stats() {
    global $wpdb;
    $table = $wpdb->prefix . ASSIE4_TABLE;

    if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table ) ) !== $table ) {
        return [ 'today' => 0, 'total' => 0, 'top' => [] ];
    }

    $today_date = assie4_wib_date();
    $today = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE DATE(waktu) = %s",
        $today_date
    ) );
    $total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );

    $directory = function_exists( 'assie4_presensi_booth_directory' ) ? assie4_presensi_booth_directory() : [];

    $top_rows = $wpdb->get_results( $wpdb->prepare(
        "SELECT booth, COUNT(*) AS total
         FROM {$table}
         WHERE DATE(waktu) = %s
         GROUP BY booth
         ORDER BY total DESC, booth ASC
         LIMIT 5",
        $today_date
    ), ARRAY_A );

    // Jika hari ini belum ada, tampilkan top booth akumulasi agar tidak kosong saat uji coba
    if ( empty( $top_rows ) ) {
        $top_rows = $wpdb->get_results(
            "SELECT booth, COUNT(*) AS total
             FROM {$table}
             GROUP BY booth
             ORDER BY total DESC, booth ASC
             LIMIT 5",
            ARRAY_A
        );
    }

    $top = [];
    foreach ( ( $top_rows ?: [] ) as $row ) {
        $b_no = (int) $row['booth'];
        $b_info = $directory[$b_no] ?? [];
        $top[] = [
            'booth' => $b_no,
            'name'  => $b_info['name'] ?? '',
            'count' => (int) $row['total'],
        ];
    }

    return [
        'today' => $today,
        'total' => $total,
        'top'   => $top,
    ];
}

// ═══════════════════════════════════════════════════
//  ADMIN MENU — Halaman Rekapitulasi
// ═══════════════════════════════════════════════════
add_action( 'admin_menu', 'assie4_admin_menu' );
add_action( 'admin_post_assie4_export_csv', 'assie4_handle_export_csv' );
function assie4_admin_menu() {
    add_menu_page(
        'ASSIE IV Presensi',
        'ASSIE IV Presensi',
        'manage_options',
        'assie4-presensi',
        'assie4_admin_page',
        'dashicons-groups',
        30
    );
}

function assie4_handle_export_csv() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Anda tidak memiliki izin untuk mengekspor data presensi.', '', [ 'response' => 403 ] );
    }
    check_admin_referer( 'assie4_export_csv' );
    assie4_export_csv();
    exit;
}

function assie4_admin_page() {
    global $wpdb;
    $table = $wpdb->prefix . ASSIE4_TABLE;

    // Pastikan tabel database sudah terbentuk
    if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table ) ) !== $table ) {
        assie4_activate();
    }

    $default_days = [
        '2026-11-06' => 'Jumat, 6 November 2026',
        '2026-11-07' => 'Sabtu, 7 November 2026',
        '2026-11-08' => 'Minggu, 8 November 2026',
    ];

    // Ambil semua tanggal yang memiliki rekaman presensi di database
    $recorded_dates = $wpdb->get_col( "SELECT DISTINCT DATE(waktu) FROM {$table} ORDER BY DATE(waktu) ASC" );
    if ( ! is_array( $recorded_dates ) ) {
        $recorded_dates = [];
    }

    $days = $default_days;
    $id_months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $id_days = [
        'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
    ];

    foreach ( $recorded_dates as $rec_date ) {
        if ( ! isset( $days[$rec_date] ) ) {
            $ts = strtotime( $rec_date );
            $eng_day = date( 'l', $ts );
            $day_num = date( 'j', $ts );
            $month_num = (int) date( 'n', $ts );
            $year = date( 'Y', $ts );
            $hari_id = $id_days[$eng_day] ?? $eng_day;
            $bulan_id = $id_months[$month_num] ?? date('F', $ts);
            $days[$rec_date] = sprintf( '%s, %d %s %s (Uji Coba)', $hari_id, $day_num, $bulan_id, $year );
        }
    }

    $range = sanitize_text_field( wp_unslash( $_GET['range'] ?? 'all' ) );
    if ( $range !== 'all' && ! isset( $days[$range] ) ) $range = 'all';
    $sort = sanitize_key( wp_unslash( $_GET['sort'] ?? 'desc' ) );
    if ( ! in_array( $sort, [ 'asc', 'desc' ], true ) ) $sort = 'desc';

    if ( $range === 'all' ) {
        $period_label = 'Semua Presensi (Akumulasi)';
        $total_period = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
        $active_booths = (int) $wpdb->get_var( "SELECT COUNT(DISTINCT booth) FROM {$table}" );
        $booth_rows = $wpdb->get_results(
            "SELECT booth, COUNT(*) AS total FROM {$table} GROUP BY booth",
            ARRAY_A
        );
        $recent = $wpdb->get_results(
            "SELECT booth, nama, instansi, telp, DATE_FORMAT(waktu,'%d/%m/%Y %H:%i') AS waktu_fmt
             FROM {$table} ORDER BY waktu DESC LIMIT 50",
            ARRAY_A
        );
    } else {
        $day_start = DateTimeImmutable::createFromFormat( '!Y-m-d', $range, wp_timezone() );
        $period_start = $range . ' 00:00:00';
        $period_end   = $day_start ? $day_start->modify( '+1 day' )->format( 'Y-m-d' ) . ' 00:00:00' : ( $range . ' 23:59:59' );
        $period_label = $days[$range];

        $total_period = (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE waktu >= %s AND waktu < %s",
            $period_start, $period_end
        ) );
        $active_booths = (int) $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(DISTINCT booth) FROM {$table} WHERE waktu >= %s AND waktu < %s",
            $period_start, $period_end
        ) );
        $booth_rows = $wpdb->get_results( $wpdb->prepare(
            "SELECT booth, COUNT(*) AS total FROM {$table}
             WHERE waktu >= %s AND waktu < %s GROUP BY booth",
            $period_start, $period_end
        ), ARRAY_A );
        $recent = $wpdb->get_results( $wpdb->prepare(
            "SELECT booth, nama, instansi, telp, DATE_FORMAT(waktu,'%d/%m/%Y %H:%i') AS waktu_fmt
             FROM {$table} WHERE waktu >= %s AND waktu < %s ORDER BY waktu DESC LIMIT 50",
            $period_start, $period_end
        ), ARRAY_A );
    }

    $daily_rows = $wpdb->get_results(
        "SELECT DATE(waktu) AS event_date, COUNT(*) AS total
         FROM {$table}
         GROUP BY DATE(waktu)",
        ARRAY_A
    );
    $day_totals = array_fill_keys( array_keys( $days ), 0 );
    foreach ( ( $daily_rows ?: [] ) as $daily_row ) {
        if ( isset( $day_totals[$daily_row['event_date']] ) ) {
            $day_totals[$daily_row['event_date']] = (int) $daily_row['total'];
        }
    }
    $peak_date = '';
    if ( ! empty( $day_totals ) && max( $day_totals ) > 0 ) {
        $peak_date = array_search( max( $day_totals ), $day_totals, true );
    }

    $counts = array_fill( 1, 120, 0 );
    foreach ( ( $booth_rows ?: [] ) as $booth_row ) {
        $booth_number = (int) $booth_row['booth'];
        if ( $booth_number >= 1 && $booth_number <= 120 ) {
            $counts[$booth_number] = (int) $booth_row['total'];
        }
    }
    $ranked = [];
    foreach ( $counts as $booth_number => $count ) {
        $ranked[] = [ 'booth' => (int) $booth_number, 'total' => (int) $count ];
    }
    usort( $ranked, static function( $a, $b ) use ( $sort ) {
        if ( $a['total'] === $b['total'] ) return $a['booth'] <=> $b['booth'];
        return $sort === 'asc' ? $a['total'] <=> $b['total'] : $b['total'] <=> $a['total'];
    } );
    $top_ranked = $ranked;
    usort( $top_ranked, static function( $a, $b ) {
        if ( $a['total'] === $b['total'] ) return $a['booth'] <=> $b['booth'];
        return $b['total'] <=> $a['total'];
    } );
    $pie_rows = array_values( array_filter( $top_ranked, static function( $row ) {
        return $row['total'] > 0;
    } ) );
    $max_count = max( 1, max( $counts ) );
    $max_day   = max( 1, max( $day_totals ) );

    $tenant_directory = [];
    $booth_dir = function_exists( 'assie4_presensi_booth_directory' ) ? assie4_presensi_booth_directory() : [];
    foreach ( $booth_dir as $b_no => $b_data ) {
        $tenant_directory[$b_no] = [
            'code' => $b_data['code'] ?? str_pad( (string) $b_no, 3, '0', STR_PAD_LEFT ),
            'name' => $b_data['name'] ?? '',
        ];
    }

    $area_meta = assie4_get_area_meta();

    $db_matrix = $wpdb->get_results(
        "SELECT booth, DATE(waktu) AS event_date, COUNT(*) AS total
         FROM {$table}
         GROUP BY booth, DATE(waktu)",
        ARRAY_A
    );
    $daily_booth_matrix = [];
    $daily_area_totals = [];
    foreach ( ( $db_matrix ?: [] ) as $row ) {
        $b_no = (int) $row['booth'];
        $d_str = $row['event_date'];
        $c_num = (int) $row['total'];
        $area_code = assie4_get_booth_area( $b_no );

        if ( ! isset( $daily_booth_matrix[$d_str] ) ) {
            $daily_booth_matrix[$d_str] = [];
        }
        $daily_booth_matrix[$d_str][$b_no] = $c_num;

        if ( ! isset( $daily_area_totals[$d_str] ) ) {
            $daily_area_totals[$d_str] = array_fill_keys( array_keys( $area_meta ), 0 );
        }
        $daily_area_totals[$d_str][$area_code] += $c_num;
    }

    $area_totals_all = array_fill_keys( array_keys( $area_meta ), 0 );
    foreach ( $daily_area_totals as $d_str => $areas ) {
        foreach ( $areas as $ar_code => $val ) {
            $area_totals_all[$ar_code] += $val;
        }
    }

    $booth_list_for_chart = [];
    foreach ( $booth_dir as $b_no => $b_data ) {
        $ar = assie4_get_booth_area( $b_no );
        $booth_list_for_chart[$b_no] = [
            'booth' => $b_no,
            'code'  => $b_data['code'] ?? str_pad( (string) $b_no, 3, '0', STR_PAD_LEFT ),
            'name'  => $b_data['name'] ?? '',
            'area'  => $ar,
            'color' => $area_meta[$ar]['color'] ?? '#2475e8',
            'bg'    => $area_meta[$ar]['bg'] ?? '#eff6ff',
            'badge' => $area_meta[$ar]['badge'] ?? '#dbeafe',
            'total' => $counts[$b_no] ?? 0,
        ];
    }

    $chart_config = [
        'days'              => $days,
        'day_totals'        => $day_totals,
        'areas'             => $area_meta,
        'area_totals_all'   => $area_totals_all,
        'daily_area_totals' => $daily_area_totals,
        'daily_booth'       => $daily_booth_matrix,
        'booths'            => $booth_list_for_chart,
        'total_period'      => $total_period,
    ];

    $unvisited_booths = max( 0, 120 - $active_booths );
    $pie_segments = [];
    $pie_running = 0;
    foreach ( $pie_rows as $index => &$pie_row ) {
        $pie_row['color'] = 'hsl(' . (int) floor( ( $index * 137.508 ) % 360 ) . ',68%,52%)';
        $pie_row['percent'] = $total_period > 0 ? round( ( (int) $pie_row['total'] / $total_period ) * 100, 1 ) : 0;
        $start = $total_period > 0 ? ( $pie_running / $total_period ) * 100 : 0;
        $pie_running += (int) $pie_row['total'];
        $end = $total_period > 0 ? ( $pie_running / $total_period ) * 100 : 0;
        $pie_segments[] = $pie_row['color'] . ' ' . number_format( $start, 4, '.', '' ) . '% ' . number_format( $end, 4, '.', '' ) . '%';
    }
    unset( $pie_row );
    $pie_style = $pie_segments ? 'conic-gradient(' . implode( ', ', $pie_segments ) . ')' : 'conic-gradient(#e8edf4 0% 100%)';

    $page = get_page_by_path( 'presensi-booth-assie4' );
    $page_url = $page ? get_permalink( $page ) : '';
    $export_url = wp_nonce_url(
        add_query_arg( [ 'action' => 'assie4_export_csv' ], admin_url( 'admin-post.php' ) ),
        'assie4_export_csv'
    );
    ?>
    <style>
      .wrap > .notice, .wrap > .updated, .wrap > .error { margin: 15px 0 12px 0; border-radius: 8px; }
      #assie4-dashboard{--a4-ink:#14243a;--a4-muted:#708099;--a4-line:#e5ebf3;--a4-blue:#2475e8;--a4-teal:#12a899;--a4-gold:#e6a526;color:var(--a4-ink);max-width:1500px;margin:18px 16px 24px 0}
      #assie4-dashboard *{box-sizing:border-box}
      #assie4-dashboard .a4-dash-head{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;padding:26px 30px;border-radius:18px;background:linear-gradient(115deg,#13243d,#1d4672 70%,#216da4);color:#fff;box-shadow:0 12px 30px rgba(16,43,78,.14)}
      #assie4-dashboard .a4-dash-head .a4-head-title{margin:0;color:#fff;font-size:25px;font-weight:700;letter-spacing:-.3px}
      #assie4-dashboard .a4-dash-head p{margin:8px 0 0;color:#d5e4f4;font-size:13px}
      #assie4-dashboard .a4-head-actions{display:flex;flex-wrap:wrap;gap:9px}
      #assie4-dashboard .a4-head-actions .button{min-height:38px;display:inline-flex;align-items:center;padding:0 14px;border:1px solid rgba(255,255,255,.32);border-radius:9px;background:rgba(255,255,255,.1);color:#fff;font-weight:600}
      #assie4-dashboard .a4-head-actions .button-primary{background:#fff;color:#174a7d;border-color:#fff}
      #assie4-dashboard .a4-panel{background:#fff;border:1px solid var(--a4-line);border-radius:15px;padding:21px 23px;margin-top:19px;box-shadow:0 5px 18px rgba(25,52,86,.045)}
      #assie4-dashboard .a4-section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:0 0 16px;flex-wrap:wrap}
      #assie4-dashboard .a4-section-head h2{margin:0;padding:0;font-size:16px;color:var(--a4-ink);font-weight:700}
      #assie4-dashboard .a4-section-head p{margin:4px 0 0;color:var(--a4-muted);font-size:12px}
      #assie4-dashboard .a4-kpis{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:15px;margin-top:18px}
      #assie4-dashboard .a4-kpi{position:relative;overflow:hidden;min-height:122px;padding:20px 22px;background:#fff;border:1px solid var(--a4-line);border-radius:15px;box-shadow:0 5px 18px rgba(25,52,86,.045)}
      #assie4-dashboard .a4-kpi:after{content:"";position:absolute;width:105px;height:105px;right:-31px;top:-36px;border-radius:50%;background:var(--kpi-soft)}
      #assie4-dashboard .a4-kpi-label{position:relative;z-index:1;color:var(--a4-muted);font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.7px}
      #assie4-dashboard .a4-kpi-value{position:relative;z-index:1;margin-top:11px;font-size:31px;line-height:1.1;font-weight:800;color:var(--kpi-color);letter-spacing:-.8px}
      #assie4-dashboard .a4-kpi-note{position:relative;z-index:1;margin-top:6px;color:#8592a5;font-size:12px}
      #assie4-dashboard .a4-daily-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px}
      #assie4-dashboard .a4-day-card{padding:15px 17px;border:1px solid var(--a4-line);border-radius:12px;background:linear-gradient(145deg,#fff,#f8fbff)}
      #assie4-dashboard .a4-day-label{font-size:12px;font-weight:700;color:#61738b}
      #assie4-dashboard .a4-day-count{margin:7px 0 10px;font-size:22px;font-weight:800;color:#1e5fa8}
      #assie4-dashboard .a4-progress{height:7px;border-radius:20px;background:#edf2f8;overflow:hidden}
      #assie4-dashboard .a4-progress span{display:block;height:100%;border-radius:inherit;background:linear-gradient(90deg,#28b8a6,#4386ed)}

      /* ── BAR CHART STYLES ── */
      .a4-tab-group{display:inline-flex;background:#f0f4f9;border-radius:10px;padding:4px;gap:4px;flex-wrap:wrap}
      .a4-tab-btn{border:0;background:transparent;border-radius:7px;padding:7px 14px;font-size:12px;font-weight:700;color:#50627a;cursor:pointer;transition:all .18s}
      .a4-tab-btn:hover{color:#172b4d;background:rgba(255,255,255,.5)}
      .a4-tab-btn.active{background:#13243d;color:#fff;box-shadow:0 3px 8px rgba(19,36,61,.18)}
      .a4-area-legend{display:flex;align-items:center;flex-wrap:wrap;gap:8px;padding:12px 14px;background:#f8fbfe;border:1px solid var(--a4-line);border-radius:10px;margin-bottom:15px}
      .a4-legend-title{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.6px;color:#64748b}
      .a4-legend-chips{display:flex;flex-wrap:wrap;gap:6px}
      .a4-area-chip{display:inline-flex;align-items:center;gap:6px;padding:5px 9px;border-radius:7px;border:1px solid #dbe3ed;background:#fff;font-size:11px;font-weight:700;color:#334155;cursor:pointer;transition:all .15s}
      .a4-area-chip:hover{border-color:#94a3b8;transform:translateY(-1px)}
      .a4-area-chip.active{border-color:#0f172a;box-shadow:0 2px 6px rgba(15,23,42,.12);background:#f8fafc}
      .a4-chip-dot{width:8px;height:8px;border-radius:50%;flex:none}
      .a4-chip-count{padding:1px 6px;border-radius:10px;font-size:10px;font-weight:800}
      .a4-chart-toolbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;padding:14px 18px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:18px;box-shadow:0 1px 3px rgba(15,23,42,.03)}
      .a4-filter-group{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
      .a4-filter-label{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.6px;color:#475569;white-space:nowrap}
      .a4-filter-label svg{width:14px;height:14px;stroke:#64748b;flex:none}
      .a4-select-styled{min-height:38px;border:1.5px solid #cbd5e1;border-radius:9px;padding:0 34px 0 12px;font-size:12px;font-weight:600;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 11px center;color:#0f172a;box-shadow:0 1px 2px rgba(0,0,0,.03);transition:all .2s;cursor:pointer;max-width:100%}
      .a4-select-styled:hover{border-color:#94a3b8;background-color:#fcfdfd}
      .a4-select-styled:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.12);outline:none}
      .a4-toolbar-meta{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;background:#fff;border:1px solid #e2e8f0;border-radius:20px;font-size:11px;font-weight:700;color:#334155;box-shadow:0 1px 2px rgba(0,0,0,.02);margin-left:auto}
      .a4-vbars-wrapper{display:flex;align-items:flex-end;justify-content:space-around;gap:20px;min-height:270px;padding:24px 16px 12px;background:linear-gradient(180deg,#fafcff 0%,#fff 100%);border:1px solid var(--a4-line);border-radius:12px}
      .a4-vbars-single-wrap{justify-content:center;gap:36px}
      .a4-vbar-col{flex:1;max-width:180px;display:flex;flex-direction:column;align-items:center;gap:10px}
      .a4-vbar-val{font-size:13px;font-weight:800;color:#1e40af;text-align:center;white-space:nowrap}
      .a4-vbar-val small{font-size:11px;font-weight:600;color:#64748b}
      .a4-vbar-track{width:100%;height:180px;background:#f1f5fa;border-radius:9px 9px 0 0;display:flex;align-items:flex-end;overflow:hidden;box-shadow:inset 0 1px 3px rgba(0,0,0,.04)}
      .a4-vbar-fill{width:100%;border-radius:9px 9px 0 0;display:flex;flex-direction:column-reverse;overflow:hidden;transition:height .35s ease}
      .a4-bar-segment{width:100%;transition:all .18s;cursor:pointer}
      .a4-bar-segment:hover{filter:brightness(1.15)}
      .a4-bar-empty-fill{width:100%;height:6px;background:#cbd5e1}
      .a4-vbar-foot{text-align:center;margin-top:4px}
      .a4-vbar-foot strong{display:block;font-size:12px;color:#0f172a}
      .a4-vbar-foot span{display:block;font-size:11px;color:#64748b;margin-top:2px}
      .a4-area-summary-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:10px;margin-top:16px}
      .a4-area-card{padding:11px 13px;background:#fff;border:1px solid #edf2f7;border-radius:9px;box-shadow:0 2px 5px rgba(0,0,0,.02)}
      .a4-ac-name{font-size:11px;font-weight:700;color:#475569}
      .a4-ac-val{font-size:14px;font-weight:800;margin-top:4px}
      .a4-ac-val small{font-size:11px;font-weight:600;color:#64748b}
      .a4-ac-bar{height:5px;border-radius:10px;background:#f1f5f9;margin-top:6px;overflow:hidden}
      .a4-ac-bar span{display:block;height:100%;border-radius:inherit}
      .a4-hbars-list{display:flex;flex-direction:column;gap:8px;max-height:550px;overflow-y:auto;padding-right:6px}
      .a4-hbar-row{display:grid;grid-template-columns:36px minmax(200px,280px) minmax(0,1fr) 110px;align-items:center;gap:12px;padding:8px 12px;background:#fff;border:1px solid #edf2f7;border-radius:8px;transition:background .15s}
      .a4-hbar-row:hover{background:#f8fafc}
      .a4-hb-rank{display:inline-flex;justify-content:center;font-size:11px;font-weight:800;color:#64748b;background:#f1f5f9;border-radius:6px;padding:3px 0}
      .a4-hb-info{display:flex;flex-direction:column;gap:2px;min-width:0}
      .a4-hb-code{display:inline-flex;align-items:center;font-size:11px;font-weight:800;border-radius:6px;padding:2px 7px;width:fit-content}
      .a4-hb-name{font-size:11px;color:#64748b;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
      .a4-hb-track{height:14px;background:#f1f5f9;border-radius:20px;overflow:hidden}
      .a4-hb-fill{height:100%;border-radius:inherit;transition:width .35s ease}
      .a4-hb-val{text-align:right;font-size:12px;white-space:nowrap}
      .a4-hb-val strong{font-size:13px;font-weight:800}
      .a4-sb-card{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:16px 20px;background:#fff;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:16px}
      .a4-sb-title{margin:6px 0 0;font-size:16px;color:#0f172a;font-weight:700}
      .a4-sb-area-tag{display:inline-block;font-size:11px;font-weight:700;padding:2px 8px;border-radius:6px;margin-left:6px}
      .a4-sb-total-wrap{text-align:right}
      .a4-sb-total-lbl{display:block;font-size:11px;font-weight:700;color:#64748b}
      .a4-sb-total-num{font-size:22px;font-weight:800}
      .a4-sb-total-num small{font-size:12px;color:#64748b}
      .a4-chart-empty{padding:36px;text-align:center;color:#94a3b8;font-size:13px;font-weight:600}

      /* ── REDESIGNED FILTER PANEL (AESTHETIC & MODERN) ── */
      #assie4-dashboard .a4-filter-panel{background:linear-gradient(180deg,#fff 0%,#fbfcfe 100%);border:1px solid #e2e8f0;border-radius:16px;padding:22px 24px;box-shadow:0 4px 18px rgba(15,23,42,.04);margin-top:19px}
      #assie4-dashboard .a4-filter-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:18px;flex-wrap:wrap}
      #assie4-dashboard .a4-filter-title-wrap h2{margin:6px 0 0;font-size:16px;font-weight:800;color:#0f172a;letter-spacing:-.2px}
      #assie4-dashboard .a4-filter-title-wrap p{margin:4px 0 0;font-size:12px;color:#64748b}
      #assie4-dashboard .a4-filter-badge{display:inline-flex;padding:3px 8px;border-radius:6px;background:#f1f5f9;color:#475569;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.6px}
      #assie4-dashboard .a4-filter-active-pill{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;background:#f0f7ff;border:1px solid #bfdbfe;border-radius:30px;font-size:12px;color:#1e40af;font-weight:600}
      #assie4-dashboard .a4-filter-active-pill strong{font-weight:800;color:#1d4ed8}
      #assie4-dashboard .a4-pulse-dot{width:7px;height:7px;border-radius:50%;background:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.2);flex:none}
      #assie4-dashboard .a4-filter-form{display:grid;grid-template-columns:minmax(230px,1fr) minmax(230px,1fr) auto;align-items:flex-end;gap:16px;padding:16px 18px;background:#f8fafc;border:1px solid #eef2f6;border-radius:12px}
      #assie4-dashboard .a4-filter-field{display:flex;flex-direction:column;gap:7px}
      #assie4-dashboard .a4-field-label{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.65px;color:#475569}
      #assie4-dashboard .a4-field-label svg{width:14px;height:14px;stroke:#64748b;flex:none}
      #assie4-dashboard .a4-field-select-wrap{position:relative;width:100%}
      #assie4-dashboard .a4-filter-select{width:100%;min-height:42px;border:1.5px solid #cbd5e1;border-radius:10px;padding:0 36px 0 14px;font-size:13px;font-weight:600;color:#0f172a;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 13px center;box-shadow:0 1px 2px rgba(0,0,0,.03);transition:all .2s;cursor:pointer}
      #assie4-dashboard .a4-filter-select:hover{border-color:#94a3b8;background-color:#fdfefe}
      #assie4-dashboard .a4-filter-select:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.12);outline:none}
      #assie4-dashboard .a4-btn-submit{min-height:42px;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:0 24px;border-radius:10px;border:none;background:linear-gradient(135deg,#1d4ed8 0%,#2563eb 100%);color:#fff;font-size:13px;font-weight:700;letter-spacing:.2px;cursor:pointer;box-shadow:0 4px 12px rgba(37,99,235,.25);transition:all .2s;white-space:nowrap}
      #assie4-dashboard .a4-btn-submit svg{width:15px;height:15px;stroke:#fff;transition:transform .3s ease}
      #assie4-dashboard .a4-btn-submit:hover{background:linear-gradient(135deg,#1e40af 0%,#1d4ed8 100%);box-shadow:0 6px 18px rgba(37,99,235,.32);transform:translateY(-1px)}
      #assie4-dashboard .a4-btn-submit:hover svg{transform:rotate(45deg)}
      #assie4-dashboard .a4-btn-submit:active{transform:translateY(0);box-shadow:0 2px 6px rgba(37,99,235,.2)}
      #assie4-dashboard .a4-pie-layout{display:grid;grid-template-columns:minmax(220px,300px) minmax(0,1fr);align-items:center;gap:30px}
      #assie4-dashboard .a4-pie-chart{width:min(100%,280px);aspect-ratio:1;border-radius:50%;background:<?php echo esc_attr( $pie_style ); ?>;position:relative;margin:auto;box-shadow:inset 0 0 0 1px rgba(20,36,58,.06),0 8px 24px rgba(25,52,86,.1)}
      #assie4-dashboard .a4-pie-chart:after{content:"";position:absolute;inset:27%;border-radius:50%;background:#fff;box-shadow:0 0 0 1px var(--a4-line)}
      #assie4-dashboard .a4-pie-center{position:absolute;z-index:1;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;pointer-events:none}
      #assie4-dashboard .a4-pie-center strong{font-size:25px;color:#183d67;line-height:1.1}
      #assie4-dashboard .a4-pie-center span{margin-top:4px;color:var(--a4-muted);font-size:11px}
      #assie4-dashboard .a4-pie-legend{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px 16px;max-height:360px;overflow:auto;padding:2px 8px 2px 2px}
      #assie4-dashboard .a4-pie-item{display:grid;grid-template-columns:11px minmax(0,1fr) auto;align-items:center;gap:9px;min-width:0;padding:9px 10px;border:1px solid #edf1f6;border-radius:9px;background:#fbfcfe}
      #assie4-dashboard .a4-pie-swatch{width:10px;height:10px;border-radius:50%}
      #assie4-dashboard .a4-pie-label{min-width:0;color:#52647c;font-size:12px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
      #assie4-dashboard .a4-pie-label strong{color:#24415f}
      #assie4-dashboard .a4-pie-count{color:#183d67;font-size:12px;font-weight:800;white-space:nowrap}
      #assie4-dashboard .a4-table-wrap{overflow-x:auto;border:1px solid var(--a4-line);border-radius:11px}
      #assie4-dashboard table{border:0;box-shadow:none}
      #assie4-dashboard .a4-table{border-collapse:collapse;min-width:690px;width:100%}
      #assie4-dashboard .a4-table th{padding:12px 14px;background:#f4f7fb;color:#697a91;font-size:11px;text-transform:uppercase;letter-spacing:.55px;border-bottom:1px solid var(--a4-line);text-align:left}
      #assie4-dashboard .a4-table td{padding:11px 14px;color:#33465f;border-bottom:1px solid #edf1f6;font-size:13px;vertical-align:middle}
      #assie4-dashboard .a4-table tr:last-child td{border-bottom:0}
      #assie4-dashboard .a4-booth-code{display:inline-flex;align-items:center;padding:5px 9px;border-radius:7px;background:#edf5ff;color:#1f62a7;font-size:11px;font-weight:800;white-space:nowrap}
      #assie4-dashboard .a4-tenant-name{display:block;margin-top:3px;color:#8290a3;font-size:11px}
      #assie4-dashboard .a4-rank-chip{display:inline-flex;min-width:32px;justify-content:center;padding:4px 7px;border-radius:7px;background:#f0f3f8;color:#68788e;font-weight:800;font-size:11px}
      #assie4-dashboard .a4-count{font-weight:800;color:#183d67;white-space:nowrap}
      #assie4-dashboard .a4-empty{padding:27px!important;text-align:center;color:#8694a7!important}
      #assie4-dashboard .a4-empty strong{display:block;margin-bottom:4px;color:#405674}
      #assie4-dashboard .a4-recent{max-height:530px;overflow:auto}
      #assie4-dashboard .a4-phone{font-variant-numeric:tabular-nums;white-space:nowrap}
      @media(max-width:1000px){#assie4-dashboard .a4-dash-head{display:block}#assie4-dashboard .a4-head-actions{margin-top:16px}#assie4-dashboard .a4-kpis,#assie4-dashboard .a4-daily-grid{grid-template-columns:1fr 1fr}#assie4-dashboard .a4-pie-layout{grid-template-columns:minmax(200px,260px) minmax(0,1fr);gap:20px}#assie4-dashboard .a4-pie-legend{grid-template-columns:1fr}.a4-hbar-row{grid-template-columns:30px 180px minmax(0,1fr) 90px}}
      @media(max-width:860px){#assie4-dashboard .a4-filter-form{grid-template-columns:1fr}#assie4-dashboard .a4-btn-submit{width:100%}}
      @media(max-width:600px){#assie4-dashboard{margin-right:10px}#assie4-dashboard .a4-dash-head{padding:20px}#assie4-dashboard .a4-dash-head .a4-head-title{font-size:20px}#assie4-dashboard .a4-kpis,#assie4-dashboard .a4-daily-grid{grid-template-columns:1fr}#assie4-dashboard .a4-panel{padding:16px}#assie4-dashboard .a4-pie-layout{grid-template-columns:1fr;gap:18px}#assie4-dashboard .a4-pie-chart{width:min(75vw,260px)}#assie4-dashboard .a4-pie-legend{grid-template-columns:1fr;max-height:300px}.a4-hbar-row{grid-template-columns:1fr;gap:6px}.a4-hb-val{text-align:left}.a4-chart-toolbar{flex-direction:column;align-items:stretch}.a4-filter-group{flex-direction:column;align-items:stretch}.a4-select-styled{width:100%}.a4-toolbar-meta{margin-left:0;justify-content:center}}
    </style>
    <div class="wrap">
      <h1 class="wp-heading-inline" style="display:none"></h1>
      <div id="assie4-dashboard">
        <div class="a4-dash-head">
          <div>
            <div class="a4-head-title">ASSIE IV 2026 <span style="font-weight:400;opacity:.8">/ Dashboard Presensi</span></div>
            <p>Pantau jumlah pengunjung setiap booth selama pameran.</p>
          </div>
          <div class="a4-head-actions">
            <?php if ( $page_url ) : ?><a href="<?php echo esc_url( $page_url ); ?>" target="_blank" rel="noopener" class="button">Buka halaman presensi</a><?php endif; ?>
            <a href="<?php echo esc_url( $export_url ); ?>" class="button button-primary">Export data CSV</a>
          </div>
        </div>

        <div class="a4-kpis">
          <div class="a4-kpi" style="--kpi-color:#1766b1;--kpi-soft:#eaf3ff">
            <div class="a4-kpi-label">Total kunjungan booth</div>
            <div class="a4-kpi-value"><?php echo esc_html( number_format_i18n( $total_period ) ); ?></div>
          <div class="a4-kpi-note"><?php echo esc_html( $period_label ); ?> · Total presensi di semua booth; satu orang dapat tercatat di beberapa booth.</div>
        </div>
        <div class="a4-kpi" style="--kpi-color:#079783;--kpi-soft:#e5faf5">
          <div class="a4-kpi-label">Booth dikunjungi</div>
          <div class="a4-kpi-value"><?php echo esc_html( number_format_i18n( $active_booths ) ); ?><span style="font-size:16px;color:#8290a3;font-weight:600"> / 120</span></div>
          <div class="a4-kpi-note"><?php echo esc_html( number_format_i18n( $active_booths ) ); ?> sudah dikunjungi · <?php echo esc_html( number_format_i18n( $unvisited_booths ) ); ?> belum dikunjungi pada periode ini.</div>
        </div>
        <div class="a4-kpi" style="--kpi-color:#c28412;--kpi-soft:#fff4d8">
          <div class="a4-kpi-label">Hari teramai</div>
          <div class="a4-kpi-value" style="font-size:22px"><?php echo $peak_date ? esc_html( $days[$peak_date] ) : 'Belum ada data'; ?></div>
          <div class="a4-kpi-note"><?php echo $peak_date ? esc_html( number_format_i18n( $day_totals[$peak_date] ) . ' pengunjung' ) : 'Akan terisi saat presensi tercatat'; ?></div>
        </div>
      </div>

      <section class="a4-panel">
        <div class="a4-section-head">
          <div><h2>Ringkasan harian</h2><p>Jumlah presensi masuk pada setiap hari ASSIE IV.</p></div>
        </div>
        <div class="a4-daily-grid">
          <?php foreach ( $days as $day_date => $day_label ) : $day_count = $day_totals[$day_date]; ?>
            <div class="a4-day-card">
              <div class="a4-day-label"><?php echo esc_html( $day_label ); ?></div>
              <div class="a4-day-count"><?php echo esc_html( number_format_i18n( $day_count ) ); ?> <span style="font-size:12px;font-weight:600;color:#8290a3">pengunjung</span></div>
              <div class="a4-progress"><span style="width:<?php echo esc_attr( (string) round( $day_count / $max_day * 100 ) ); ?>%"></span></div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- ── SECTION: BAR CHART PERBANDINGAN HARI 1-3 & PER BOOTH DENGAN WARNA KATEGORI AREA A-H ── -->
      <section class="a4-panel a4-chart-panel" id="a4AnalyticsPanel">
        <div class="a4-section-head">
          <div>
            <h2>Grafik Perbandingan Kunjungan (Hari 1 – Hari 3)</h2>
            <p>Perbandingan jumlah pengunjung per hari dan per booth dengan kategori warna Area A–H.</p>
          </div>
          <div class="a4-tab-group" role="tablist">
            <button type="button" class="a4-tab-btn active" data-tab="daily" onclick="a4SwitchChartTab('daily')">Jumlah Semua Booth</button>
            <button type="button" class="a4-tab-btn" data-tab="booths" onclick="a4SwitchChartTab('booths')">Perbandingan Per Booth</button>
            <button type="button" class="a4-tab-btn" data-tab="single" onclick="a4SwitchChartTab('single')">Fokus Satu Booth</button>
          </div>
        </div>

        <!-- Legend Area A-H (Interaktif) -->
        <div class="a4-area-legend">
          <span class="a4-legend-title">Kategori Area:</span>
          <div class="a4-legend-chips" id="a4LegendChips">
            <button type="button" class="a4-area-chip active" data-area="all" onclick="a4FilterArea('all')">
              <span class="a4-chip-dot" style="background:#0f172a"></span>
              <span>Semua Area</span>
              <span class="a4-chip-count" style="background:#e2e8f0;color:#334155"><?php echo esc_html( number_format_i18n( $total_period ) ); ?></span>
            </button>
            <?php foreach ( $area_meta as $ar_code => $ar_info ) :
              $ar_count = $area_totals_all[$ar_code] ?? 0;
            ?>
              <button type="button" class="a4-area-chip" data-area="<?php echo esc_attr( $ar_code ); ?>" onclick="a4FilterArea('<?php echo esc_js( $ar_code ); ?>')">
                <span class="a4-chip-dot" style="background:<?php echo esc_attr( $ar_info['color'] ); ?>"></span>
                <span><?php echo esc_html( $ar_info['label'] ); ?></span>
                <span class="a4-chip-count" style="background:<?php echo esc_attr( $ar_info['bg'] ); ?>;color:<?php echo esc_attr( $ar_info['color'] ); ?>"><?php echo esc_html( number_format_i18n( $ar_count ) ); ?></span>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Toolbar Filter untuk Tab Booths & Single -->
        <div class="a4-chart-toolbar" id="a4ChartToolbar" style="display:none">
          <div id="a4ToolbarDayWrap" class="a4-filter-group" style="display:none">
            <span class="a4-filter-label">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              Periode Hari
            </span>
            <select id="a4ChartDaySelect" class="a4-select-styled" onchange="a4OnDayChange(this.value)">
              <option value="all">Akumulasi Seluruh Hari (Hari 1 – 3)</option>
              <?php foreach ( $days as $d_date => $d_lbl ) : ?>
                <option value="<?php echo esc_attr( $d_date ); ?>"><?php echo esc_html( $d_lbl ); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div id="a4ToolbarSpecificBoothWrap" class="a4-filter-group" style="display:none">
            <span class="a4-filter-label">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
              Pilih Booth
            </span>
            <select id="a4SpecificBoothSelect" class="a4-select-styled" onchange="a4OnSpecificBoothChange(this.value)">
              <?php foreach ( $booth_list_for_chart as $b_no => $b_data ) : ?>
                <option value="<?php echo esc_attr( (string) $b_no ); ?>">
                  [<?php echo esc_html( $b_data['area'] ); ?>] Booth <?php echo esc_html( $b_data['code'] ); ?> — <?php echo esc_html( $b_data['name'] ?: 'Tanpa Tenant' ); ?> (<?php echo esc_html( number_format_i18n( $b_data['total'] ) ); ?> kunjungan)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="a4-toolbar-meta" id="a4ToolbarMeta"></div>
        </div>

        <!-- View 1: Jumlah Semua Booth (Harian) -->
        <div id="a4ViewDaily" class="a4-chart-view">
          <div class="a4-vbars-wrapper" id="a4DailyBars">
            <!-- Diisi oleh JS renderDaily() -->
          </div>
          <!-- Rekap Kotak Kategori Area A-H -->
          <div class="a4-area-summary-grid">
            <?php foreach ( $area_meta as $ar_code => $ar_info ) :
              $ar_val = $area_totals_all[$ar_code] ?? 0;
              $ar_pct = $total_period > 0 ? round( ( $ar_val / $total_period ) * 100, 1 ) : 0;
            ?>
              <div class="a4-area-card" style="border-top:3px solid <?php echo esc_attr( $ar_info['color'] ); ?>">
                <div class="a4-ac-name" style="color:<?php echo esc_attr( $ar_info['color'] ); ?>"><?php echo esc_html( $ar_info['label'] ); ?></div>
                <div class="a4-ac-val" style="color:#0f172a"><?php echo esc_html( number_format_i18n( $ar_val ) ); ?> <small>pengunjung (<?php echo esc_html( $ar_pct ); ?>%)</small></div>
                <div class="a4-ac-bar"><span style="width:<?php echo esc_attr( (string) $ar_pct ); ?>%;background:<?php echo esc_attr( $ar_info['color'] ); ?>"></span></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- View 2: Perbandingan Per Booth (Horizontal Bar Chart) -->
        <div id="a4ViewBooths" class="a4-chart-view" style="display:none">
          <div class="a4-hbars-list" id="a4BoothsList">
            <!-- Diisi oleh JS renderBooths() -->
          </div>
        </div>

        <!-- View 3: Fokus Satu Booth (Perbandingan Hari 1-3 untuk Booth Terpilih) -->
        <div id="a4ViewSingle" class="a4-chart-view" style="display:none">
          <div class="a4-sb-card" id="a4SingleBoothCard">
            <!-- Diisi oleh JS renderSingle() -->
          </div>
          <div class="a4-vbars-wrapper a4-vbars-single-wrap" id="a4SingleBars">
            <!-- Diisi oleh JS renderSingle() -->
          </div>
        </div>
      </section>

      <!-- ── SECTION: FILTER REKAP BOOTH (REDESIGNED) ── -->
      <section class="a4-panel a4-filter-panel">
        <div class="a4-filter-header">
          <div class="a4-filter-title-wrap">
            <span class="a4-filter-badge">Filter Data</span>
            <h2>Rekapitulasi Kunjungan Booth</h2>
            <p>Pilih periode pameran dan atur urutan peringkat untuk analisis performa tenant.</p>
          </div>
          <div class="a4-filter-active-pill">
            <span class="a4-pulse-dot"></span>
            <span>Periode Aktif: <strong><?php echo esc_html( $period_label ); ?></strong></span>
          </div>
        </div>

        <form class="a4-filter-form" method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">
          <input type="hidden" name="page" value="assie4-presensi">

          <div class="a4-filter-field">
            <label for="a4-range-select" class="a4-field-label">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              Periode Pameran
            </label>
            <div class="a4-field-select-wrap">
              <select id="a4-range-select" name="range" class="a4-filter-select">
                <option value="all" <?php selected( $range, 'all' ); ?>>Akumulasi tiga hari</option>
                <?php foreach ( $days as $day_date => $day_label ) : ?>
                  <option value="<?php echo esc_attr( $day_date ); ?>" <?php selected( $range, $day_date ); ?>><?php echo esc_html( $day_label ); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="a4-filter-field">
            <label for="a4-sort-select" class="a4-field-label">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
              Urutan Jumlah Pengunjung
            </label>
            <div class="a4-field-select-wrap">
              <select id="a4-sort-select" name="sort" class="a4-filter-select">
                <option value="desc" <?php selected( $sort, 'desc' ); ?>>Tertinggi ke terendah</option>
                <option value="asc" <?php selected( $sort, 'asc' ); ?>>Terendah ke tertinggi</option>
              </select>
            </div>
          </div>

          <div class="a4-filter-submit-wrap">
            <button type="submit" class="a4-btn-submit">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
              Terapkan Filter
            </button>
          </div>
        </form>
      </section>

      <section class="a4-panel">
        <div class="a4-section-head">
          <div><h2>Distribusi kunjungan per booth</h2><p>Perbandingan jumlah presensi tiap booth pada <?php echo esc_html( strtolower( $period_label ) ); ?>. Diagram mengikuti filter rekap booth di atas.</p></div>
          <span class="a4-booth-code"><?php echo esc_html( number_format_i18n( count( $pie_rows ) ) ); ?> booth memiliki kunjungan</span>
        </div>
        <?php if ( empty( $pie_rows ) ) : ?>
          <div class="a4-empty"><strong>Belum ada presensi pada periode ini.</strong>Diagram akan menampilkan pembagian kunjungan setelah data presensi tercatat.</div>
        <?php else : ?>
          <div class="a4-pie-layout">
            <div class="a4-pie-chart" role="img" aria-label="Diagram pie distribusi <?php echo esc_attr( number_format_i18n( $total_period ) ); ?> kunjungan pada <?php echo esc_attr( $period_label ); ?>">
              <div class="a4-pie-center"><strong><?php echo esc_html( number_format_i18n( $total_period ) ); ?></strong><span>total kunjungan</span></div>
            </div>
            <div class="a4-pie-legend" aria-label="Rincian kunjungan per booth">
              <?php foreach ( $pie_rows as $pie_row ) :
                $booth_number = (int) $pie_row['booth'];
                $booth_info = $tenant_directory[$booth_number] ?? [];
                $booth_code = $booth_info['code'] ?? str_pad( (string) $booth_number, 3, '0', STR_PAD_LEFT );
                $tenant_name = $booth_info['name'] ?? 'Tenant belum terhubung';
              ?>
                <div class="a4-pie-item">
                  <span class="a4-pie-swatch" style="background:<?php echo esc_attr( $pie_row['color'] ); ?>"></span>
                  <span class="a4-pie-label"><strong><?php echo esc_html( $booth_code ); ?></strong> · <?php echo esc_html( $tenant_name ); ?> <span>(<?php echo esc_html( number_format_i18n( $pie_row['percent'], 1 ) ); ?>%)</span></span>
                  <span class="a4-pie-count"><?php echo esc_html( number_format_i18n( (int) $pie_row['total'] ) ); ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </section>

      <section class="a4-panel">
        <div class="a4-section-head">
          <div><h2>Rekap seluruh booth</h2><p>120 booth diurutkan <?php echo $sort === 'asc' ? 'dari pengunjung paling sedikit' : 'dari pengunjung terbanyak'; ?>.</p></div>
        </div>
        <div class="a4-table-wrap">
          <table class="a4-table">
            <thead><tr><th style="width:76px">Rank</th><th>Booth / Tenant</th><th style="width:155px">Pengunjung</th><th style="width:32%">Perbandingan periode</th></tr></thead>
            <tbody>
              <?php foreach ( $ranked as $index => $row ) :
                $booth_number = (int) $row['booth'];
                $booth_info = $tenant_directory[$booth_number] ?? [];
                $booth_code = $booth_info['code'] ?? str_pad( (string) $booth_number, 3, '0', STR_PAD_LEFT );
                $tenant_name = $booth_info['name'] ?? '';
                $bar_width = (int) round( (int) $row['total'] / $max_count * 100 );
                $b_area = assie4_get_booth_area( $booth_number );
                $b_meta = $area_meta[$b_area] ?? null;
                $b_color = $b_meta['color'] ?? '#2475e8';
                $b_bg = $b_meta['badge'] ?? '#edf5ff';
              ?>
                <tr>
                  <td><span class="a4-rank-chip">#<?php echo esc_html( (string) ( $index + 1 ) ); ?></span></td>
                  <td>
                    <span class="a4-booth-code" style="background:<?php echo esc_attr( $b_bg ); ?>;color:<?php echo esc_attr( $b_color ); ?>;border:1px solid <?php echo esc_attr( $b_color ); ?>30">
                      <?php echo esc_html( $booth_code ); ?> · Area <?php echo esc_html( $b_area ); ?>
                    </span>
                    <?php if ( $tenant_name ) : ?><span class="a4-tenant-name"><?php echo esc_html( $tenant_name ); ?></span><?php endif; ?>
                  </td>
                  <td class="a4-count"><?php echo esc_html( number_format_i18n( (int) $row['total'] ) ); ?></td>
                  <td><div class="a4-progress"><span style="width:<?php echo esc_attr( (string) $bar_width ); ?>%;background:<?php echo esc_attr( $b_color ); ?>"></span></div></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>

      <section class="a4-panel">
        <div class="a4-section-head"><div><h2>Presensi terbaru</h2><p>50 data terakhir untuk <?php echo esc_html( strtolower( $period_label ) ); ?>.</p></div></div>
        <div class="a4-table-wrap a4-recent">
          <table class="a4-table">
            <thead><tr><th>Booth / Tenant</th><th>Nama pengunjung</th><th>Instansi</th><th>Telepon</th><th>Waktu</th></tr></thead>
            <tbody>
              <?php if ( empty( $recent ) ) : ?>
                <tr><td colspan="5" class="a4-empty">Belum ada data presensi pada periode ini.</td></tr>
              <?php else : foreach ( $recent as $entry ) :
                $booth_number = (int) $entry['booth'];
                $booth_info = $tenant_directory[$booth_number] ?? [];
                $booth_code = $booth_info['code'] ?? str_pad( (string) $booth_number, 3, '0', STR_PAD_LEFT );
                $b_area = assie4_get_booth_area( $booth_number );
                $b_meta = $area_meta[$b_area] ?? null;
                $b_color = $b_meta['color'] ?? '#1f62a7';
                $b_bg = $b_meta['badge'] ?? '#edf5ff';
              ?>
                <tr>
                  <td>
                    <span class="a4-booth-code" style="background:<?php echo esc_attr( $b_bg ); ?>;color:<?php echo esc_attr( $b_color ); ?>;border:1px solid <?php echo esc_attr( $b_color ); ?>30">
                      <?php echo esc_html( $booth_code ); ?> · Area <?php echo esc_html( $b_area ); ?>
                    </span>
                    <?php if ( ! empty( $booth_info['name'] ) ) : ?><span class="a4-tenant-name"><?php echo esc_html( $booth_info['name'] ); ?></span><?php endif; ?>
                  </td>
                  <td><?php echo esc_html( $entry['nama'] ); ?></td>
                  <td><?php echo esc_html( $entry['instansi'] ); ?></td>
                  <td class="a4-phone"><?php echo esc_html( $entry['telp'] ); ?></td>
                  <td><?php echo esc_html( $entry['waktu_fmt'] ); ?></td>
                </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </div>

  <script>
    (function(){
      const DATA = <?php echo wp_json_encode( $chart_config ); ?>;
      let currentTab = 'daily';
      let currentArea = 'all';
      let currentDay = 'all';

      function formatDayLabel(dKey, fullLabel, idx) {
        if (dKey === '2026-11-06') return { title: 'Hari 1 (Resmi)', date: 'Jumat, 6 Nov 2026' };
        if (dKey === '2026-11-07') return { title: 'Hari 2 (Resmi)', date: 'Sabtu, 7 Nov 2026' };
        if (dKey === '2026-11-08') return { title: 'Hari 3 (Resmi)', date: 'Minggu, 8 Nov 2026' };
        const parts = (fullLabel || '').split(',');
        return {
          title: parts[0] ? parts[0].trim() : ('Hari ' + (idx + 1)),
          date: parts[1] ? parts[1].trim() : dKey
        };
      }

      window.a4SwitchChartTab = function(tab) {
        currentTab = tab;
        document.querySelectorAll('.a4-tab-btn').forEach(btn => {
          btn.classList.toggle('active', btn.dataset.tab === tab);
        });
        document.getElementById('a4ViewDaily').style.display = tab === 'daily' ? 'block' : 'none';
        document.getElementById('a4ViewBooths').style.display = tab === 'booths' ? 'block' : 'none';
        document.getElementById('a4ViewSingle').style.display = tab === 'single' ? 'block' : 'none';

        const toolbar = document.getElementById('a4ChartToolbar');
        const dayWrap = document.getElementById('a4ToolbarDayWrap');
        const boothWrap = document.getElementById('a4ToolbarSpecificBoothWrap');

        if (tab === 'daily') {
          toolbar.style.display = 'none';
          renderDaily();
        } else if (tab === 'booths') {
          toolbar.style.display = 'flex';
          dayWrap.style.display = 'flex';
          boothWrap.style.display = 'none';
          renderBooths();
        } else if (tab === 'single') {
          toolbar.style.display = 'flex';
          dayWrap.style.display = 'none';
          boothWrap.style.display = 'flex';
          renderSingle();
        }
      };

      window.a4FilterArea = function(area) {
        currentArea = area;
        document.querySelectorAll('#a4LegendChips .a4-area-chip').forEach(btn => {
          btn.classList.toggle('active', btn.dataset.area === area);
        });
        if (currentTab === 'daily') {
          renderDaily();
        } else if (currentTab === 'booths') {
          renderBooths();
        } else if (currentTab === 'single') {
          filterSpecificBoothDropdown(area);
          renderSingle();
        }
      };

      window.a4OnDayChange = function(val) {
        currentDay = val;
        renderBooths();
      };

      window.a4OnSpecificBoothChange = function(val) {
        renderSingle();
      };

      function filterSpecificBoothDropdown(area) {
        const select = document.getElementById('a4SpecificBoothSelect');
        if (!select) return;
        let firstMatch = null;
        Array.from(select.options).forEach(opt => {
          const bNo = parseInt(opt.value, 10);
          const bData = DATA.booths[bNo];
          if (!bData) return;
          const match = (area === 'all' || bData.area === area);
          opt.style.display = match ? '' : 'none';
          if (match && !firstMatch) firstMatch = opt.value;
        });
        if (firstMatch && (!DATA.booths[select.value] || (area !== 'all' && DATA.booths[select.value].area !== area))) {
          select.value = firstMatch;
        }
      }

      function renderDaily() {
        const container = document.getElementById('a4DailyBars');
        if (!container) return;
        const dayKeys = Object.keys(DATA.days);
        if (!dayKeys.length) {
          container.innerHTML = '<div class="a4-chart-empty">Tidak ada jadwal hari yang tersedia.</div>';
          return;
        }

        const countsByDay = {};
        let maxCount = 1;
        dayKeys.forEach(d => {
          let total = 0;
          if (currentArea === 'all') {
            total = DATA.day_totals[d] || 0;
          } else {
            total = (DATA.daily_area_totals[d] && DATA.daily_area_totals[d][currentArea]) || 0;
          }
          countsByDay[d] = total;
          if (total > maxCount) maxCount = total;
        });

        const grandTotal = Object.values(countsByDay).reduce((a, b) => a + b, 0);

        let html = '';
        dayKeys.forEach((d, idx) => {
          const dayCount = countsByDay[d];
          const pct = grandTotal > 0 ? Math.round((dayCount / grandTotal) * 100) : 0;
          const barHeightPct = dayCount > 0 ? Math.max(8, Math.round((dayCount / maxCount) * 100)) : 4;
          const lbl = formatDayLabel(d, DATA.days[d], idx);

          let segmentsHtml = '';
          if (dayCount > 0) {
            if (currentArea === 'all') {
              Object.keys(DATA.areas).forEach(arCode => {
                const arVal = (DATA.daily_area_totals[d] && DATA.daily_area_totals[d][arCode]) || 0;
                if (arVal > 0) {
                  const segPct = (arVal / dayCount) * 100;
                  const arInfo = DATA.areas[arCode];
                  const tooltip = `${arInfo.label}: ${arVal.toLocaleString()} pengunjung (${segPct.toFixed(1)}%)`;
                  segmentsHtml += `<div class="a4-bar-segment" title="${tooltip}" style="height:${segPct}%;background:${arInfo.color}"></div>`;
                }
              });
            } else {
              const arInfo = DATA.areas[currentArea];
              segmentsHtml = `<div class="a4-bar-segment" style="height:100%;background:${arInfo.color}" title="${arInfo.label}: ${dayCount.toLocaleString()} pengunjung"></div>`;
            }
          } else {
            segmentsHtml = '<div class="a4-bar-empty-fill"></div>';
          }

          html += `
            <div class="a4-vbar-col">
              <div class="a4-vbar-val">${dayCount.toLocaleString()} <small>(${pct}%)</small></div>
              <div class="a4-vbar-track">
                <div class="a4-vbar-fill" style="height:${barHeightPct}%">${segmentsHtml}</div>
              </div>
              <div class="a4-vbar-foot">
                <strong>${lbl.title}</strong>
                <span>${lbl.date}</span>
              </div>
            </div>
          `;
        });

        container.innerHTML = html;
      }

      function renderBooths() {
        const container = document.getElementById('a4BoothsList');
        const meta = document.getElementById('a4ToolbarMeta');
        if (!container) return;

        let list = Object.values(DATA.booths);
        if (currentArea !== 'all') {
          list = list.filter(b => b.area === currentArea);
        }

        list = list.map(b => {
          let count = 0;
          if (currentDay === 'all') {
            count = b.total;
          } else {
            count = (DATA.daily_booth[currentDay] && DATA.daily_booth[currentDay][b.booth]) || 0;
          }
          return Object.assign({}, b, { _count: count });
        });

        list.sort((a, b) => b._count - a._count || a.booth - b.booth);

        const visitedList = list.filter(b => b._count > 0);
        const showList = visitedList.length > 0 ? visitedList : list.slice(0, 30);
        const maxVal = Math.max(1, ...showList.map(b => b._count));

        const areaLabel = currentArea === 'all' ? 'Semua Area' : DATA.areas[currentArea].label;
        const dayLabel = currentDay === 'all' ? 'Akumulasi Hari 1 – 3' : (DATA.days[currentDay] || currentDay);
        if (meta) {
          meta.innerHTML = `Menampilkan <strong>${visitedList.length}</strong> booth dikunjungi · <em>${areaLabel}</em> · <em>${dayLabel}</em>`;
        }

        if (visitedList.length === 0) {
          container.innerHTML = `<div class="a4-chart-empty">Belum ada kunjungan untuk kriteria filter ini (${areaLabel} pada ${dayLabel}).</div>`;
          return;
        }

        let html = '';
        showList.forEach((b, idx) => {
          const widthPct = Math.max(2, Math.round((b._count / maxVal) * 100));
          html += `
            <div class="a4-hbar-row">
              <span class="a4-hb-rank">#${idx + 1}</span>
              <div class="a4-hb-info">
                <span class="a4-hb-code" style="background:${b.bg};color:${b.color};border:1px solid ${b.color}35">Booth ${b.code} · Area ${b.area}</span>
                <span class="a4-hb-name" title="${b.name || 'Tanpa tenant'}">${b.name || 'Tenant belum terdaftar'}</span>
              </div>
              <div class="a4-hb-track">
                <div class="a4-hb-fill" style="width:${widthPct}%;background:${b.color}"></div>
              </div>
              <div class="a4-hb-val">
                <strong>${b._count.toLocaleString()}</strong> <small>kunjungan</small>
              </div>
            </div>
          `;
        });

        container.innerHTML = html;
      }

      function renderSingle() {
        const select = document.getElementById('a4SpecificBoothSelect');
        const card = document.getElementById('a4SingleBoothCard');
        const barsContainer = document.getElementById('a4SingleBars');
        if (!select || !card || !barsContainer) return;

        const bNo = parseInt(select.value, 10);
        const booth = DATA.booths[bNo];
        if (!booth) return;

        const arInfo = DATA.areas[booth.area] || { label: 'Area ' + booth.area, color: '#2563eb', bg: '#eff6ff' };

        card.innerHTML = `
          <div>
            <span class="a4-booth-code" style="background:${booth.bg};color:${booth.color};border:1px solid ${booth.color}40;font-size:13px;padding:6px 12px">Booth ${booth.code}</span>
            <span class="a4-sb-area-tag" style="background:${booth.bg};color:${booth.color}">${arInfo.label}</span>
            <h3 class="a4-sb-title">${booth.name || 'Tenant belum terdaftar'}</h3>
          </div>
          <div class="a4-sb-total-wrap">
            <span class="a4-sb-total-lbl">Total Kunjungan (Semua Hari)</span>
            <span class="a4-sb-total-num" style="color:${booth.color}">${booth.total.toLocaleString()} <small>pengunjung</small></span>
          </div>
        `;

        const dayKeys = Object.keys(DATA.days);
        const dayCounts = dayKeys.map(d => (DATA.daily_booth[d] && DATA.daily_booth[d][booth.booth]) || 0);
        const maxVal = Math.max(1, ...dayCounts);

        let html = '';
        dayKeys.forEach((d, idx) => {
          const count = (DATA.daily_booth[d] && DATA.daily_booth[d][booth.booth]) || 0;
          const pct = booth.total > 0 ? Math.round((count / booth.total) * 100) : 0;
          const barHeightPct = count > 0 ? Math.max(8, Math.round((count / maxVal) * 100)) : 4;
          const lbl = formatDayLabel(d, DATA.days[d], idx);
          const fillStyle = count > 0 ? `background:${booth.color}` : 'background:#cbd5e1';

          html += `
            <div class="a4-vbar-col">
              <div class="a4-vbar-val" style="color:${booth.color}">${count.toLocaleString()} <small>(${pct}%)</small></div>
              <div class="a4-vbar-track">
                <div class="a4-vbar-fill" style="height:${barHeightPct}%;${fillStyle}"></div>
              </div>
              <div class="a4-vbar-foot">
                <strong>${lbl.title}</strong>
                <span>${lbl.date}</span>
              </div>
            </div>
          `;
        });

        barsContainer.innerHTML = html;
      }

      renderDaily();
    })();
  </script>
  <?php
}

function assie4_export_csv() {
    global $wpdb;
    $table = $wpdb->prefix . ASSIE4_TABLE;

    $rows = $wpdb->get_results(
        "SELECT booth, nama, instansi, telp, DATE_FORMAT(waktu,'%d/%m/%Y %H:%i') AS waktu_fmt
         FROM {$table} ORDER BY booth ASC, waktu ASC",
        ARRAY_A
    );

    $filename = 'presensi-assie4-' . wp_date( 'Ymd-His' ) . '.csv';
    while ( ob_get_level() > 0 ) {
        ob_end_clean();
    }
    nocache_headers();
    header( 'Content-Type: text/csv; charset=UTF-8' );
    header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
    header( 'X-Content-Type-Options: nosniff' );
    echo "\xEF\xBB\xBF"; // BOM UTF-8 agar Excel terbaca dengan benar

    $out = fopen( 'php://output', 'w' );
    if ( false === $out ) {
        wp_die( 'File CSV tidak dapat dibuat.' );
    }
    fputcsv( $out, [ 'Booth', 'Nama', 'Instansi', 'Telepon', 'Waktu' ] );
    foreach ($rows as $r) {
        fputcsv( $out, [
            'Booth ' . str_pad( (string) $r['booth'], 3, '0', STR_PAD_LEFT ),
            $r['nama'],
            $r['instansi'],
            $r['telp'],
            $r['waktu_fmt'],
        ] );
    }
    fclose( $out );
}
