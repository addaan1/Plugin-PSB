<?php
/**
 * Plugin Name: ASSIE IV — Presensi Booth
 * Description: Sistem presensi digital pengunjung booth pameran ASSIE IV 2026. Menyimpan data ke database WordPress dan menampilkan halaman presensi full-page.
 * Version:     1.0.0
 * Author:      ASSIE IV 2026
 * Text Domain: assie4-presensi
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ASSIE4_DIR',     plugin_dir_path( __FILE__ ) );
define( 'ASSIE4_URL',     plugin_dir_url( __FILE__ ) );
define( 'ASSIE4_VERSION', '1.0.0' );
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

    // Cegah 1 nomor presensi di booth yang SAMA lebih dari sekali (kapan pun)
    $duplicate = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE booth = %d AND telp = %s",
        $booth, $telp_digits
    ) );
    if ( $duplicate > 0 ) {
        return new WP_Error( 'duplicate', 'Nomor telepon ini sudah pernah presensi di booth ini.', [ 'status' => 409 ] );
    }

    $inserted = $wpdb->insert( $table, [
        'booth'      => $booth,
        'nama'       => $nama,
        'instansi'   => $instansi,
        'telp'       => $telp_digits,
        'ip_address' => sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' ),
    ], [ '%d', '%s', '%s', '%s', '%s' ] );

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

    // Handle export CSV
    if ( isset($_GET['export']) && $_GET['export'] === 'csv' && current_user_can('manage_options') ) {
        assie4_export_csv();
        exit;
    }

    $total_all = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
    $booths_used = (int) $wpdb->get_var("SELECT COUNT(DISTINCT booth) FROM {$table}");
    $today_count = (int) $wpdb->get_var(
        $wpdb->prepare("SELECT COUNT(*) FROM {$table} WHERE DATE(waktu) = %s", current_time('Y-m-d'))
    );

    $recent = $wpdb->get_results(
        "SELECT booth, nama, instansi, telp, DATE_FORMAT(waktu,'%d/%m/%Y %H:%i') AS waktu_fmt
         FROM {$table} ORDER BY waktu DESC LIMIT 50",
        ARRAY_A
    );

    $page_url = get_permalink( get_page_by_path('presensi-booth-assie4') );
    $export_url = add_query_arg(['page'=>'assie4-presensi','export'=>'csv'], admin_url('admin.php'));
    ?>
    <div class="wrap">
        <h1>📋 ASSIE IV 2026 — Rekap Presensi Booth</h1>
        <p>
            <a href="<?php echo esc_url($page_url); ?>" target="_blank" class="button">🔗 Buka Halaman Presensi</a>
            &nbsp;
            <a href="<?php echo esc_url($export_url); ?>" class="button button-primary">⬇️ Export CSV</a>
        </p>

        <!-- Stats -->
        <div style="display:flex;gap:16px;margin:24px 0;flex-wrap:wrap;">
            <?php foreach ([
                ['Total Pengunjung', $total_all, '#0073aa'],
                ['Booth Aktif', $booths_used . ' / 120', '#00a32a'],
                ['Hari Ini', $today_count, '#d63638'],
            ] as [$label, $val, $color]): ?>
            <div style="background:#fff;border:1px solid #ccd0d4;border-top:4px solid <?php echo $color?>;border-radius:4px;padding:18px 24px;min-width:160px;">
                <div style="font-size:28px;font-weight:700;color:<?php echo $color?>"><?php echo esc_html($val) ?></div>
                <div style="color:#666;font-size:13px;margin-top:4px"><?php echo esc_html($label) ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Leaderboard Hari Ini -->
        <h2>🏆 Top 10 Booth Hari Ini (<?php echo current_time('d/m/Y') ?>)</h2>
        <?php
        $lb = $wpdb->get_results( $wpdb->prepare(
            "SELECT booth, COUNT(*) AS total FROM {$table}
             WHERE DATE(waktu) = %s
             GROUP BY booth ORDER BY total DESC LIMIT 10",
            current_time('Y-m-d')
        ), ARRAY_A );
        $max_lb = !empty($lb) ? (int)$lb[0]['total'] : 1;
        ?>
        <table class="widefat striped" style="margin-bottom:32px">
            <thead>
                <tr><th width="60">Rank</th><th>Booth</th><th width="180">Pengunjung Hari Ini</th><th>Progress</th></tr>
            </thead>
            <tbody>
                <?php if (empty($lb)): ?>
                <tr><td colspan="4" style="text-align:center;color:#999">Belum ada presensi hari ini.</td></tr>
                <?php else: foreach ($lb as $idx => $row):
                    $medals = ['🥇','🥈','🥉'];
                    $rank   = $idx < 3 ? $medals[$idx] : '#'.($idx+1);
                    $pct    = round($row['total'] / $max_lb * 100);
                ?>
                <tr>
                    <td style="font-weight:700;font-size:16px"><?php echo $rank ?></td>
                    <td><strong>Booth <?php echo str_pad($row['booth'],3,'0',STR_PAD_LEFT) ?></strong></td>
                    <td><strong><?php echo $row['total'] ?> orang</strong></td>
                    <td>
                        <div style="background:#f0f0f1;border-radius:4px;height:8px;width:100%;overflow:hidden">
                            <div style="background:#0073aa;height:100%;width:<?php echo $pct ?>%;border-radius:4px"></div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>

        <!-- Tabel Data -->
        <h2>Data Presensi Terbaru (50 terakhir)</h2>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Booth</th><th>Nama</th><th>Instansi</th><th>Telepon</th><th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recent)): ?>
                <tr><td colspan="5" style="text-align:center;color:#999">Belum ada data presensi.</td></tr>
                <?php else: foreach ($recent as $r): ?>
                <tr>
                    <td><strong>Booth <?php echo str_pad($r['booth'],3,'0',STR_PAD_LEFT) ?></strong></td>
                    <td><?php echo esc_html($r['nama']) ?></td>
                    <td><?php echo esc_html($r['instansi']) ?></td>
                    <td><?php echo esc_html($r['telp']) ?></td>
                    <td><?php echo esc_html($r['waktu_fmt']) ?></td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// ─── Export CSV ───
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
