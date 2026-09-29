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
            'booth'    => [ 'required' => true,  'type' => 'integer', 'minimum' => 1, 'maximum' => 120 ],
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

    // Satu nomor hanya dihitung sekali per booth per hari; pengunjung boleh kembali pada hari event berikutnya.
    $visit_date = current_time( 'Y-m-d' );
    $duplicate = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE booth = %d AND telp = %s AND DATE(waktu) = %s",
        $booth, $telp_digits, $visit_date
    ) );
    if ( $duplicate > 0 ) {
        return new WP_Error( 'duplicate', 'Nomor telepon ini sudah pernah presensi di booth ini.', [ 'status' => 409 ] );
    }

    $inserted = $wpdb->insert( $table, [
        'booth'      => $booth,
        'nama'       => $nama,
        'instansi'   => $instansi,
        'telp'       => $telp_digits,
        'waktu'      => current_time( 'mysql' ),
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
        "SELECT nama, instansi, DATE_FORMAT(waktu,'%%H:%%i') AS waktu_fmt
         FROM {$table}
         WHERE booth = %d
         ORDER BY waktu DESC
         LIMIT %d",
        $booth, $limit
    ), ARRAY_A );

    $total = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE booth = %d", $booth
    ) );

    return rest_ensure_response( [
        'booth'   => $booth,
        'total'   => $total,
        'entries' => $rows,
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
        $date = current_time('Y-m-d');
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
//  ADMIN MENU — Halaman Rekapitulasi
// ═══════════════════════════════════════════════════
add_action( 'admin_menu', 'assie4_admin_menu' );
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

function assie4_admin_page() {
    global $wpdb;
    $table = $wpdb->prefix . ASSIE4_TABLE;

    if ( isset( $_GET['export'] ) && $_GET['export'] === 'csv' && current_user_can( 'manage_options' ) ) {
        check_admin_referer( 'assie4_export_csv' );
        assie4_export_csv();
        exit;
    }

    $days = [
        '2026-11-06' => 'Jumat, 6 November 2026',
        '2026-11-07' => 'Sabtu, 7 November 2026',
        '2026-11-08' => 'Minggu, 8 November 2026',
    ];
    $range = sanitize_text_field( wp_unslash( $_GET['range'] ?? 'all' ) );
    if ( $range !== 'all' && ! isset( $days[$range] ) ) $range = 'all';
    $sort = sanitize_key( wp_unslash( $_GET['sort'] ?? 'desc' ) );
    if ( ! in_array( $sort, [ 'asc', 'desc' ], true ) ) $sort = 'desc';

    $event_start = '2026-11-06 00:00:00';
    $event_end   = '2026-11-09 00:00:00';
    if ( $range === 'all' ) {
        $period_start = $event_start;
        $period_end   = $event_end;
        $period_label = 'Akumulasi 3 Hari';
    } else {
        $day_start = DateTimeImmutable::createFromFormat( '!Y-m-d', $range, wp_timezone() );
        $period_start = $range . ' 00:00:00';
        $period_end   = $day_start->modify( '+1 day' )->format( 'Y-m-d' ) . ' 00:00:00';
        $period_label = $days[$range];
    }

    $total_period = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE waktu >= %s AND waktu < %s",
        $period_start, $period_end
    ) );
    $active_booths = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(DISTINCT booth) FROM {$table} WHERE waktu >= %s AND waktu < %s",
        $period_start, $period_end
    ) );
    $daily_rows = $wpdb->get_results( $wpdb->prepare(
        "SELECT DATE(waktu) AS event_date, COUNT(*) AS total
         FROM {$table} WHERE waktu >= %s AND waktu < %s
         GROUP BY DATE(waktu)",
        $event_start, $event_end
    ), ARRAY_A );
    $day_totals = array_fill_keys( array_keys( $days ), 0 );
    foreach ( $daily_rows as $daily_row ) {
        if ( isset( $day_totals[$daily_row['event_date']] ) ) {
            $day_totals[$daily_row['event_date']] = (int) $daily_row['total'];
        }
    }
    $peak_date = '';
    if ( max( $day_totals ) > 0 ) {
        $peak_date = array_search( max( $day_totals ), $day_totals, true );
    }

    $booth_rows = $wpdb->get_results( $wpdb->prepare(
        "SELECT booth, COUNT(*) AS total FROM {$table}
         WHERE waktu >= %s AND waktu < %s GROUP BY booth",
        $period_start, $period_end
    ), ARRAY_A );
    $counts = array_fill( 1, 120, 0 );
    foreach ( $booth_rows as $booth_row ) {
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
    $top_three = array_slice( array_values( array_filter( $top_ranked, static function( $row ) {
        return $row['total'] > 0;
    } ) ), 0, 3 );
    $max_count = max( 1, max( $counts ) );
    $max_day   = max( 1, max( $day_totals ) );

    $tenant_directory = [];
    $tenant_rows = get_option( 'assie4_pameran_tenants', [] );
    if ( is_array( $tenant_rows ) ) {
        foreach ( $tenant_rows as $tenant ) {
            $booth_number = (int) ( $tenant['booth_no'] ?? 0 );
            if ( $booth_number > 0 ) {
                $tenant_directory[$booth_number] = [
                    'code' => sanitize_text_field( $tenant['code'] ?? '' ),
                    'name' => sanitize_text_field( $tenant['name'] ?? '' ),
                ];
            }
        }
    }

    $recent = $wpdb->get_results( $wpdb->prepare(
        "SELECT booth, nama, instansi, telp, DATE_FORMAT(waktu,'%d/%m/%Y %H:%i') AS waktu_fmt
         FROM {$table} WHERE waktu >= %s AND waktu < %s ORDER BY waktu DESC LIMIT 50",
        $period_start, $period_end
    ), ARRAY_A );
    $page = get_page_by_path( 'presensi-booth-assie4' );
    $page_url = $page ? get_permalink( $page ) : '';
    $export_url = wp_nonce_url(
        add_query_arg( [ 'page' => 'assie4-presensi', 'export' => 'csv' ], admin_url( 'admin.php' ) ),
        'assie4_export_csv'
    );
    ?>
    <style>
      #assie4-dashboard{--a4-ink:#14243a;--a4-muted:#708099;--a4-line:#e5ebf3;--a4-blue:#2475e8;--a4-teal:#12a899;--a4-gold:#e6a526;color:var(--a4-ink);max-width:1500px;margin:18px 16px 24px 0}
      #assie4-dashboard *{box-sizing:border-box}
      #assie4-dashboard .a4-dash-head{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;padding:26px 30px;border-radius:18px;background:linear-gradient(115deg,#13243d,#1d4672 70%,#216da4);color:#fff;box-shadow:0 12px 30px rgba(16,43,78,.14)}
      #assie4-dashboard .a4-dash-head h1{margin:0;color:#fff;font-size:25px;font-weight:700;letter-spacing:-.3px}
      #assie4-dashboard .a4-dash-head p{margin:8px 0 0;color:#d5e4f4;font-size:13px}
      #assie4-dashboard .a4-head-actions{display:flex;flex-wrap:wrap;gap:9px}
      #assie4-dashboard .a4-head-actions .button{min-height:38px;display:inline-flex;align-items:center;padding:0 14px;border:1px solid rgba(255,255,255,.32);border-radius:9px;background:rgba(255,255,255,.1);color:#fff;font-weight:600}
      #assie4-dashboard .a4-head-actions .button-primary{background:#fff;color:#174a7d;border-color:#fff}
      #assie4-dashboard .a4-panel{background:#fff;border:1px solid var(--a4-line);border-radius:15px;padding:21px 23px;margin-top:19px;box-shadow:0 5px 18px rgba(25,52,86,.045)}
      #assie4-dashboard .a4-section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:0 0 16px}
      #assie4-dashboard .a4-section-head h2{margin:0;padding:0;font-size:16px;color:var(--a4-ink);font-weight:700}
      #assie4-dashboard .a4-section-head p{margin:4px 0 0;color:var(--a4-muted);font-size:12px}
      #assie4-dashboard .a4-kpis{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:15px;margin-top:18px}
      #assie4-dashboard .a4-kpi{position:relative;overflow:hidden;min-height:122px;padding:20px 22px;background:#fff;border:1px solid var(--a4-line);border-radius:15px;box-shadow:0 5px 18px rgba(25,52,86,.045)}
      #assie4-dashboard .a4-kpi:after{content:"";position:absolute;width:105px;height:105px;right:-31px;top:-36px;border-radius:50%;background:var(--kpi-soft)}
      #assie4-dashboard .a4-kpi-label{position:relative;z-index:1;color:var(--a4-muted);font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.7px}
      #assie4-dashboard .a4-kpi-value{position:relative;z-index:1;margin-top:11px;font-size:31px;line-height:1.1;font-weight:800;color:var(--kpi-color);letter-spacing:-.8px}
      #assie4-dashboard .a4-kpi-note{position:relative;z-index:1;margin-top:6px;color:#8592a5;font-size:12px}
      #assie4-dashboard .a4-daily-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
      #assie4-dashboard .a4-day-card{padding:15px 17px;border:1px solid var(--a4-line);border-radius:12px;background:linear-gradient(145deg,#fff,#f8fbff)}
      #assie4-dashboard .a4-day-label{font-size:12px;font-weight:700;color:#61738b}
      #assie4-dashboard .a4-day-count{margin:7px 0 10px;font-size:22px;font-weight:800;color:#1e5fa8}
      #assie4-dashboard .a4-progress{height:7px;border-radius:20px;background:#edf2f8;overflow:hidden}
      #assie4-dashboard .a4-progress span{display:block;height:100%;border-radius:inherit;background:linear-gradient(90deg,#28b8a6,#4386ed)}
      #assie4-dashboard .a4-filter{display:flex;align-items:flex-end;flex-wrap:wrap;gap:12px}
      #assie4-dashboard .a4-filter label{display:grid;gap:6px;color:#68788e;font-size:12px;font-weight:700}
      #assie4-dashboard .a4-filter select{min-width:210px;min-height:39px;border:1px solid #d7e0eb;border-radius:8px;padding:0 34px 0 11px;color:#263d59;background:#fff}
      #assie4-dashboard .a4-filter .button{min-height:39px;padding:0 18px;border-radius:8px;font-weight:700}
      #assie4-dashboard .a4-filter-hint{margin-left:auto;color:#8794a6;font-size:12px;padding-bottom:9px}
      #assie4-dashboard .a4-podium{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
      #assie4-dashboard .a4-podium-card{position:relative;overflow:hidden;min-height:156px;padding:20px;border:1px solid #e9edf4;border-radius:14px;background:linear-gradient(145deg,#fff,#fafcff)}
      #assie4-dashboard .a4-podium-card.is-1{border-color:#f0d38d;background:linear-gradient(145deg,#fffaf0,#fff)}
      #assie4-dashboard .a4-podium-card.is-2{border-color:#d8e0ea}
      #assie4-dashboard .a4-podium-card.is-3{border-color:#ead8c5}
      #assie4-dashboard .a4-podium-rank{font-size:11px;text-transform:uppercase;letter-spacing:1px;font-weight:800;color:#9b7b36}
      #assie4-dashboard .a4-podium-card.is-2 .a4-podium-rank{color:#718096}
      #assie4-dashboard .a4-podium-card.is-3 .a4-podium-rank{color:#a6784b}
      #assie4-dashboard .a4-podium-booth{margin-top:9px;font-size:20px;font-weight:800;color:#1c3859}
      #assie4-dashboard .a4-podium-tenant{margin-top:3px;min-height:18px;color:#718096;font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
      #assie4-dashboard .a4-podium-total{position:absolute;right:18px;top:18px;color:#1d5e9f;font-size:18px;font-weight:800}
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
      @media(max-width:1000px){#assie4-dashboard .a4-dash-head{display:block}#assie4-dashboard .a4-head-actions{margin-top:16px}#assie4-dashboard .a4-kpis,#assie4-dashboard .a4-daily-grid{grid-template-columns:1fr 1fr}#assie4-dashboard .a4-podium{grid-template-columns:1fr}}
      @media(max-width:600px){#assie4-dashboard{margin-right:10px}#assie4-dashboard .a4-dash-head{padding:20px}#assie4-dashboard .a4-dash-head h1{font-size:20px}#assie4-dashboard .a4-kpis,#assie4-dashboard .a4-daily-grid{grid-template-columns:1fr}#assie4-dashboard .a4-panel{padding:16px}#assie4-dashboard .a4-filter select{width:100%;min-width:0}#assie4-dashboard .a4-filter label{width:100%}#assie4-dashboard .a4-filter-hint{width:100%;margin:0}}
    </style>
    <div class="wrap" id="assie4-dashboard">
      <div class="a4-dash-head">
        <div>
          <h1>ASSIE IV 2026 <span style="font-weight:400;opacity:.8">/ Dashboard Presensi</span></h1>
          <p>Pantau jumlah pengunjung setiap booth selama tiga hari pameran.</p>
        </div>
        <div class="a4-head-actions">
          <?php if ( $page_url ) : ?><a href="<?php echo esc_url( $page_url ); ?>" target="_blank" rel="noopener" class="button">Buka halaman presensi</a><?php endif; ?>
          <a href="<?php echo esc_url( $export_url ); ?>" class="button button-primary">Export data CSV</a>
        </div>
      </div>

      <div class="a4-kpis">
        <div class="a4-kpi" style="--kpi-color:#1766b1;--kpi-soft:#eaf3ff">
          <div class="a4-kpi-label">Pengunjung periode ini</div>
          <div class="a4-kpi-value"><?php echo esc_html( number_format_i18n( $total_period ) ); ?></div>
          <div class="a4-kpi-note"><?php echo esc_html( $period_label ); ?></div>
        </div>
        <div class="a4-kpi" style="--kpi-color:#079783;--kpi-soft:#e5faf5">
          <div class="a4-kpi-label">Booth dikunjungi</div>
          <div class="a4-kpi-value"><?php echo esc_html( number_format_i18n( $active_booths ) ); ?><span style="font-size:16px;color:#8290a3;font-weight:600"> / 120</span></div>
          <div class="a4-kpi-note">Memiliki setidaknya satu presensi</div>
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

      <section class="a4-panel">
        <div class="a4-section-head"><div><h2>Filter rekap booth</h2><p>Pilih satu hari atau lihat akumulasi seluruh hari pameran.</p></div></div>
        <form class="a4-filter" method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">
          <input type="hidden" name="page" value="assie4-presensi">
          <label>Periode
            <select name="range">
              <option value="all" <?php selected( $range, 'all' ); ?>>Akumulasi tiga hari</option>
              <?php foreach ( $days as $day_date => $day_label ) : ?>
                <option value="<?php echo esc_attr( $day_date ); ?>" <?php selected( $range, $day_date ); ?>><?php echo esc_html( $day_label ); ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <label>Urutan jumlah pengunjung
            <select name="sort">
              <option value="desc" <?php selected( $sort, 'desc' ); ?>>Tertinggi ke terendah</option>
              <option value="asc" <?php selected( $sort, 'asc' ); ?>>Terendah ke tertinggi</option>
            </select>
          </label>
          <button type="submit" class="button button-primary">Tampilkan rekap</button>
          <span class="a4-filter-hint">Periode aktif: <?php echo esc_html( $period_label ); ?></span>
        </form>
      </section>

      <section class="a4-panel">
        <div class="a4-section-head">
          <div><h2>Top 3 booth</h2><p>Peringkat tertinggi berdasarkan <?php echo esc_html( strtolower( $period_label ) ); ?>.</p></div>
          <span class="a4-booth-code"><?php echo esc_html( number_format_i18n( $total_period ) ); ?> pengunjung</span>
        </div>
        <?php if ( empty( $top_three ) ) : ?>
          <div class="a4-empty"><strong>Belum ada data presensi pada periode ini.</strong>Top 3 akan terisi otomatis setelah pengunjung melakukan presensi.</div>
        <?php else : ?>
          <div class="a4-podium">
            <?php for ( $rank = 0; $rank < 3; $rank++ ) :
              $row = $top_three[$rank] ?? null;
              $booth_number = $row ? (int) $row['booth'] : 0;
              $booth_info = $booth_number ? ( $tenant_directory[$booth_number] ?? [] ) : [];
              $booth_code = $booth_info['code'] ?? ( $booth_number ? str_pad( (string) $booth_number, 3, '0', STR_PAD_LEFT ) : '?' );
              $tenant_name = $booth_info['name'] ?? '';
            ?>
              <div class="a4-podium-card is-<?php echo esc_attr( (string) ( $rank + 1 ) ); ?>">
                <div class="a4-podium-rank">Peringkat <?php echo esc_html( (string) ( $rank + 1 ) ); ?></div>
                <?php if ( $row ) : ?>
                  <div class="a4-podium-total"><?php echo esc_html( number_format_i18n( (int) $row['total'] ) ); ?></div>
                  <div class="a4-podium-booth">Booth <?php echo esc_html( $booth_code ); ?></div>
                  <div class="a4-podium-tenant"><?php echo esc_html( $tenant_name ?: 'Tenant belum terhubung' ); ?></div>
                <?php else : ?>
                  <div class="a4-podium-booth" style="color:#9aa6b5">Menunggu data</div>
                  <div class="a4-podium-tenant">Peringkat ini akan muncul setelah ada presensi.</div>
                <?php endif; ?>
              </div>
            <?php endfor; ?>
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
              ?>
                <tr>
                  <td><span class="a4-rank-chip">#<?php echo esc_html( (string) ( $index + 1 ) ); ?></span></td>
                  <td><span class="a4-booth-code"><?php echo esc_html( $booth_code ); ?></span><?php if ( $tenant_name ) : ?><span class="a4-tenant-name"><?php echo esc_html( $tenant_name ); ?></span><?php endif; ?></td>
                  <td class="a4-count"><?php echo esc_html( number_format_i18n( (int) $row['total'] ) ); ?></td>
                  <td><div class="a4-progress"><span style="width:<?php echo esc_attr( (string) $bar_width ); ?>%"></span></div></td>
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
              ?>
                <tr>
                  <td><span class="a4-booth-code"><?php echo esc_html( $booth_code ); ?></span><?php if ( ! empty( $booth_info['name'] ) ) : ?><span class="a4-tenant-name"><?php echo esc_html( $booth_info['name'] ); ?></span><?php endif; ?></td>
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

    $filename = 'presensi-assie4-' . date('Ymd-His') . '.csv';
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    echo "\xEF\xBB\xBF"; // BOM UTF-8 agar Excel terbaca dengan benar

    $out = fopen('php://output', 'w');
    fputcsv($out, ['Booth','Nama','Instansi','Telepon','Waktu']);
    foreach ($rows as $r) {
        fputcsv($out, [
            'Booth ' . str_pad($r['booth'],3,'0',STR_PAD_LEFT),
            $r['nama'],
            $r['instansi'],
            $r['telp'],
            $r['waktu_fmt'],
        ]);
    }
    fclose($out);
}
